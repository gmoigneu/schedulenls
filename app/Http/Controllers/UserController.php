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
    	
        return view('dashboard', [
            'eventTypes' => Auth::user()->eventTypes
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
            $deletedRows = Calendar::where('user_id', Auth::user()->id)->delete();
			Auth::user()->calendars()->create([
			    'user_id' => Auth::user()->id,
			    'calendar_id' => $calendar->id,
			    'title' => $calendar->summary
			]);    		
			return redirect('/dashboard');
    	}
    }
}