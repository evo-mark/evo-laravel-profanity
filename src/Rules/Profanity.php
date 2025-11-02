<?php

namespace EvoMark\EvoLaravelProfanity\Rules;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\ValidationRule;
use EvoMark\EvoLaravelProfanity\Services\ProfanityService;

class Profanity implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $service = app(ProfanityService::class);
        $matcher = $service->getMatcher();
        $matches = $matcher->searchIn(Str::lower($value));

        if (count($matches) > 0) {
            $fail('validation.profanity');
        }
    }
}
