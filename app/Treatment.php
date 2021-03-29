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
        'id','name','desc','phrase_id','record_id'
    ];
    

    public function Users() {
    	return $this->belongsToMany('App\User');
	}

	/**
     * Get the post that owns the comment.
     */
    public function Phrase()
    {
        return $this->belongsTo('App\Phrase');
    }

    /**
     * Get the phone associated with the user.
     */
    public function Record()
    {
        return $this->hasOne(Record::class);
    }

}
