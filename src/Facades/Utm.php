<?php

namespace Webudvikleren\UtmManager\Facades;

use Illuminate\Support\Facades\Facade;

class Utm extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'utm';
    }

    public static function hasAny(): bool
    {
        $utmData = Utm::all();
        foreach ($utmData as $value) {
            if (!is_null($value) && $value !== '') {
                return true;
            }
        }

        return false;
    }
}
