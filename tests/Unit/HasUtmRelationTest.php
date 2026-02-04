<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Webudvikleren\UtmManager\Tests\Models\TestModelWithRelation;
use Webudvikleren\UtmManager\Models\UtmVisit;

beforeEach(function () {
    Schema::create('test_model_with_relations', function (Blueprint $table) {
        $table->id();
        $table->string('name')->nullable();
        $table->timestamps();
    });

    Schema::create('utm_visits', function (Blueprint $table) {
        $table->id();
        $table->foreignId('test_model_with_relation_id')->nullable();
        $table->string('utm_source')->nullable();
        $table->string('utm_medium')->nullable();
        $table->string('utm_campaign')->nullable();
        $table->string('utm_term')->nullable();
        $table->string('utm_content')->nullable();
        $table->timestamps();
    });
});

afterEach(function () {
    Schema::dropIfExists('utm_visits');
    Schema::dropIfExists('test_model_with_relations');
});

it('creates UtmVisit record after model creation when UTM data exists', function () {
    session([
        'utm_source' => 'google',
        'utm_medium' => 'cpc',
        'utm_campaign' => 'spring_sale',
    ]);

    $model = TestModelWithRelation::create(['name' => 'test']);

    expect($model->utmVisit)->not->toBeNull();
    expect($model->utmVisit->utm_source)->toBe('google');
    expect($model->utmVisit->utm_medium)->toBe('cpc');
    expect($model->utmVisit->utm_campaign)->toBe('spring_sale');
});

it('does not create UtmVisit when no UTM data in session', function () {
    $model = TestModelWithRelation::create(['name' => 'test']);

    expect($model->utmVisit)->toBeNull();
    expect(UtmVisit::count())->toBe(0);
});

it('has utmVisit relationship method', function () {
    $model = new TestModelWithRelation();

    expect(method_exists($model, 'utmVisit'))->toBeTrue();
    expect($model->utmVisit())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasOne::class);
});
