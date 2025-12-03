<?php

namespace App\Http\Controllers;

use App\Http\Middleware\EnsureRoleManager;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\View\View;

class UserRoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            'verified',
            EnsureRoleManager::class,
        ];
    }

    public function index(): View
    {
        $users = User::with('roles')->orderBy('name')->get();
        $roles = Role::orderBy('number')->get();
        $firstUser = User::orderBy('id')->first();

        return view('user-roles.index', compact('users', 'roles', 'firstUser'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'roles' => ['array'],
            'roles.*' => ['exists:roles,id'],
        ]);

        // Get Role_1 ID
        $roleManager = Role::where('number', 1)->first();

        // If this is the first user, ensure Role_1 is always included
        if ($user->isFirstUser() && $roleManager) {
            $roles = $request->roles ?? [];
            // Ensure Role_1 is always in the array
            if (! in_array($roleManager->id, $roles)) {
                $roles[] = $roleManager->id;
            }
            $user->roles()->sync($roles);
        } else {
            $user->roles()->sync($request->roles ?? []);
        }

        return redirect()->route('user-roles.index')->with('success', 'User roles updated successfully.');
    }
}
