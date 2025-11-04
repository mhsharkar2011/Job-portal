<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'is_active',
        'sort_order',
        'jobs_count',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'jobs_count' => 'integer',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->getOriginal('slug'))) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Get the jobs for the category.
     */
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    /**
     * Get active jobs for the category.
     */
    public function activeJobs(): HasMany
    {
        return $this->jobs()->where('is_active', true);
    }

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order by sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Scope a query to only include popular categories.
     */
    public function scopePopular($query, $limit = 10)
    {
        return $query->where('is_active', true)
                    ->where('jobs_count', '>', 0)
                    ->orderBy('jobs_count', 'desc')
                    ->limit($limit);
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get the category's icon HTML.
     */
    public function getIconHtmlAttribute(): string
    {
        if (Str::startsWith($this->icon, ['fa-', 'fas ', 'far ', 'fab '])) {
            return '<i class="' . $this->icon . '"></i>';
        }

        return $this->icon ?: '<i class="fa-solid fa-folder"></i>';
    }

    /**
     * Get the category's background color style.
     */
    public function getBackgroundColorAttribute(): string
    {
        return "background-color: {$this->color};";
    }

    /**
     * Get the category's text color style (for contrast).
     */
    public function getTextColorAttribute(): string
    {
        // Simple contrast calculation (you might want to use a more sophisticated method)
        $color = ltrim($this->color, '#');
        $r = hexdec(substr($color, 0, 2));
        $g = hexdec(substr($color, 2, 2));
        $b = hexdec(substr($color, 4, 2));

        // Calculate relative luminance
        $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;

        return $luminance > 0.5 ? 'text-gray-900' : 'text-white';
    }

    /**
     * Update jobs count for the category.
     */
    public function updateJobsCount(): void
    {
        $this->update([
            'jobs_count' => $this->activeJobs()->count()
        ]);
    }
}
