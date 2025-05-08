<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'f_name' => $this->resource->f_name,
            'l_name' => $this->resource->l_name,
            'email' => $this->resource->email,
            'phone' => $this->resource->phone,
            'email_verified_at' => $this->resource->email_verified_at,
            'store' => [],
            'role' => RoleResource::make($this->whenLoaded('role')),
            'created_at' => new DateResource($this->resource->created_at),
            'updated_at' => new DateResource($this->resource->updated_at)
        ];
    }
}
