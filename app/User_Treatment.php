<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_Treatment extends Model
{
    //
     //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'patient_id','treatment_id','record_id'
    ];
    

    public function Patient() {
    	return $this->belongsToMany('App\User');
	}    


	/**
     * Get the post that owns the comment.
     */
    public function Treatment()
    {
        return $this->belongsTo('App\Treatment');
    }

        /**
     * Get the phone associated with the user.
     */
    public function Record()
    {
        return $this->belongsTo('App\Record');
    }

    
}
