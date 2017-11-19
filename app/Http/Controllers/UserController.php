<?php
namespace App\Http\Controllers;

use App\Google;
use App\User;
use App\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
	protected $google;
	protected $client;
	protected $service;

	public function __construct(Google $google) {
		$this->google = $google;
	}

    public function init()
    {
    	$this->client = $this->google->client();
        $this->client->setAccessToken(Auth::user()->token);
        $this->service = new \Google_Service_Calendar($this->client);
    }

    public function index(Request $request)
    {
    	$this->init();

    	if(!Auth::user()->calendars()->count()) {
    		return redirect('/select');
    	}

    	$calendar = Auth::user()->calendars()->first();

    	$freebusy_req = new \Google_Service_Calendar_FreeBusyRequest();
    	$now = new \DateTime();
		$freebusy_req->setTimeMin($now->format(\DateTime::ATOM));
		$freebusy_req->setTimeMax($now->add(new \DateInterval('P7D'))->format(\DateTime::ATOM));
		$freebusy_req->setTimeZone('Europe/Paris');
		$item = new \Google_Service_Calendar_FreeBusyRequestItem();
		$item->setId($calendar->calendar_id);
		$freebusy_req->setItems([$item]);
    	$freeBusy = $this->service->freebusy->query(
    		$freebusy_req
    	);

    	$busy = $freeBusy->calendars[$calendar->calendar_id]->busy;
    	dd($busy);
    	
        return view('dashboard', [
        	'calendar' => $calendar
        ]);
    }

    public function showCalendars(Request $request) {
    	$this->init();

    	$calendars = $this->service->calendarList->listCalendarList()->getItems();
		return view('select', ['calendars' => $calendars]);
    }

    public function selectCalendar(Request $request) {
    	$this->init();

    	if (!$request->has('calendar')) {
    		throw new \Exception();
    	}
    	
    	$calendar = $this->service->calendarList->get($request->get('calendar'));
    	if ($calendar) {
			Auth::user()->calendars()->create([
			    'user_id' => Auth::user()->id,
			    'calendar_id' => $calendar->id,
			    'title' => $calendar->summary
			]);    		
			return redirect('/dashboard');
    	}
    }
}