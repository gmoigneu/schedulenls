<?php
namespace App\Http\Controllers;

use App\Google;
use App\User;
use App\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SettingsSlug;
use App\Http\Requests\SettingsTimezone;


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
			
			$calendars = $this->service->calendarList->listCalendarList()->getItems();
			// Filter only the user calendars
			$calendars = array_filter(
				$calendars,
				function($value) {
					return ($value['accessRole'] == 'owner');
				}
			);

			if (count($calendars) == 1) {
				// Only one calendar is writeable so we use that one
				$calendar = array_pop($calendars);
				Auth::user()->calendars()->create([
					'user_id' => Auth::user()->id,
					'calendar_id' => $calendar->id,
					'title' => $calendar->summary
				]);    
			} else {
				// Let the user select the correct one
				return view('select', [
					'calendars' => $calendars,
					'currentCalendar' => null
				]);
			}
    	}
    	
        return view('dashboard', [
            'events' => Auth::user()->events
        ]);
    }

    public function showCalendars(Request $request) {
    	$this->init();

		$calendars = $this->service->calendarList->listCalendarList()->getItems();
		
		// Filter only the user calendars
		$calendars = array_filter(
			$calendars,
			function($value) {
				return ($value['accessRole'] == 'owner');
			}
		);

		$userCalendar = Auth::user()->calendars;
		
		return view('select', [
			'calendars' => $calendars,
			'currentCalendar' => ($userCalendar->count()) ? $userCalendar->first()->calendar_id : null
		]);
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
	
	public function archiveNotifications(Request $request)
	{
		Auth::user()->unreadNotifications->markAsRead();
		return redirect()->back();
	}

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
	}
	
	public function showSettings()
	{
		return view('settings', [
			'user' => Auth::user(),
			'timezones' => \DateTimeZone::listIdentifiers(\DateTimeZone::ALL)
		]);
	}

	public function updateSlug(SettingsSlug $request)
	{
		Auth::user()->slug = $request->get('slug');
		Auth::user()->save();

		return redirect()->route('settings');
	}

	public function updateTimezone(SettingsTimezone $request)
	{
		Auth::user()->timezone = $request->get('timezone');
		Auth::user()->save();

		return redirect()->route('settings');
	}
}