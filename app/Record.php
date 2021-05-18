<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','path', 'name','phrase_id'
    ];

    /**
     * Get the post that owns the comment.
     */
    public function Phrase()
    {
        return $this->belongsTo('App\Phrase');
    }
}
