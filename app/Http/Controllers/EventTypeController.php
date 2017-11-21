<?php
namespace App\Http\Controllers;
 
use App\User;
use App\EventType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ScheduleHelper;
use App\Http\Requests\StoreEventType;

class EventTypeController extends Controller
{
    public function create()
    {
        return view('event_type.create');
    }

    public function edit($eventType)
    {
        $eventType = EventType::where('slug', $eventType)->where('user_id', Auth::user()->id)->firstOrFail();

        return view('event_type.edit', [
            'eventType' => $eventType
        ]);
    }

    public function store(StoreEventType $request)
    {
        Auth::user()->eventTypes()->create([
            'name' => $request->get('name'),
            'slug' => $request->get('slug'),
            'duration' => $request->get('duration'),
            'padding' => $request->get('padding'),
        ]);

        return redirect()->route('dashboard');
    }
    
    public function update(StoreEventType $request)
    {
        $eventType = EventType::where('slug', $request->get('slug'))->where('user_id', Auth::user()->id)->firstOrFail();

        $eventType->update($request->all());

        return redirect()->route('dashboard');
    }
}