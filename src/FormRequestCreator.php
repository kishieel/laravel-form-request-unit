<?php

namespace Kishieel\FormRequest;

use Illuminate\Foundation\Http\FormRequest;

class FormRequestCreator extends FormRequest
{
    /** @var array */
    protected $rules;

    /** @var null|callable */
    protected $authorize;

    /**
     * @param array $rules
     * @param callable|null $authorize
     */
    public function __construct(array $rules = [], ?callable $authorize = null)
    {
        parent::__construct();

        $this->rules = $rules;
        $this->authorize = $authorize;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return $this->rules;
    }

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return !is_callable($this->authorize) || ($this->authorize)();
    }

    /**
     * @param array $rules
     * @return \Kishieel\RequestUnit\FormRequestCreator
     */
    public function setRules(array $rules): self
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * @param callable $authorize
     * @return \Kishieel\RequestUnit\FormRequestCreator
     */
    public function setAuthorize(callable $authorize): self
    {
        $this->authorize = $authorize;

        return $this;
    }
}
