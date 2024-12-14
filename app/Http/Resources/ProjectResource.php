<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'departments' => $this->departments,
            'description' => $this->description,
            'status' => $this->status,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'admin_name' => $this->admin->name,
            'member_name' => $this->member->name,
            'task_count' => $this->tasks->count(),
            'task_count_completed' => $this->tasks()->where('status', 'completed')->count(),
            'task_count_pending' => $this->tasks()->where('status', 'pending')->count(),
            'task_count_processing' => $this->tasks()->where('status', 'processing')->count(),
            'task_count_cancled' => $this->tasks()->where('status', 'cancled')->count(),
            'task_count_overdue' => $this->tasks()->where('status', 'overdue')->count(),
            'created_at' => dateFormate($this->created_at),
            'updated_at' => dateFormate($this->updated_at)
        ];
    }
}
