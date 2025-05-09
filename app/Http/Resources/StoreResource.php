<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
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
            'store_no' => $this->store_no,
            'store_name' => $this->store_name,
            'store_address' => $this->store_address,
            'store_phone' => $this->store_phone,
            'store_email' => $this->store_email,
            'store_telegram' => $this->store_telegram,
            'manager' => UserResource::make($this->whenLoaded('manager')),
            'employee' => UserResource::collection($this->whenLoaded('employee')),
            'created_at' => new DateResource($this->created_at),
            'updated_at' => new DateResource($this->updated_at)
        ];
    }
}
