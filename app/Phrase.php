<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phrase extends Model
{
    //
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'id','phrase', 'status','treatment_id', 'current', 'patient_id'
    ];

    /**
     * Get the post that owns the comment.
     */
    public function Treatment()
    {
        return $this->belongsTo('App\Treatment');
    }

    
}
