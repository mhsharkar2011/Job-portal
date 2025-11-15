<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

     protected $casts = [
        'skills' => 'array',
        'experience' => 'array',
        'education' => 'array',
        'is_active' => 'boolean',
    ];


      public function user()
    {
        return $this->belongsTo(User::class);
    }
}
