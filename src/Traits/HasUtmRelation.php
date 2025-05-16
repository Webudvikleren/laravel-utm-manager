<?php

namespace Webudvikleren\UtmManager\Traits;

use Webudvikleren\UtmManager\Facades\Utm;

trait HasUtmRelation
{
    public static function bootHasUtmRelation()
    {
        static::created(function ($model) {
            if (method_exists($model, 'utmVisit')) {
                $model->utmVisit()->create(Utm::all());
            }
        });
    }
}
