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
        'password',
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

    public function resume()
    {
        return $this->hasOne(Resume::class);
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

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Get the jobs posted by the user (if users can post jobs).
     */
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }
}
