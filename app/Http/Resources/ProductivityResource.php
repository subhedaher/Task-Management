<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'id' => $this->id,
            'name' => $this->name,
            'task_name' => $this->task->name,
            'project_name' => $this->task->project->name,
            'member_name' => $this->member->name,
            'description' => $this->description,
            'start' => formatDateTime($this->start),
            'end' => formatDateTime($this->end),
            'created_at' => dateFormate($this->created_at)
        ];
    }
}