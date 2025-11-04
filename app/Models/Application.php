<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'job_id',
        'user_id',
        'full_name',
        'email',
        'phone',
        'address',
        'resume',
        'cover_letter',
        'status',
        'skills',
        'experience_years',
        'education',
        'custom_questions',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'skills' => 'array',
        'custom_questions' => 'array',
        'experience_years' => 'integer',
    ];

    /**
     * Get the status options.
     */
    public static function getStatusOptions(): array
    {
        return [
            'pending' => 'Pending',
            'under_review' => 'Under Review',
            'shortlisted' => 'Shortlisted',
            'interview' => 'Interview',
            'rejected' => 'Rejected',
            'accepted' => 'Accepted',
        ];
    }

    /**
     * Get the job that the application belongs to.
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    /**
     * Get the user that submitted the application.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include applications with a specific status.
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include applications for a specific job.
     */
    public function scopeForJob($query, int $jobId)
    {
        return $query->where('job_id', $jobId);
    }

    /**
     * Scope a query to only include applications from a specific user.
     */
    public function scopeFromUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Check if the application is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the application is accepted.
     */
    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }

    /**
     * Check if the application is rejected.
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Get the formatted status.
     */
    public function getFormattedStatusAttribute(): string
    {
        return self::getStatusOptions()[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Get the skills as an array.
     */
    public function getSkillsArrayAttribute(): array
    {
        if (is_array($this->skills)) {
            return $this->skills;
        }

        return $this->skills ? explode(',', $this->skills) : [];
    }

    /**
     * Get the application date in a formatted way.
     */
    public function getAppliedDateAttribute(): string
    {
        return $this->created_at->format('M d, Y');
    }

    /**
     * Get the application time in a formatted way.
     */
    public function getAppliedTimeAttribute(): string
    {
        return $this->created_at->format('h:i A');
    }
}
