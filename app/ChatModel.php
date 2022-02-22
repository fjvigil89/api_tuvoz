<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatModel extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','identificador','msg','user_id'
   ];

   public function toArray()
   {
       $array = parent::toArray();
       $array['user_id'] = User::where('id', $array['user_id'])->first();
      
       return $array;
   }
}
