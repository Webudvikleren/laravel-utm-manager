<?php

namespace Webudvikleren\UtmManager\Traits;

use Webudvikleren\UtmManager\Facades\Utm;

trait HasUtmData
{
    public static function bootHasUtmData()
    {
        static::creating(function ($model) {
            foreach (Utm::all() as $key => $value) {
                if (in_array($key, $model->getFillable())) {
                    $model->$key = $value;
                }
            }
        });
    }
}
