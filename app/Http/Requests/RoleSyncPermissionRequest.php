<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleSyncPermissionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "role_name" => [
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
            "role_name" => __("Role Name"),
            "permissions" => __("Permissions")
        ];
    }
}
