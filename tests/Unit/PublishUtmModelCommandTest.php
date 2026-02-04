<?php

use Illuminate\Support\Facades\File;

it('copies stub to app/Models/UtmVisit.php', function () {
    $targetPath = app_path('Models/UtmVisit.php');

    // Ensure it doesn't already exist
    if (File::exists($targetPath)) {
        File::delete($targetPath);
    }

    $this->artisan('utm:publish-model')
        ->assertSuccessful();

    expect(File::exists($targetPath))->toBeTrue();

    $content = File::get($targetPath);
    expect($content)->toContain('namespace App\Models');
    expect($content)->toContain('class UtmVisit');
});

it('shows success message', function () {
    $targetPath = app_path('Models/UtmVisit.php');

    if (File::exists($targetPath)) {
        File::delete($targetPath);
    }

    $this->artisan('utm:publish-model')
        ->expectsOutputToContain('UtmVisit model published')
        ->assertSuccessful();
});

afterEach(function () {
    $targetPath = app_path('Models/UtmVisit.php');
    if (File::exists($targetPath)) {
        File::delete($targetPath);
    }

    // Clean up empty Models directory if created
    $modelsDir = app_path('Models');
    if (File::isDirectory($modelsDir) && empty(File::files($modelsDir))) {
        File::deleteDirectory($modelsDir);
    }
});
