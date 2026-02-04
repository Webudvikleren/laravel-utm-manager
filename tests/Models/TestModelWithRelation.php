<?php

namespace Webudvikleren\UtmManager\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Webudvikleren\UtmManager\Models\UtmVisit;
use Webudvikleren\UtmManager\Traits\HasUtmRelation;

class TestModelWithRelation extends Model
{
    use HasUtmRelation;

    protected $fillable = ['name'];

    public function utmVisit()
    {
        return $this->hasOne(UtmVisit::class);
    }
}
