<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model {
	public $timestamps = false;	

	protected $fillable = [
		'user_id', 'calendar_id', 'title'
	];
	
	/**
     * Get the user that owns the calen dar.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}