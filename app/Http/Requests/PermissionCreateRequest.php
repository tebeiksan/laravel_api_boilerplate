<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionCreateRequest extends FormRequest
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
            "description" => [
                "bail",
                "required"
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            "name" => __("Permission Name"),
            "description" => __("Permission Description"),
        ];
    }
}
