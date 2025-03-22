<?php

namespace App\Http\Resources;

use App\Http\Resources\ApiBaseResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OpenApiSpecResource extends ApiBaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'content' => json_encode($this->content, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT), // JSON文字列として返却
        ];
    }
}
