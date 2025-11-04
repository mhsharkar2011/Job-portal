<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'website',
        'about',
        'industry',
        'location',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'logo',
        'banner',
        'employees_count',
        'founded_year',
        'facebook_url',
        'twitter_url',
        'linkedin_url',
        'instagram_url',
        'is_verified',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'founded_year' => 'integer',
        'employees_count' => 'integer',
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user that owns the company.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the jobs for the company.
     */
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    /**
     * Get active jobs for the company.
     */
    public function activeJobs(): HasMany
    {
        return $this->jobs()->where('is_active', true);
    }

    /**
     * Scope a query to only include active companies.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include verified companies.
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Get the company's logo URL.
     */
    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }

    /**
     * Get the company's banner URL.
     */
    public function getBannerUrlAttribute(): ?string
    {
        return $this->banner ? asset('storage/' . $this->banner) : null;
    }

    /**
     * Get the company's full address.
     */
    public function getFullAddressAttribute(): string
    {
        $addressParts = array_filter([
            $this->address,
            $this->city,
            $this->state,
            $this->country,
            $this->postal_code,
        ]);

        return implode(', ', $addressParts);
    }

    /**
     * Get the company's social links.
     */
    public function getSocialLinksAttribute(): array
    {
        return [
            'facebook' => $this->facebook_url,
            'twitter' => $this->twitter_url,
            'linkedin' => $this->linkedin_url,
            'instagram' => $this->instagram_url,
        ];
    }
}
