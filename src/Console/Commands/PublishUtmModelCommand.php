<?php

namespace Webudvikleren\UtmManager\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use function Webudvikleren\UtmManager\Commands\app_path;

class PublishUtmModelCommand extends Command
{
    protected $signature = 'utm:publish-model';
    protected $description = 'Publish the default UtmVisit model into your app/Models directory';

    public function handle()
    {
        $filesystem = new Filesystem();

        $targetPath = app_path('Models/UtmVisit.php');
        $stubPath = __DIR__ . '/../../../stubs/UtmVisit.stub';

        if ($filesystem->exists($targetPath)) {
            if (! $this->confirm('UtmVisit.php already exists. Overwrite?', false)) {
                $this->info('Cancelled.');
                return;
            }
        }

        $filesystem->ensureDirectoryExists(dirname($targetPath));
        $filesystem->copy($stubPath, $targetPath);

        $this->info('✅ UtmVisit model published to app/Models/UtmVisit.php');
    }
}
