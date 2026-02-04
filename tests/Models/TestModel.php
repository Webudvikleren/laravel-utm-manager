<?php

namespace Webudvikleren\UtmManager\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Webudvikleren\UtmManager\Traits\HasUtmData;

class TestModel extends Model
{
    use HasUtmData;

    protected $fillable = [
        'name',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
    ];
}
