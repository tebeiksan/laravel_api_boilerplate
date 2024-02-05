<?php

namespace App\Http\Resources;

use App\Helpers\UserHelper;
use Illuminate\Http\Request;

class UserResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "email" => $this->email,
            "name" => $this->name,
            "is_active" => $this->is_active,
            "is_active_desc" => __(UserHelper::ACTIVE_DESCRIPTION[$this->is_active]),
            "roles" => new RoleCollection($this->whenLoaded("masterRole")),
            "permissions" => new PermissionCollection($this->whenLoaded("masterPermission"))
        ];
    }
}
