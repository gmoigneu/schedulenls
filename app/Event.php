<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {

	protected $fillable = [
		'name', 'email', 'organization', 'start', 'end', 'google_event', 'user_id', 'event_type_id'
	];
	
	/**
     * Get the user that owns the calendar.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the eventType
     */
    public function eventType()
    {
        return $this->belongsTo('App\EventType');
    }
}