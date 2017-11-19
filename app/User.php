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
        'email'
    ];

    public $timestamps = false;

    /**
     * Get the calendars for the user.
     */
    public function calendars()
    {
        return $this->hasMany('App\Calendar');
    }
}
