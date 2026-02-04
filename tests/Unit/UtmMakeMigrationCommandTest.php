<?php

use Illuminate\Support\Facades\File;

it('generates migration file', function () {
    $this->artisan('utm:make-migration')
        ->assertSuccessful();

    $files = File::glob(database_path('migrations/*_create_utm_visits_table.php'));

    expect($files)->not->toBeEmpty();
});

it('migration contains all configured UTM fields', function () {
    $this->artisan('utm:make-migration');

    $files = File::glob(database_path('migrations/*_create_utm_visits_table.php'));
    $content = File::get(end($files));

    expect($content)->toContain("utm_source");
    expect($content)->toContain("utm_medium");
    expect($content)->toContain("utm_campaign");
    expect($content)->toContain("utm_term");
    expect($content)->toContain("utm_content");
});

it('migration filename contains timestamp', function () {
    $this->artisan('utm:make-migration');

    $files = File::glob(database_path('migrations/*_create_utm_visits_table.php'));
    $filename = basename(end($files));

    // Timestamp format: Y_m_d_His
    expect($filename)->toMatch('/^\d{4}_\d{2}_\d{2}_\d{6}_create_utm_visits_table\.php$/');
});

afterEach(function () {
    // Clean up generated migration files
    $files = File::glob(database_path('migrations/*_create_utm_visits_table.php'));
    foreach ($files as $file) {
        File::delete($file);
    }
});
