<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Carbon;

class TimeCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return Carbon::createFromFormat('H:i', $value)->format('H:i:s');
    }
}
