<?php

use Illuminate\Foundation\Http\FormRequest;
use Kishieel\FormRequest\FormRequestCreator;

it('should be instance of form request', function () {
    expect(new FormRequestCreator())->toBeInstanceOf(FormRequest::class);
});

it('should return given rules array', function () {
    $rules = ['property_1' => 'string'];

    $formRequest = (new FormRequestCreator())
        ->setRules($rules);

    expect(method_exists($formRequest, 'rules'))->toBeTrue();
    expect($formRequest->rules())->toMatchArray($rules);
});

it('should return result of given authorize callback', function () {
    $authorize = function () {
        return true;
    };

    $formRequest = (new FormRequestCreator())
        ->setAuthorize($authorize);

    expect(method_exists($formRequest, 'authorize'))->toBeTrue();
    expect($formRequest->authorize())->toEqual($authorize());
});

it('should be possible to validate', function () {
    $rules = ['property_1' => 'required'];

    $formRequest = (new FormRequestCreator())
        ->setRules($rules);

    $errors = $this
        ->validate($formRequest)
        ->errors();

    expect($errors)->toHaveKeys(['property_1']);
});

it('should be possible to authorize', function () {
    $formRequest = (new FormRequestCreator())
        ->setAuthorize(function () {
            return false;
        });

    $passes = $this
        ->validate($formRequest)
        ->passes();

    expect($passes)->toBeFalse();
});
