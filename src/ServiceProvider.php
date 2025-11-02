<?php

namespace EvoMark\EvoLaravelProfanity;

use Spatie\LaravelPackageTools\Package;
use Illuminate\Support\Facades\Validator;
use EvoMark\EvoLaravelProfanity\Rules\Profanity;
use EvoMark\EvoLaravelProfanity\Services\ProfanityService;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Illuminate\Translation\PotentiallyTranslatedString;

class ServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('evo-laravel-profanity')
            ->hasConfigFile('profanity');
    }

    public function packageBooted()
    {
        Validator::extend('profanity', function ($attribute, $value, $parameters, $validator) {
            $rule = new Profanity;
            $fail = function ($message) use ($attribute, $validator) {
                $message = new PotentiallyTranslatedString($message, $validator->getTranslator());
                return $validator->messages()->add($attribute, (string)$message->translate());
            };
            $rule->validate($attribute, $value, $fail);
            return !$validator->messages()->has($attribute);
        });
    }
}
