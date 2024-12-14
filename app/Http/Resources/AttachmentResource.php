<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentResource extends JsonResource
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
            'attachable_name' => $this->file_name,
            'attachable_type' => $this->attachable_type,
            'attachable_id' => $this->attachable_id,
            'file_path' => $this->file_path,
            'file_type' => $this->file_type,
            'uploaded_by_name' => $this->member->name,
        ];
    }
}
