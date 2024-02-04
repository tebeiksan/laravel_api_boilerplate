<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "description" => [
                "bail",
                "required"
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            "description" => __("Permission Name"),
        ];
    }
}
