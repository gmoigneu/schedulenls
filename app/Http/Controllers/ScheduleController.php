<?php
namespace App\Http\Controllers;

use App\Google;
use App\User;
use App\Calendar;
use Illuminate\Http\Request;
use App\Helpers\DatePeriodHelper;

class ScheduleController extends Controller
{
    protected $google;
	protected $client;
	protected $service;

	public function __construct(Google $google) {
		$this->google = $google;
	}

    public function init($user)
    {
    	$this->client = $this->google->client();
        $this->client->setAccessToken($user->token);
        $this->service = new \Google_Service_Calendar($this->client);
    }

    public function index(Request $request, $user)
    {
    	$user = User::findOrFail($user);

    	$this->init($user);
        $timezone = 'Europe/Paris';

    	$freebusy_req = new \Google_Service_Calendar_FreeBusyRequest();
    	$start = new \DateTime();
        $start->setTime(0,0,0);
        $end = new \DateTime();
        $end->add(new \DateInterval('P6D'));
		$freebusy_req->setTimeMin($start->format(\DateTime::ATOM));
		$freebusy_req->setTimeMax($end->format(\DateTime::ATOM));
		$freebusy_req->setTimeZone($timezone);
		
		$calendars = [];
		foreach ($user->calendars as $calendar) {
			$item = new \Google_Service_Calendar_FreeBusyRequestItem();
			$item->setId($calendar->calendar_id);
			$calendars[] = $item;
		}

		$freebusy_req->setItems($calendars);

    	$freeBusy = $this->service->freebusy->query($freebusy_req);

        // Set default config
        $interval = new \DateInterval('PT1M');
        $eventInterval = new \DateInterval('PT15M');
        $padding = new \DateInterval('PT30M');
        $eventDuration = new \DateInterval('PT30M');
        $weekSchedule = [
            'Mon' => [
                ['9:30', '12:00'],
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
            'Sat' => [
                ['9:30', '12:00'],
            ],
            'Sun' => [],
        ];

        // Populate existing events
    	$events = [];
    	foreach ($user->calendars as $calendar) {
    		$busyEvents = $freeBusy->calendars[$calendar->calendar_id]->busy;
            foreach ($busyEvents as $busyEvent) {
                $busyEventStart = new \DateTime($busyEvent->start);
                $busyEventStart->setTimeZone(new \DateTimeZone($timezone));
                $busyEventStart->sub($padding);
                $busyEventEnd = new \DateTime($busyEvent->end);
                $busyEventEnd->setTimeZone(new \DateTimeZone($timezone));
                $busyEventEnd->add($padding);

                $events[] = new DatePeriodHelper($busyEventStart, $interval, $busyEventEnd);
            }
            
    	}

        $availableEvents = [];
        $placeholders = new \DatePeriod($start, new \DateInterval('P1D'), $end);
        foreach ($placeholders as $placeholder) {
            $availableEvents[$placeholder->format('Y-m-d')] = null;
        }


        // Create all potential events
        foreach (new \DatePeriod($start, new \DateInterval('P1D'), $end) as $day) {
            foreach ($weekSchedule[$day->format('D')] as $dayRange) {
                // Construct the period
                list($rangeStartTimeHour, $rangeStartTimeMinute) = explode(':', $dayRange[0]);
                list($rangeEndTimeHour, $rangeEndTimeMinute) = explode(':', $dayRange[1]);
                $rangeStart = clone($day);
                $rangeStart->setTimeZone(new \DateTimeZone($timezone));
                $rangeStart->setTime($rangeStartTimeHour, $rangeStartTimeMinute, 0);
                $rangeEnd = clone($day);
                $rangeEnd->setTimeZone(new \DateTimeZone($timezone));
                $rangeEnd->setTime($rangeEndTimeHour, $rangeEndTimeMinute, 0);
                $period = new DatePeriodHelper($rangeStart, $eventInterval, $rangeEnd);

                // Loop through the period and check if it overlaps an event
                foreach ($period as $potentialEvent) {
                    $potentialEventEnd = clone($potentialEvent);
                    $potentialEventEnd->add($eventDuration);
                    $potentialPeriod = new \DatePeriod($potentialEvent, new \DateInterval('PT1M'), $potentialEventEnd);
                    
                    $available = true;
                    foreach ($events as $event) {
                        if ($event->overlapsWithPeriod($potentialPeriod)) {
                            $available = false;
                        }
                    }
                    if ($available) {
                        $availableEvents[$potentialPeriod->start->format('Y-m-d')][] = $potentialPeriod;
                    }
                }
            }
        }

        \Debugbar::info($availableEvents);
    	
        return view('schedule', [
            'start' => $start,
            'end' => $end,
        	'availableEvents' => $availableEvents,
            'duration' => $eventDuration,
        ]);
    }
}