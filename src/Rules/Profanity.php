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
        $value = Str::lower($value);

        $service = app(ProfanityService::class);
        $matcher = $service->getMatcher();
        $matches = $matcher->searchIn($value);

        if (count($matches) > 0) {
            $useWholeWordMatching = config('profanity.wholeWordMatching', false);

            if (!$useWholeWordMatching) {
                $fail('validation.profanity');
                return;
            }

            foreach ($matches as [$index, $word]) {
                if ($service->isWholeWord($value, $index, $word)) {
                    $fail('validation.profanity');
                    return;
                }
            }
        }
    }
}
