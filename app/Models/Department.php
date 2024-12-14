<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    public function statusActive(): Attribute
    {
        return new Attribute(get: fn() => $this->status ? 'Active' : 'In Active');
    }

    public function designations()
    {
        return $this->hasMany(Designation::class, 'department_id', 'id');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, ProjectDepartment::class, 'department_id', 'project_id');
    }
}
