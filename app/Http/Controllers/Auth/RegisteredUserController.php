<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            return DB::transaction(function () use ($request) {
                // Create user
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'password' => Hash::make($request->password),
                ]);

                // Get the job-seeker role
                $seekerRole = Role::where('slug', 'job-seeker')->first();

                if (!$seekerRole) {
                    // If role doesn't exist, create it
                    $seekerRole = Role::create([
                        'name' => 'Job Seeker',
                        'slug' => 'job-seeker',
                        'description' => 'Can apply for jobs'
                    ]);
                }

                // Assign role to user using the pivot table
                $user->roles()->attach($seekerRole->id);

                event(new Registered($user));

                Auth::login($user);

                return redirect(RouteServiceProvider::HOME)
                    ->with('success', 'Account created successfully! Welcome to our job portal.');
            });
        } catch (\Exception $e) {
            \Log::error('User registration error: ' . $e->getMessage());

            return back()->with('error', 'Registration failed. Please try again.')
                ->withInput();
        }
    }
}
