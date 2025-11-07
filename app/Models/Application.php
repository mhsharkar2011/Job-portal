<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'user_id',
        'full_name',
        'email',
        'phone',
        'experience_years',
        'address',
        'skills',
        'education',
        'resume_path',
        'cover_letter_path',
        'status',
        'notes',
    ];

    protected $casts = [
        'experience_years' => 'integer',
    ];

    // Add this method to fix the error
    public static function getStatusOptions()
    {
        return [
            'pending' => 'Pending',
            'reviewed' => 'Reviewed',
            'accepted' => 'Accepted',
            'rejected' => 'Rejected',
        ];
    }

    // Get status badge color
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'reviewed' => 'bg-blue-100 text-blue-800',
            'accepted' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    // Get formatted status
    public function getFormattedStatusAttribute()
    {
        $statuses = self::getStatusOptions();
        return $statuses[$this->status] ?? ucfirst($this->status);
    }

    // Relationships
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->hasOneThrough(Company::class, Job::class, 'id', 'id', 'job_id', 'company_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeReviewed($query)
    {
        return $query->where('status', 'reviewed');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Accessors
    public function getResumeUrlAttribute()
    {
        return $this->resume_path ? asset('storage/' . $this->resume_path) : null;
    }

    public function getCoverLetterUrlAttribute()
    {
        return $this->cover_letter_path ? asset('storage/' . $this->cover_letter_path) : null;
    }

    public function getFormattedExperienceAttribute()
    {
        return $this->experience_years . ' years';
    }

    // Check if application can be withdrawn (only pending applications)
    public function canWithdraw()
    {
        return $this->status === 'pending';
    }
}
