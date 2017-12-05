<?php

namespace App\Helpers;

use App\Google;
use App\User;
use App\EventType;
use App\Event;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use App\Helpers\DatePeriodHelper;

class ScheduleHelper {

    protected $user;
    protected $start;
    protected $end;
    protected $google;
    protected $client;
    protected $service;
    protected $interval;
    protected $eventInterval;
    protected $weekSchedule;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->google = new Google;

        $this->client = $this->google->client();
        $this->client->setAccessToken($user->token);
        $this->service = new \Google_Service_Calendar($this->client);

        // Set default config
        $this->interval = CarbonInterval::minutes(1); 
        $this->eventInterval = CarbonInterval::minutes(15);
        
        $this->weekSchedule = [
            'Mon' => [
                ['9:00', '12:00'],
                ['14:00', '17:00'],
            ],
            'Tue' => [
                ['9:30', '12:00'],
                ['14:00', '17:00'],
            ],
            'Wed' => [
                ['9:30', '12:00'],
                ['14:00', '17:00'],
            ],
            'Thu' => [
                ['9:30', '12:00'],
                ['14:00', '17:00'],
            ],
            'Fri' => [
                ['9:30', '12:00'],
                ['14:00', '17:00'],
            ],
            'Sat' => [],
            'Sun' => [],
        ];
    }

    public function refreshToken()
    {
        $refreshToken = json_decode($this->user->token)->refresh_token;
        $newToken = $this->client->refreshToken($refreshToken);
        $this->user->token = json_encode($newToken);
        $this->user->save();
        $this->google = new Google;
        $this->client = $this->google->client();
        $this->client->setAccessToken($newToken);
        $this->service = new \Google_Service_Calendar($this->client);
    }

    public function createEvent($start, $end, $name, $organization, $email, $eventType, $ip)
    {
        // Create the event
        $event = new \Google_Service_Calendar_Event(array(
            'summary' => $name . ' (' . $organization . ')',
            'location' => '',
            'description' => '',
            'start' => array(
                'dateTime' => $start->toAtomString(),
                'timeZone' => $this->user->timezone,
            ),
            'end' => array(
                'dateTime' => $end->toAtomString(),
                'timeZone' => $this->user->timezone,
            ),
            'attendees' => array(
                array('email' => $email),
                array('email' => $this->user->email),
            ),
            'reminders' => array(
                'useDefault' => FALSE,
                'overrides' => array(
                    array('method' => 'email', 'minutes' => 24 * 60),
                    array('method' => 'popup', 'minutes' => 10),
                ),
            ),
        ));

        $calendarId = $this->user->calendars()->first()->calendar_id;
        
        try {
            $event = $this->service->events->insert($calendarId, $event);
        } catch (\Google_Service_Exception $e) {
            $this->refreshToken();
            $event = $this->service->events->insert($calendarId, $event);
        }

        $userEvent = Event::create([
            'name' => $name,
            'email' => $email,
            'organization' => $organization,
            'start' => $start->toAtomString(),
            'end' => $end->toAtomString(),
            'google_event' => json_encode($event),
            'event_type_id' => $eventType,
            'user_id' => $this->user->id,
            'ip' => $ip,
            'confirmed' => 0,
            'token' => str_random(16),
        ]);

        return $userEvent;
    }

    public function getGoogleEvents(\DateTime $start, \DateTime $end)
    {
        $freeBusyRequest = new \Google_Service_Calendar_FreeBusyRequest();
        $freeBusyRequest->setTimeMin($start->format(\DateTime::ATOM));
        $freeBusyRequest->setTimeMax($end->format(\DateTime::ATOM));
        $freeBusyRequest->setTimeZone($this->user->timezone);

        $calendars = [];
        foreach ($this->user->calendars as $calendar) {
            $item = new \Google_Service_Calendar_FreeBusyRequestItem();
            $item->setId($calendar->calendar_id);
            $calendars[] = $item;
        }

        $freeBusyRequest->setItems($calendars);
        try {
            $freeBusy = $this->service->freebusy->query($freeBusyRequest);
        } catch (\Google_Service_Exception $e) {
            $this->refreshToken();
            $freeBusy = $this->service->freebusy->query($freeBusyRequest);
        }

        // Populate existing events
        $events = [];
        foreach ($this->user->calendars as $calendar) {
            $busyEvents = $freeBusy->calendars[$calendar->calendar_id]->busy;
            foreach ($busyEvents as $busyEvent) {
                $busyEventStart = new Carbon($busyEvent->start, $this->user->timezone);
                $busyEventEnd = new Carbon($busyEvent->end, $this->user->timezone);

                $events[] = new DatePeriodHelper($busyEventStart, $this->interval, $busyEventEnd);
            }
            
        }

        return $events;
    }

    public function getAvailableEvents(EventType $eventType, \DateTime $start, \DateTime $end)
    {
        $events = $this->getGoogleEvents($start, $end);
        $availableEvents = [];

        // Create all potential events
        foreach (new \DatePeriod($start, CarbonInterval::days(1), $end) as $day) {
            if ($day < Carbon::today($this->user->timezone)) {
                continue;
            }

            foreach ($this->weekSchedule[$day->format('D')] as $dayRange) {
                // Construct the period
                list($rangeStartTimeHour, $rangeStartTimeMinute) = explode(':', $dayRange[0]);
                list($rangeEndTimeHour, $rangeEndTimeMinute) = explode(':', $dayRange[1]);

                $rangeStart = Carbon::instance($day);
                $rangeStart->timezone($this->user->timezone);
                $rangeStart->setTime($rangeStartTimeHour, $rangeStartTimeMinute, 0);
                $rangeEnd = Carbon::instance($day);
                $rangeEnd->timezone($this->user->timezone);
                $rangeEnd->setTime($rangeEndTimeHour, $rangeEndTimeMinute, 0);
                $period = new DatePeriodHelper($rangeStart, $this->eventInterval, $rangeEnd);
                

                // Loop through the period and check if it overlaps an event
                foreach ($period as $potentialEvent) {
                    if ($potentialEvent->isPast()) {
                        continue;
                    }
                    $potentialEventEnd = clone($potentialEvent);
                    $potentialEventEnd->add(CarbonInterval::minutes($eventType->duration));

                    // Exit the loop if the event end time is out of the time range
                    if ($potentialEventEnd > $rangeEnd) {
                        break;
                    }

                    $potentialPeriod = new \DatePeriod($potentialEvent, CarbonInterval::minutes(15), $potentialEventEnd);
                    
                    $available = true;
                    foreach ($events as $event) {
                        if ($event->overlapsWithPeriod($potentialPeriod, $eventType->padding)) {
                            $available = false;
                        }
                    }
                    if ($available) {
                        $availableEvents[] = $potentialPeriod;
                    }
                }
            }
        }
        return $availableEvents;
    }

    public function checkAvaibility(\DateTime $start, \DateTime $end) {
        if($this->getGoogleEvents($start, $end)) {
            return false;
        }
        return true;
    }
}