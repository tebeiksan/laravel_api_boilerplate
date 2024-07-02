<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class MaintenanceResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "maintenance" => app()->maintenanceMode()->active() ? true : false
        ];
    }
}
