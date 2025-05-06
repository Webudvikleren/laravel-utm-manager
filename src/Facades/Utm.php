<?php

namespace Webudvikleren\UtmManager\Facades;

use Illuminate\Support\Facades\Facade;

class Utm extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'utm';
    }
}
