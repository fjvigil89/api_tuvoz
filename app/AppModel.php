<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppModel extends Model
{
    //
     //
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name', 'version','url', 'descargas'
   ];
}