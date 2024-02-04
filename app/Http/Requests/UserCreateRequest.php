<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => [
                "bail",
                "required"
            ],
            "email" => [
                "bail",
                "required",
                "email",
                Rule::unique(User::class, "email")
            ]
        ];
    }

    public function attributes(): array
    {
        return [
            "name" => __("User Name"),
            "email" => __("User Email"),
        ];
    }
}
