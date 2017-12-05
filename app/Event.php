<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Event extends Model {

    use Notifiable;

	protected $fillable = [
		'name', 'email', 'organization', 'start', 'end', 'google_event', 'user_id', 'event_type_id', 'ip', 'token', 'confirmed'
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

    /**
     * Scope a query to only include confirmed events.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeConfirmed($query)
    {
        return $query->where('confirmed', '=', 1);
    }
}