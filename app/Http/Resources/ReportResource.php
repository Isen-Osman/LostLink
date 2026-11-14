<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type->value,
            'type_label' => $this->type->label(),
            'category' => $this->category->value,
            'category_label' => $this->category->label(),
            'title' => $this->title,
            'description' => $this->description,
            'image_url' => $this->imageUrl(),
            'location' => $this->location,
            'happened_at' => $this->happened_at->toDateString(),
            'status' => $this->status->value,
            'status_label' => $this->status->label(),
            'author' => $this->user?->name,
            'contact_phone' => $this->user?->phone,
            'created_at' => $this->created_at->toIso8601String(),
        ];
    }
}
