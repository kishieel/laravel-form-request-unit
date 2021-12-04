<?php

namespace Kishieel\RequestUnit\Tests\Unit;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use Kishieel\RequestUnit\Tests\Fixture\FormRequestAuthorization;
use Kishieel\RequestUnit\Tests\Fixture\FormRequestRules;
use Kishieel\RequestUnit\ValidatorResponse;

it('should create validator', function () {
    expect($this->validator())->toBeInstanceOf(Validator::class);
});

it('should return validator response', function () {
    $formRequest = new FormRequestRules();

    expect($this->validate($formRequest, []))->toBeInstanceOf(ValidatorResponse::class);
});

it('should fail with invalid data', function () {
    $formRequest = new FormRequestRules();
    $result = $this->validate($formRequest, [
        'property_1' => 'string_not_array',
        'property_2' => null,
    ]);

    expect($result->passes())->toBeFalse();
    expect($result->errors())->toHaveKeys([
        'property_1', 'property_2', 'property_3'
    ]);
});

it('should pass with valid data', function () {
    $formRequest = new FormRequestRules();
    $result = $this->validate($formRequest, [
        'property_1' => [1,2,3],
        'property_2' => 'string',
        'property_3' => 1
    ]);

    expect($result->passes())->toBeTrue();
    expect($result->errors())->toBeEmpty();
});

it('should validate only against specified rules', function () {
    $formRequest = new FormRequestRules();
    $result = $this->validate($formRequest, [
        'property_1' => 'string_not_array',
        'property_2' => null,
    ], [
        'property_1'
    ]);

    expect($result->errors())->toHaveKeys(['property_1']);
    expect($result->errors())->not()->toHaveKeys(['property_2', 'property_3']);
});

it('should accept singular rule', function () {
    $formRequest = new FormRequestRules();
    $result = $this->validate($formRequest, [
        'property_1' => 'string_not_array',
        'property_2' => null,
    ], 'property_1');

    expect($result->errors())->toHaveKeys(['property_1']);
    expect($result->errors())->not()->toHaveKeys(['property_2', 'property_3']);
});

it('should fail when unauthorized', function () {
    $formRequest = new FormRequestAuthorization();

    Auth::shouldReceive('user')->once()->andReturn(false);
    $result = $this->validate($formRequest);

    expect($result->passes())->toBeFalse();
});

it('should pass when authorized', function () {
    $formRequest = new FormRequestAuthorization();

    Auth::shouldReceive('user')->once()->andReturn(true);
    $result = $this->validate($formRequest);

    expect($result->passes())->toBeTrue();
});
