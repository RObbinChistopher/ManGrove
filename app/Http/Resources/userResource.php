<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class userResource extends JsonResource
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
            'name' => $this->name ?? "",
            'role' => $this->role ?? "",
            'agent_id' => $this->agent_id  ?? "",
            'email' => $this->email ?? "",
            'phone' => $this->phone ?? "",
            'profile' => $this->profile ?? "",
            'cnic' => $this->cnic ?? "",
            'driving_licence' => $this->driving_licence ?? "",
            'property_documents' => $this->property_documents ?? "",
        ];
    }
}
