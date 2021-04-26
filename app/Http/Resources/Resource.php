<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Constants\Concerns\HasEnumValues;
use MyCLabs\Enum\Enum;

class Resource extends Enum
{

    public const GUEST = 'home';
    public const TREATMENT = 'treatment.index';
    public const ADMIN = 'api';
    

    public static function supported(): array
    {
        return collect(static::toArray())->values()->toArray();
    }


}
