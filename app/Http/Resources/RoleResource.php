<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'permission' => PermissionResource::collection($this->whenLoaded('permission')),
            'user'=>$this->user,
            'created_at' => new DateResource($this->resource->created_at),
            'updated_at' => new DateResource($this->resource->updated_at),
        ];
    }
}
