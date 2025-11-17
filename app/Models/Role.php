<?php
// app/Models/Role.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'permissions',
        'is_default',
        'is_active'
    ];

    protected $casts = [
        'permissions' => 'array',
        'is_default' => 'boolean',
        'is_active' => 'boolean'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }
}
