<?php

namespace EvoMark\EvoLaravelProfanity\Rules;

use Closure;
use EvoMark\EvoLaravelProfanity\Services\ProfanityService;
use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Validation\ValidationRule;

class Profanity implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $locale = App::currentLocale();
        $service = app(ProfanityService::class);
        $words = $service->getWords();
        $words = array_merge($words, config('profanity.includingWords')[$locale] ?? []);
        $words = array_diff($words, config('profanity.excludingWords')[$locale] ?? []);

        foreach ($words as $word) {
            if (preg_match('/(?<!\p{L})' . preg_quote($word, '/') . '(?!\p{L})/iu', $value) === 1) {
                $fail('validation.profanity');
            }
        }
    }
}
