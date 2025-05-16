<?php

namespace Webudvikleren\UtmManager\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UtmMakeMigrationCommand extends Command
{
    protected $signature = 'utm:make-migration';
    protected $description = 'Generate a migration for storing UTM visit data';

    public function handle()
    {
        $timestamp = now()->format('Y_m_d_His');
        $filename = "{$timestamp}_create_utm_visits_table.php";
        $path = database_path("migrations/{$filename}");

        $utmFields = collect(config('utm.utm_keys'))
            ->map(fn($field) => "\$table->string('{$field}')->nullable();")
            ->implode("\n            ");

        $stub = <<<EOT
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('utm_visits', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('user_id')->constrained()->onDelete('cascade');

            {$utmFields}

            \$table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('utm_visits');
    }
};
EOT;

        File::put($path, $stub);
        $this->info("Migration created: {$filename}");
    }
}
