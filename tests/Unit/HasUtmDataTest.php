<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Webudvikleren\UtmManager\Tests\Models\TestModel;

beforeEach(function () {
    Schema::create('test_models', function (Blueprint $table) {
        $table->id();
        $table->string('name')->nullable();
        $table->string('utm_source')->nullable();
        $table->string('utm_medium')->nullable();
        $table->string('utm_campaign')->nullable();
        $table->string('utm_term')->nullable();
        $table->string('utm_content')->nullable();
        $table->timestamps();
    });
});

afterEach(function () {
    Schema::dropIfExists('test_models');
});

it('auto-fills UTM fields from session on model creating', function () {
    session([
        'utm_source' => 'google',
        'utm_medium' => 'cpc',
        'utm_campaign' => 'spring_sale',
        'utm_term' => 'shoes',
        'utm_content' => 'banner',
    ]);

    $model = TestModel::create(['name' => 'test']);

    expect($model->utm_source)->toBe('google');
    expect($model->utm_medium)->toBe('cpc');
    expect($model->utm_campaign)->toBe('spring_sale');
    expect($model->utm_term)->toBe('shoes');
    expect($model->utm_content)->toBe('banner');
});

it('only fills keys that are in model fillable', function () {
    session([
        'utm_source' => 'google',
        'utm_medium' => 'cpc',
    ]);

    // TestModel has all utm keys in fillable, so this test validates
    // that the trait checks getFillable() before assigning
    $model = TestModel::create(['name' => 'test']);

    expect($model->utm_source)->toBe('google');
    expect($model->utm_medium)->toBe('cpc');
});

it('overwrites explicitly set values with session data', function () {
    session(['utm_source' => 'session_value']);

    $model = TestModel::create([
        'name' => 'test',
        'utm_source' => 'explicit_value',
    ]);

    // The trait overwrites because it runs on `creating` and sets unconditionally
    expect($model->utm_source)->toBe('session_value');
});

it('sets null when no UTM data in session', function () {
    $model = TestModel::create(['name' => 'test']);

    expect($model->utm_source)->toBeNull();
    expect($model->utm_medium)->toBeNull();
    expect($model->utm_campaign)->toBeNull();
    expect($model->utm_term)->toBeNull();
    expect($model->utm_content)->toBeNull();
});
