<?php

namespace Kishieel\RequestUnit\Tests\Fixture;

use Illuminate\Foundation\Http\FormRequest;

class FormRequestRules extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'property_1' => 'required|array',
            'property_2' => 'required|string',
            'property_3' => 'required|integer',
        ];
    }
}
