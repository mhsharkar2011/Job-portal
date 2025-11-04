<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'company_name',
        'job_title',
        'job_description',
        'requirement',
        'location',
        'experience_minimum',
        'experience_maximum',
        'experience_unit',
        'role',
        'industry_type',
        'employment_type',
        'logo',
        'salary_minimum',
        'salary_maximum',
        'salary_currency',
        'key_skills',
        'positions_available',
        'positions_filled',
        'accepting_applications',
        'is_active',
        'published_at',
        'expires_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'experience_minimum' => 'integer',
        'experience_maximum' => 'integer',
        'salary_minimum' => 'integer',
        'salary_maximum' => 'integer',
        'positions_available' => 'integer',
        'positions_filled' => 'integer',
        'accepting_applications' => 'boolean',
        'is_active' => 'boolean',
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($job) {
            if (empty($job->published_at)) {
                $job->published_at = now();
            }

            if (empty($job->expires_at)) {
                $job->expires_at = now()->addDays(30); // Default 30 days expiry
            }
        });
    }

    /**
     * Get the user that owns the job.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the applications for the job.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Get the applications count for the job.
     */
    public function getApplicationsCountAttribute(): int
    {
        return $this->applications()->count();
    }

    /**
     * Get pending applications count.
     */
    public function getPendingApplicationsCountAttribute(): int
    {
        return $this->applications()->where('status', 'pending')->count();
    }

    /**
     * Check if job has applications.
     */
    public function hasApplications(): bool
    {
        return $this->applications_count > 0;
    }

    /**
     * Get remaining positions
     */
    public function getRemainingPositionsAttribute(): int
    {
        return max(0, $this->positions_available - $this->positions_filled);
    }

    /**
     * Check if job is still accepting applications
     */
    public function getIsAcceptingApplicationsAttribute(): bool
    {
        return $this->accepting_applications &&
               $this->remaining_positions > 0 &&
               $this->is_active &&
               (!$this->expires_at || $this->expires_at->isFuture());
    }

    /**
     * Check if job is expired
     */
    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Get job status
     */
    public function getStatusAttribute(): string
    {
        if (!$this->is_active) {
            return 'inactive';
        }

        if ($this->is_expired) {
            return 'expired';
        }

        if (!$this->is_accepting_applications) {
            return 'filled';
        }

        return 'active';
    }

    /**
     * Get formatted salary range
     */
    public function getFormattedSalaryAttribute(): string
    {
        if ($this->salary_minimum === 0 && $this->salary_maximum === 0) {
            return 'Negotiable';
        }

        $min = number_format($this->salary_minimum);
        $max = number_format($this->salary_maximum);
        $currency = $this->salary_currency;

        return "{$currency} {$min} - {$currency} {$max}";
    }

    /**
     * Get skills as array
     */
    public function getSkillsArrayAttribute(): array
    {
        if (empty($this->key_skills)) {
            return [];
        }

        return array_map('trim', explode(',', $this->key_skills));
    }

    /**
     * Increment filled positions when application is accepted
     */
    public function fillPosition(): bool
    {
        if ($this->remaining_positions > 0) {
            $this->increment('positions_filled');

            // Close applications if all positions are filled
            if ($this->remaining_positions === 0) {
                $this->update(['accepting_applications' => false]);
            }

            return true;
        }

        return false;
    }

    /**
     * Decrement filled positions (if needed for cancellation)
     */
    public function releasePosition(): void
    {
        if ($this->positions_filled > 0) {
            $this->decrement('positions_filled');

            // Reopen applications if positions become available
            if ($this->remaining_positions > 0 && !$this->accepting_applications) {
                $this->update(['accepting_applications' => true]);
            }
        }
    }

    /**
     * Scope a query to only include active jobs.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where(function ($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                    });
    }

    /**
     * Scope a query to only include jobs that are accepting applications.
     */
    public function scopeAcceptingApplications($query)
    {
        return $query->active()
                    ->where('accepting_applications', true)
                    ->whereRaw('positions_available > positions_filled');
    }

    /**
     * Scope a query to only include jobs from a specific user.
     */
    public function scopeFromUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include jobs by employment type.
     */
    public function scopeByEmploymentType($query, $type)
    {
        return $query->where('employment_type', $type);
    }

    /**
     * Scope a query to only include jobs by location.
     */
    public function scopeByLocation($query, $location)
    {
        return $query->where('location', 'like', "%{$location}%");
    }
}
