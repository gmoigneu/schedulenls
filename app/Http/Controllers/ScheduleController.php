<?php
namespace App\Http\Controllers;
 
use App\User;
use App\Calendar;
use App\EventType;
use App\Guest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Input;
use App\Helpers\ScheduleHelper;
use App\Http\Requests\StoreEvent;
use App\Notifications\EventScheduled;
use App\Notifications\EventGuestScheduled;

class ScheduleController extends Controller
{

    public function types(User $user)
    {
        return view('types', [
            'user' => $user,
            'eventTypes' => $user->eventTypes,
        ]);
    }

    public function schedule(User $user, EventType $eventType, $start = null)
    {
        // Init date range
    	try {
            $start = (!is_null($start)) ? new Carbon($start, $user->timezone) : Carbon::today($user->timezone);
        } catch (\Exception $e) {
            abort(421, 'Wrong parameter');
        }
        $end = Carbon::instance($start);
        $end->addDays(7);
    
        $scheduleHelper = new ScheduleHelper($user);
        $availableEvents = $scheduleHelper->getAvailableEvents($eventType, $start, $end);

    	$next = Carbon::instance($start, $user->timezone)->addDays(7)->format('Y-m-d');
        $previous = Carbon::instance($start, $user->timezone)->subDays(7)->format('Y-m-d');

        return view('schedule', [
            'user' => $user,
            'eventType' => $eventType,
            'start' => $start,
            'end' => $end,
        	'availableEvents' => $availableEvents,
            'duration' => $eventType->duration,
            'next' => action('ScheduleController@schedule', ['user' => $user, 'event' => $eventType, 'start' => $next]),
            'previous' => ($start > Carbon::today($user->timezone)) ? action('ScheduleController@schedule', ['user' => $user, 'event' => $eventType, 'start' => $previous]) : null,
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
            $eventType->id
        );

        $user->notify(new EventScheduled($event));
        $event->notify(new EventGuestScheduled($event));

        // This slot is available
        return view('create', [
            'event' => $event,
            'user' => $user
        ]);
    }
}