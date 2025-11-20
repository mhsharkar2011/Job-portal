<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // // Define role-based gate
        // Gate::define('role', function ($user, $role) {
        //     // Handle multiple roles as array or string
        //     if (is_array($role)) {
        //         return $user->hasAnyRole($role);
        //     }

        //     return $user->hasRole($role);
        // });

        // Or define specific role gates
        Gate::define('job-seeker', function ($user) {
            return $user->isSeeker();
        });

        Gate::define('employer', function ($user) {
            return $user->isEmployer();
        });

        Gate::define('admin', function ($user) {
            return $user->isAdmin();
        });

        // // Permission-based gates
        // Gate::define('apply-jobs', function ($user) {
        //     return in_array($user->role, ['job-seeker', 'admin']);
        // });

        // Gate::define('post-jobs', function ($user) {
        //     return in_array($user->role, ['employer', 'admin']);
        // });

        // Gate::define('manage-jobs', function ($user) {
        //     return in_array($user->role, ['employer', 'admin', 'moderator']);
        // });

        // Gate::define('manage-users', function ($user) {
        //     return in_array($user->role, ['admin', 'moderator']);
        // });

        // Gate::define('access-admin-panel', function ($user) {
        //     return in_array($user->role, ['admin', 'moderator']);
        // });

        // // Super admin only
        // Gate::define('super-admin', function ($user) {
        //     return $user->role === 'admin';
        // });
    }
}
