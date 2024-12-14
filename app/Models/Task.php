<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'project_id',
        'description',
        'status',
        'start_date',
        'end_date',
        'priority'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function  members()
    {
        return $this->belongsToMany(Member::class, TaskMember::class, 'task_id', 'member_id');
    }

    public function productivities()
    {
        return $this->hasMany(Productivity::class, 'task_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(TaskComment::class, 'task_id', 'id');
    }

    public function activities()
    {
        return $this->hasMany(TaskActivity::class, 'task_id', 'id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
