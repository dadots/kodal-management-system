<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TenantResource extends JsonResource
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
            'slug' => $this->slug,
            'legal_name' => $this->legal_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'logo_path' => $this->logo_path,
            'timezone' => $this->timezone,
            'currency' => $this->currency,
            'locale' => $this->locale,
            'status' => $this->status,
            'settings' => $this->settings,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
