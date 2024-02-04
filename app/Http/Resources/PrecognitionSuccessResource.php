<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PrecognitionSuccessResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->resource,
            'errors' => null
        ];
    }

    public function withResponse(Request $request, JsonResponse $response): void
    {
        $response->header('Precognition-Success', 'true');
    }
}
