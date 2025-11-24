<?php

namespace EvoMark\EvoLaravelProfanity\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Http;
use function Illuminate\Filesystem\join_paths;

class UpdateDefinitionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'profanity:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the profanity definitions for the package';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = storage_path('app/profanity');
        if (!File::exists($path)) {
            File::makeDirectory($path);
        }
        $response = Http::get("https://api.github.com/repos/pestphp/pest-plugin-profanity/contents/src/Config/profanities");
        $json = $response->json();
        $this->info("Updating profanity definitions...");
        $bar = $this->output->createProgressBar(count($json));
        $bar->start();

        $files = collect($json)->where('type', 'file')->values();
        $responses = Http::pool(function ($pool) use ($files) {
            return $files->map(
                fn($file) =>
                $pool->as($file['name'])->get($file['download_url'])
            )->toArray();
        });

        foreach ($files as $file) {
            $contents = $responses[$file['name']];
            File::put(join_paths($path, Str::lower($file['name'])), $contents->body());
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();
        $this->info("Profanity definitions updated!");
    }
}
