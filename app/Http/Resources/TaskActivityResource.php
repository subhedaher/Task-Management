<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskActivityResource extends JsonResource
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
            'task_name' => $this->task->name,
            'member_name' => $this->member->name,
            'type' => $this->type,
            'description' => $this->description,
            'created_at' =>  dateFormate($this->created_at)
        ];
    }
}
