<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'timezone',
        'slug',
    ];

    public $timestamps = false;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the calendars for the user.
     */
    public function calendars()
    {
        return $this->hasMany('App\Calendar');
    }

    /**
     * Get the event types for the user.
     */
    public function eventTypes()
    {
        return $this->hasMany('App\EventType');
    }

    /**
     * Get the events for the user.
     */
    public function events()
    {
        return $this->hasMany('App\Event');
    }
}
