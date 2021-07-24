<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationModel extends Model
{
    //
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', "accuracy", "altitude", "altitudeAccuracy","heading","latitude","longitude","speed"
    ];

}