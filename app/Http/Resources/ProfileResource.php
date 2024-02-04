<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class ProfileResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "email" => $this->email,
            "name" => $this->name,
        ];
    }
}
