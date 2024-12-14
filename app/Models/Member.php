<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Member extends Authenticatable implements MustVerifyEmail, JWTSubject
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'designation_id',
        'admin_id',
        'image',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function statusActive(): Attribute
    {
        return new Attribute(get: fn() => $this->status ? 'Active' : 'In Active');
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'member_id', 'id');
    }

    public function  tasks()
    {
        return $this->belongsToMany(Task::class, TaskMember::class, 'member_id', 'task_id');
    }

    public function comments()
    {
        return $this->hasMany(TaskComment::class, 'member_id', 'id');
    }

    public function activities()
    {
        return $this->hasMany(TaskActivity::class, 'member_id', 'id');
    }

    public function productivities()
    {
        return $this->hasMany(Productivity::class, 'member_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'uploaded_by_member', 'id');
    }
}