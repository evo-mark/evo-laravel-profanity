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
        if (! File::exists($path)) {
            File::makeDirectory($path);
        }
        $response = Http::get('https://api.github.com/repos/pestphp/pest-plugin-profanity/contents/src/Config/profanities');
        $json = $response->json();
        $this->info('Updating profanity definitions...');
        $bar = $this->output->createProgressBar(count($json));
        $bar->start();
        foreach ($json as $file) {
            if ($file['type'] === 'file') {
                $contents = Http::get($file['download_url']);
                File::put(join_paths($path, Str::lower($file['name'])), $contents);
                $bar->advance();
            }
        }
        $bar->finish();
        $this->info('Profanity definitions updated!');
    }
}
