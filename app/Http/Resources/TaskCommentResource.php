<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskCommentResource extends JsonResource
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
            'comment' => $this->comment,
            'task_name' => $this->task->name,
            'member_name' => $this->member->name,
            'member_image' => $this->member->image,
            'created_at' =>  dateFormate($this->created_at)
        ];
    }
}
