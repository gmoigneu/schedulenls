<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class EventType extends Model {
	public $timestamps = false;	
	protected $table = 'eventtypes';

	protected $fillable = [
		'duration', 'name', 'padding', 'slug'
	];
	
	/**
     * Get the user that owns the calen dar.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the events for the type.
     */
    public function events()
    {
        return $this->hasMany('App\Event');
    }

    /**
	 * Get the route key for the model.
	 *
	 * @return string
	 */
	public function getRouteKeyName()
	{
	    return 'slug';
	}

    public function getLinkAttribute($value)
    {
    	return action(
    		'ScheduleController@schedule',
    		[
    			'user' => $this->user,
    			'eventType' => $this,
    		]
    	);
    }
}