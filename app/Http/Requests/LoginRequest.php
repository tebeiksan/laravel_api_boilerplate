<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "email" => [
                "bail",
                "required",
                "email"
            ],
            "password" => [
                "bail",
                "required"
            ]
        ];
    }

    public function attributes(): array
    {
        return [
            "email" => __("Email"),
            "password" => __("Password"),
        ];
    }
}
