<?php

use Illuminate\Support\Facades\Validator;
use EvoMark\EvoLaravelProfanity\Rules\Profanity;

it('allows terms without profanity', function () {
    $rule = new Profanity;
    $validator = Validator::make([
        'name' => 'Hello World',
    ], [
        'name' => [$rule],
    ]);

    expect($validator->passes())->toBeTrue();
});

it('fails terms with profanity', function () {
    $rule = new Profanity;
    $validator = Validator::make([
        'name' => 'Fucker',
    ], [
        'name' => [$rule],
    ]);

    expect($validator->passes())->toBeFalse();
    expect($validator->errors()->first('name'))->toBe('validation.profanity');
});
