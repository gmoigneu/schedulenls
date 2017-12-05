<?php
namespace App\Http\Controllers;
 
use App\User;
use App\Event;
use App\Calendar;
use App\EventType;
use App\Guest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cookie;
use App\Helpers\ScheduleHelper;
use App\Http\Requests\StoreEvent;
use App\Http\Requests\TimezoneRequest;
use App\Notifications\EventScheduled;
use App\Notifications\EventGuestScheduled;
use App\Notifications\EventGuestValidated;

class ScheduleController extends Controller
{

    public function types(User $user)
    {
        return view('types', [
            'user' => $user,
            'eventTypes' => $user->eventTypes,
        ]);
    }

    public function setTimezone(User $user, EventType $eventType, $start = null, TimezoneRequest $request)
    {
        Cookie::queue('timezone', Input::get('timezone'), 1440);
        return redirect()->route('schedule', ['user' => $user, 'eventType' => $eventType, 'start' => $start]);
    }

    public function schedule(User $user, EventType $eventType, $start = null)
    {

        if(Cookie::get('timezone')) {
            $timezone = Cookie::get('timezone');
        } else {
            $timezone = $user->timezone;
        }

        // Init date range
    	try {
            $start = (!is_null($start)) ? new Carbon($start, $user->timezone) : Carbon::today($user->timezone);
        } catch (\Exception $e) {
            abort(421, 'Wrong parameter');
        }
        $end = Carbon::instance($start, $user->timezone);
        $end->addDays(7);
    
        $scheduleHelper = new ScheduleHelper($user);

        $placeholders = new \DatePeriod($start, new \DateInterval('P1D'), $end);
        foreach ($placeholders as $placeholder) {
            $events[$placeholder->format('Y-m-d')] = null;
        }

        $availableEvents = $scheduleHelper->getAvailableEvents($eventType, $start, $end);
        foreach($availableEvents as $e) {
            $event = Carbon::instance($e->start)->setTimezone($timezone);
            $events[$event->format('Y-m-d')][] = $event;
        }

    	$next = Carbon::instance($start, $timezone)->addDays(7)->format('Y-m-d');
        $previous = Carbon::instance($start, $timezone)->subDays(7)->format('Y-m-d');

        return view('schedule', [
            'user' => $user,
            'timezone' => $timezone,
            'timezones' => \DateTimeZone::listIdentifiers(\DateTimeZone::ALL),
            'eventType' => $eventType,
            'start' => $start,
            'end' => $end,
        	'availableEvents' => $events,
            'duration' => $eventType->duration,
            'next' => action('ScheduleController@schedule', ['user' => $user, 'event' => $eventType, 'start' => $next]),
            'previous' => ($start > Carbon::today($timezone)) ? action('ScheduleController@schedule', ['user' => $user, 'event' => $eventType, 'start' => $previous]) : null,
        ]);
    }

    public function book(User $user, EventType $eventType, $datetime)
    {
        try {
            $event = Carbon::parse($datetime);
        } catch (\Exception $e) {
            abort(421, 'Wrong parameter');
        }

        // Check the event is available
        $eventStart = Carbon::instance($event);
        $eventEnd = Carbon::instance($event)->add(CarbonInterval::minutes($eventType->duration));
        $eventStartPadded = Carbon::instance($eventStart)->sub(CarbonInterval::minutes($eventType->padding));
        $eventEndPadded = Carbon::instance($eventEnd)->add(CarbonInterval::minutes($eventType->padding));

        $scheduleHelper = new ScheduleHelper($user);

        // This slot is not available!
        if (!$scheduleHelper->checkAvaibility($eventStartPadded, $eventEndPadded)) {
            return redirect()->route('schedule', ['user' => $user, 'event' => $eventType])->with('error', 'This slot is not available');
        }

        // This slot is available
        return view('book', [
            'user' => $user,
            'eventType' => $eventType,
            'start' => $eventStart,
            'end' => $eventEnd,
        ]);
    }

    public function create(StoreEvent $request)
    {
        $user = User::where('slug', $request->get('user'))->first();
        $eventType = EventType::where('slug', $request->get('eventType'))->first();
        
        if (!$user) {
            abort(421, 'Missing user');
        }

        try {
            $event = Carbon::parse($request->get('start'));
        } catch (\Exception $e) {
            abort(421, 'Date is malformed');
        }

        // Check the event is available
        $eventStart = Carbon::instance($event);
        $eventEnd = Carbon::instance($event)->add(CarbonInterval::minutes($eventType->duration));
        $eventStartPadded = Carbon::instance($eventStart)->sub(CarbonInterval::minutes($eventType->padding));
        $eventEndPadded = Carbon::instance($eventEnd)->add(CarbonInterval::minutes($eventType->padding));

        $scheduleHelper = new ScheduleHelper($user);

        // This slot is not available!
        if (!$scheduleHelper->checkAvaibility($eventStartPadded, $eventEndPadded)) {
            return redirect()->route('schedule', ['user' => $user, 'event' => $eventType])->with('error', 'This slot is not available');
        }

        $event = $scheduleHelper->createEvent(
            $eventStart,
            $eventEnd,
            $request->get('name'),
            $request->get('organization'),
            $request->get('email'),
            $request->get('summary'),
            $eventType->id,
            $request->ip()
        );

        $event->notify(new EventGuestScheduled($event));

        // This slot is available
        return view('create', [
            'event' => $event,
            'user' => $user
        ]);
    }

    public function confirm(User $user, Event $event, $token)
    {
        if ($event->token != $token) {
            abort(403);
        }

        if($event->confirmed == 1) {
            abort(404);
        }

        $event->confirmed = 1;
        $event->save();

        $event->user->notify(new EventScheduled($event));
        $event->notify(new EventGuestValidated($event));

        // This slot is available
        return view('confirm', [
            'event' => $event,
            'user' => $event->user
        ]);
    }
}