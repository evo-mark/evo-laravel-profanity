<?php

namespace EvoMark\EvoLaravelProfanity\Services;

use ReflectionClass;
use Carbon\CarbonInterval;
use Illuminate\Support\Str;
use AhoCorasick\MultiStringMatcher;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Cache;

/**
 * Service class is only initialised when the rule is used in a validator
 */
class ProfanityService
{
    /**
     * An array of words to check input against
     */
    protected array $words;
    /**
     * Matcher instance can be reused across multiple input validations
     */
    protected MultiStringMatcher $matcher;

    public function __construct()
    {
        $this->words = $this->loadWordsFromSource();
    }

    private function loadWordsFromSource(): array
    {
        $locale = $this->getLocale();
        return Cache::remember('profanity_' . $locale, CarbonInterval::days(config('profanity.cacheDays')), function () {
            $configPath = $this->resolveWordsFile();
            return include $configPath ?? [];
        });
    }

    public function getWords(): array
    {
        return $this->words;
    }

    public function getMatcher(): MultiStringMatcher
    {
        if (!empty($this->matcher)) {
            return $this->matcher;
        }

        $locale = $this->getLocale();
        $words = $this->getWords();
        $words = array_merge($words, config('profanity.includingWords')[$locale] ?? []);
        $words = array_diff($words, config('profanity.excludingWords')[$locale] ?? []);

        $this->matcher = new MultiStringMatcher($words);
        return $this->matcher;
    }

    public function resolveWordsFile(): ?string
    {
        $locale = $this->getLocale();
        $files = File::glob(storage_path('app/profanity/*.php'));
        $wordsFile = collect($files)->firstWhere(fn($file) => Str::endsWith($file, $locale . ".php"));

        if (File::exists($wordsFile) === false && app()->isProduction() === false) {
            throw new \Exception("No words file found for locale '" . $locale . "'. Make sure you've added the `profanity:update` command to your composer.json 'post-autoload-dump' script. See README for more details");
        }

        return $wordsFile;
    }

    /**
     * Get the current locale (potentially overridden by config) as lowercase with underscores (e.g. pt_br)
     */
    public function getLocale(): string
    {
        $configLocale = config('profanity.locale');
        return str($configLocale ?? App::currentLocale())->lower()->replace("-", "_");
    }
}
