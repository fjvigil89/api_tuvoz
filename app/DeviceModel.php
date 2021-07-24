<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceModel extends Model
{
    //
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', "isDevice", "brand", "manufacturer","modelName","modelId","designName","productName", "deviceYearClass", "totalMemory,", "supportedCpuArchitectures", "osName","osVersion", "osBuildId", "osInternalBuildId", "osBuildFingerprint","platformApiLevel", "deviceName",
    ];
}