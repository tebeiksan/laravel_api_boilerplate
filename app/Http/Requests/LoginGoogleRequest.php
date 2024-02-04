<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginGoogleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "access_token" => [
                "bail",
                "required",
            ]
        ];
    }

    public function attributes(): array
    {
        return [
            "access_token" => __("Access Token"),
        ];
    }
}
