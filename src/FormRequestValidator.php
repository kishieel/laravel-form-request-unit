<?php

namespace Kishieel\RequestUnit;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

trait FormRequestValidator
{
    /**
     * @param array $data
     * @param array $rules
     * @param array $messages
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return \Illuminate\Validation\Validator
     */
    protected function validator(array $data = [], array $rules = [], array $messages = []): Validator
    {
        return app()->get('validator')->make($data, $rules, $messages);
    }

    /**
     * @param \Illuminate\Foundation\Http\FormRequest $formRequest
     * @param array $against
     * @param array|string $only
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return \Kishieel\RequestUnit\ValidatorResponse
     */
    protected function validate(FormRequest $formRequest, array $against = [], $only = []): ValidatorResponse
    {
        if (! is_array($only)) {
            $only = [$only];
        }

        /** @var array $formRules */
        $formRules = method_exists($formRequest, 'rules')
            ? $formRequest->rules()
            : [];

        $rules = empty($only)
            ? $formRules
            : array_intersect_key($formRules, array_flip($only));

        $validator = $this->validator($against, $rules, $formRequest->messages());

        $isValid = $validator->passes();
        $isAuthorized = !method_exists($formRequest, 'authorize') || $formRequest->authorize();

        $passes = $isValid && $isAuthorized;

        return new ValidatorResponse(
            $passes,
            $validator->errors()->toArray()
        );
    }
}
