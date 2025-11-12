<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'company_id',
        'category_id',
        'job_title',
        'job_description',
        'requirement',
        'location',
        'experience_minimum',
        'experience_maximum',
        'experience_unit',
        'role',
        'employment_type',
        'salary_minimum',
        'salary_maximum',
        'salary_currency',
        'key_skills',
        'positions_available',
        'positions_filled',
        'accepting_applications',
        'is_active',
        'published_at',
        'expires_at',
        'application_deadline',
        'is_featured',
        'is_urgent',
        'featured_until',
    ];

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
        'application_deadline' => 'datetime',
        'is_featured' => 'boolean',
        'is_urgent' => 'boolean',
        'featured_until' => 'datetime',
    ];

    /**
     * Get the company that owns the job.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    /**
     * Get the category that owns the job.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the user that owns the job.
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * Get the applications for the job.
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }


    public function applicationsCount()
    {
        return $this->applications()->count();
    }

    public function hasUserApplied()
    {
        if (!auth()->check()) {
            return false;
        }

        return $this->applications()
            ->where('user_id', auth()->id())
            ->exists();
    }

    /**
     * Scope a query to only include active jobs.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('accepting_applications', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    /**
     * Scope a query to only include published jobs.
     */
    public function scopePublished($query)
    {
        // return $query->whereNotNull('published_at')->where('published_at', '<=', now());

        return $query->where('published_at', '>=', now()->subDays(7));
    }
    /**
     * Scope a query to only include featured jobs.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
            ->where(function ($q) {
                $q->whereNull('featured_until')
                    ->orWhere('featured_until', '>', now());
            });
    }
    /**
     * Scope a query to only include urgent jobs.
     */
    public function scopeUrgent($query)
    {
        return $query->where('is_urgent', true);
    }

    /**
     * Check if job is still featured.
     */
    public function getIsCurrentlyFeaturedAttribute()
    {
        if (!$this->is_featured) return false;
        if ($this->featured_until && $this->featured_until->isPast()) return false;

        return true;
    }

    /**
     * Check if job is still active.
     */
    public function getIsActiveAttribute($value)
    {
        if (!$value) return false;
        if (!$this->accepting_applications) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;

        return true;
    }
}
