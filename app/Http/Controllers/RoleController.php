<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')->latest()->paginate(10);
        $totalUsers = User::count();

        return view('admin.settings.roles.index', compact('roles', 'totalUsers'));
    }

    public function create()
    {
        $permissions = $this->getAvailablePermissions();
        return view('admin.settings.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'slug' => 'required|string|max:255|unique:roles,slug',
            'description' => 'nullable|string|max:500',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string',
            'is_default' => 'boolean',
            'is_active' => 'boolean',
        ]);

        // Convert permissions to array
        if (isset($validated['permissions'])) {
            $validated['permissions'] = array_values($validated['permissions']);
        }

        Role::create($validated);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully!');
    }

    public function show(Role $role)
    {
        $role->load(['users' => function ($query) {
            $query->withCount(['jobs', 'applications'])->latest();
        }]);

        $availablePermissions = $this->getAvailablePermissions();

        return view('admin.settings.roles.show', compact('role', 'availablePermissions'));
    }

    public function edit(Role $role)
    {
        $permissions = $this->getAvailablePermissions();
        return view('admin.settings.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($role->id)],
            'slug' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($role->id)],
            'description' => 'nullable|string|max:500',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string',
            'is_default' => 'boolean',
            'is_active' => 'boolean',
        ]);

        // Convert permissions to array
        if (isset($validated['permissions'])) {
            $validated['permissions'] = array_values($validated['permissions']);
        } else {
            $validated['permissions'] = [];
        }

        $role->update($validated);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully!');
    }

    public function destroy(Role $role)
    {
        // Prevent deletion of role if it has users
        if ($role->users_count > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete role that has users assigned. Reassign users first.');
        }

        // Prevent deletion of essential roles
        if (in_array($role->slug, ['admin', 'employer', 'job-seeker'])) {
            return redirect()->back()
                ->with('error', 'Cannot delete essential system roles.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully!');
    }
    public function reports()
    {
        $roles = Role::withCount('users')->get();
        $totalUsers = User::count();
        $usersByRole = [];

        foreach ($roles as $role) {
            $usersByRole[$role->name] = $role->users_count;
        }

        return view('admin.settings.reports', compact('roles', 'totalUsers', 'usersByRole'));
    }


    // User Role Assign ########################################################################################################
    public function assignRoleToUser(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
            'assignment_type' => 'required|in:assign,replace'
        ]);
        try {
            $user = User::findOrFail($validated['user_id']);
            $role = Role::findOrFail($validated['role_id']);
            $assignmentType = $validated['assignment_type'];
            // Use direct Eloquent for reliability
            if ($assignmentType === 'replace') {
                $user->roles()->sync([$role->id]);
                $action = 'replaced with';
                Log::info("Replaced all roles for user {$user->id} with role {$role->id}");
            } else {
                $user->roles()->syncWithoutDetaching([$role->id]);
                $action = 'added to';
                Log::info("Added role {$role->id} to user {$user->id}");
            }
            $message = "Role '{$role->name}' {$action} {$user->name}'s roles successfully!";
            return redirect()->route('admin.settings.users.show-assign-role')->with('success', $message);
        } catch (\Exception $e) {
            Log::error("Role assignment failed for user {$validated['user_id']} with role {$validated['role_id']}: " . $e->getMessage());

            $errorMessage = 'Failed to assign role: ' . $e->getMessage();

            return redirect()->route('admin.settings.users.show-assign-role')->with('error', $errorMessage)->withInput();
        }
    }

    public function removeRoleFromUser(Request $request, User $user, Role $role)
    {
        $user->removeRole($role);

        return redirect()->back()
            ->with('success', "Role '{$role->name}' removed from {$user->name} successfully!");
    }

    public function showAssignRoleForm()
    {
        $users = User::with('roles')
            ->orderBy('name')
            ->get()
            ->map(function ($user) {
                $user->current_roles = $user->roles->pluck('name')->join(', ') ?: 'No roles assigned';
                return $user;
            });

        // TEMPORARY FIX: Remove the is_active condition
        $roles = Role::withCount('users')
            ->orderBy('name')
            ->get();

        return view('admin.settings.roles.assign-role', compact('users', 'roles'));
    }

    protected function getAvailablePermissions()
    {
        return [
            'user.manage' => 'Manage Users',
            'role.manage' => 'Manage Roles',
            'job.create' => 'Create Jobs',
            'job.edit' => 'Edit Jobs',
            'job.delete' => 'Delete Jobs',
            'job.view' => 'View Jobs',
            'job.apply' => 'Apply to Jobs',
            'company.manage' => 'Manage Companies',
            'application.view' => 'View Applications',
            'application.manage' => 'Manage Applications',
            'category.manage' => 'Manage Categories',
            'settings.manage' => 'Manage Settings',
            'profile.manage' => 'Manage Profile',
            'resume.manage' => 'Manage Resume',
            'reports.view' => 'View Reports',
            '*' => 'All Permissions (Admin)',
        ];
    }
}
