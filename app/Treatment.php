<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name','desc', 'status', 'specialist_id'
    ];
    

    public function Specialist() {
    	return $this->belongsToMany('App\User', 'specialist_id', 'id' );
	}    


    public function Patinet_Treatment() {
    	return $this->belongsToMany('App\User_Treatment');
	}

    public function User() {
    	return $this->belongsToMany('App\User');
	}

   


	

}
