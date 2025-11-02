<?php

namespace EvoMark\EvoLaravelProfanity\Services;

use Illuminate\Support\Facades\App;
use ReflectionClass;

use function Illuminate\Filesystem\join_paths;

class ProfanityService
{
    protected array $words;

    public function __construct()
    {
        $configPath = $this->resolveConfig();
        $this->words = require $configPath;
    }

    public function getWords(): array
    {
        return $this->words;
    }

    public function resolveConfig(): string
    {
        $locale = $this->getLocale();
        $ref = new ReflectionClass(\Pest\Profanity\ProfanityAnalyser::class);
        $packageBase = dirname($ref->getFileName());

        return join_paths($packageBase, 'Config', 'profanities', $locale . '.php');
    }

    public function getLocale(): string
    {
        $configLocale = config('profanity.locale');
        return $configLocale ?? App::currentLocale();
    }
}
