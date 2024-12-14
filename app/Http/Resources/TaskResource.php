<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'project_name' => $this->project->name,
            'description' => $this->description,
            'status' => $this->status,
            'pirority' => $this->priority,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'created_at' => dateFormate($this->created_at),
            'updated_at' => dateFormate($this->updated_at)
        ];
    }
}