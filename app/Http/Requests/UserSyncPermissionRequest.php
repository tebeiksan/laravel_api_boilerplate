<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSyncPermissionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "user_id" => [
                "bail",
                "required"
            ],
            "permissions" => [
                "bail",
                "nullable",
                "array"
            ]
        ];
    }

    public function attributes(): array
    {
        return [
            "user_id" => __("User ID"),
            "permissions" => __("Permissions"),
        ];
    }
}
