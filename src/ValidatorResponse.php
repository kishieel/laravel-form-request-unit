<?php

namespace Kishieel\FormRequest;

class ValidatorResponse
{
    /** @var bool */
    private $passes;

    /** @var array */
    private $errors;

    public function __construct(bool $passes, array $errors)
    {
        $this->passes = $passes;
        $this->errors = $errors;
    }

    /**
     * @return bool
     */
    public function passes(): bool
    {
        return $this->passes;
    }

    /**
     * @return array
     */
    public function errors(): array
    {
        return $this->errors;
    }
}
