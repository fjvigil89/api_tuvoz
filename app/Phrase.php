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
         'id','phrase',
    ];
}
