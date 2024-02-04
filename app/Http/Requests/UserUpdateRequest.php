<?php

namespace App\Http\Requests;

use App\Helpers\UserHelper;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
                Rule::unique(User::class, "email")->ignore($this->user)
            ],
            "is_active" => [
                "bail",
                "required",
                Rule::in(array_keys(UserHelper::ACTIVE_DESCRIPTION))
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
