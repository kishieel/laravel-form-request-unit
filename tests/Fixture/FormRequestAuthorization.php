<?php

namespace Kishieel\FormRequest\Tests\Fixture;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class FormRequestAuthorization extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return !!Auth::user();
    }
}
