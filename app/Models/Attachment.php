<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'file_name',
        'file_path',
        'file_type',
        'uploaded_by_member',
        'uploaded_by_admin'
    ];

    public function attachable()
    {
        return $this->morphTo();
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'uploaded_by_member', 'id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'uploaded_by_admin', 'id');
    }
}
