<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
        'profile_photo_path',
        'remove_photo',
        'password',
        // 'role',
        'is_active'
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
        'password' => 'hashed',
    ];


    // In app/Models/User.php
    public function getProfilePhotoAttribute()
    {
        return $this->profile_photo_path;
    }

    // Add this relationship if using roles
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function hasRole($roleSlug)
    {
        return $this->roles()->where('slug', $roleSlug)->exists();
    }

    // Check if user has any of the given roles
    public function hasAnyRole($roles)
    {
        return $this->roles()->whereIn('slug', (array)$roles)->exists();
    }
    // Assign role to user
    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('slug', $role)->firstOrFail();
        } elseif (is_int($role)) {
            $role = Role::findOrFail($role);
        }

        if (!$role instanceof Role) {
            throw new \InvalidArgumentException('Invalid role provided.');
        }

        $this->roles()->syncWithoutDetaching([$role->id]);

        return $this;
    }

    // Remove role from user
    public function removeRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('slug', $role)->firstOrFail();
        } elseif (is_int($role)) {
            $role = Role::findOrFail($role);
        }

        if (!$role instanceof Role) {
            throw new \InvalidArgumentException('Invalid role provided.');
        }

        $this->roles()->detach($role->id);

        return $this;
    }

    // Sync roles (replace all roles)
    public function syncRoles($roles)
    {
        foreach ((array)$roles as $role) {
            if (is_string($role)) {
                // If it's a string, treat it as a slug and find the role
                $role = Role::where('slug', $role)->firstOrFail();
                $roleIds[] = $role->id;
            } elseif ($role instanceof Role) {
                // If it's a Role object, get its ID
                $roleIds[] = $role->id;
            } elseif (is_int($role)) {
                // If it's an integer, treat it as a role ID
                $roleIds[] = $role;
            } else {
                throw new \InvalidArgumentException('Invalid role provided. Must be string, integer, or Role instance.');
            }
        }

        $this->roles()->sync($roleIds);

        return $this;
    }

    // Check if user has permission through role
    public function hasPermission($permission)
    {
        return $this->roles()->where(function ($query) use ($permission) {
            $query->whereJsonContains('permissions', $permission)
                ->orWhere('slug', 'admin'); // Admin has all permissions
        })->exists();
    }

    // Helper methods for common roles
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isEmployer()
    {
        return $this->hasRole('employer');
    }

    public function isSeeker()
    {
        return $this->hasRole('job-seeker');
    }

    // Get primary role (first role assigned)
    public function getPrimaryRoleAttribute()
    {
        return $this->roles->first();
    }

    public function resume()
    {
        return $this->hasOne(Resume::class);
    }

    // Add accessor for safe resume check
    public function getHasResumeAttribute()
    {
        return $this->resume()->exists();
    }

    // Add accessor for safe resume ID
    public function getResumeIdAttribute()
    {
        return $this->resume ? $this->resume->id : null;
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            if ($user) {
                $fullName = $user->name;
                $nameParts = explode(' ', $fullName, 2);

                $resume = new Resume();
                $resume->user_id = $user->id;
                if (count($nameParts) >= 2) {
                    $resume->first_name = $nameParts[0];
                    $resume->last_name = $nameParts[1];
                } else {
                    $resume->first_name = $nameParts[0];
                    $resume->last_name = null;
                }
                $resume->save();
            }
        });
    }

    // Jobs Relationship (for employers)
    public function jobs()
    {
        return $this->hasMany(Job::class, 'user_id');
    }

    // Applications Relationship (for seekers)
    public function applications()
    {
        return $this->hasMany(Application::class);
    }



    public function appliedJobs()
    {
        return $this->belongsToMany(Job::class, 'applications')
            ->withTimestamps()
            ->withPivot(['status', 'created_at']);
    }
}
