@extends('layouts.app')

@section('title', 'User Role Assignment')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">User Role Assignment</h1>
        <a href="{{ route('dashboard') }}" class="text-blue-500 hover:text-blue-700">← Back to Dashboard</a>
    </div>

    @if($firstUser)
        <div class="mb-4 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded">
            <p class="text-sm">
                <strong>Note:</strong> The first user ({{ $firstUser->name }}) must always have Role_1 (Role Manager) and cannot have it removed.
            </p>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border-b">User Name</th>
                    <th class="px-4 py-2 border-b">Email</th>
                    <th class="px-4 py-2 border-b">Current Roles</th>
                    <th class="px-4 py-2 border-b">Assign Roles</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="px-4 py-2 border-b">{{ $user->name }}</td>
                        <td class="px-4 py-2 border-b">{{ $user->email }}</td>
                        <td class="px-4 py-2 border-b">
                            @if($user->roles->count() > 0)
                                <ul class="list-disc list-inside">
                                    @foreach($user->roles as $role)
                                        <li>Role_{{ $role->number }} - {{ $role->name }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-gray-500">No roles assigned</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 border-b">
                            <form method="POST" action="{{ route('user-roles.update', $user) }}">
                                @csrf
                                @method('PUT')
                                <div class="space-y-2">
                                    @php
                                        $roleManager = $roles->where('number', 1)->first();
                                        $isFirstUser = $user->isFirstUser();
                                    @endphp
                                    @foreach($roles as $role)
                                        @php
                                            $isRoleManager = $role->number === 1;
                                            $isChecked = $user->roles->contains($role->id);
                                            $isDisabled = $isFirstUser && $isRoleManager;
                                        @endphp
                                        <label class="flex items-center {{ $isDisabled ? 'opacity-75' : '' }}">
                                            <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                                   {{ $isChecked ? 'checked' : '' }}
                                                   {{ $isDisabled ? 'disabled' : '' }}
                                                   class="mr-2">
                                            <span>
                                                Role_{{ $role->number }} - {{ $role->name }}
                                                @if($isDisabled)
                                                    <span class="text-xs text-gray-500 ml-1">(Permanent)</span>
                                                @endif
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                                <button type="submit" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">
                                    Update Roles
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-2 text-center text-gray-500">No users found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
