<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListPhrase extends Model
{
    //
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','phrase','treatment_id'
   ];

   /**
    * Get the post that owns the comment.
    */
   public function Treatment()
   {
       return $this->belongsTo('App\Treatment');
   }
}
