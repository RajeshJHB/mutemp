@extends('layouts.app')

@section('title', 'Role Management')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Role Management</h1>
        <a href="{{ route('dashboard') }}" class="text-blue-500 hover:text-blue-700">← Back to Dashboard</a>
    </div>

    <!-- Add New Role Form -->
    <div class="mb-8 bg-gray-50 p-4 rounded-lg">
        <h2 class="text-xl font-semibold mb-4">Add New Role</h2>
        <form method="POST" action="{{ route('roles.store') }}" class="flex items-end gap-4">
            @csrf
            <div class="flex-1">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Role Name</label>
                <input type="text" name="name" id="name" required
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       placeholder="Enter role name">
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add Role
            </button>
        </form>
    </div>

    <!-- Roles List -->
    <div>
        <h2 class="text-xl font-semibold mb-4">Existing Roles</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border-b">Role Number</th>
                        <th class="px-4 py-2 border-b">Name</th>
                        <th class="px-4 py-2 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td class="px-4 py-2 border-b">Role_{{ $role->number }}</td>
                            <td class="px-4 py-2 border-b">
                                @if($role->number === 1)
                                    {{ $role->name }}
                                @else
                                    <form method="POST" action="{{ route('roles.update', $role) }}" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="name" value="{{ $role->name }}" required
                                               class="shadow appearance-none border rounded py-1 px-2 text-gray-700">
                                        <button type="submit" class="ml-2 text-blue-500 hover:text-blue-700 text-sm">
                                            Save
                                        </button>
                                    </form>
                                @endif
                            </td>
                            <td class="px-4 py-2 border-b">
                                @if($role->number === 1)
                                    <span class="text-gray-500 text-sm">Cannot delete Role Manager</span>
                                @else
                                    @php
                                        $lastRole = $roles->sortByDesc('number')->first();
                                    @endphp
                                    @if($role->id === $lastRole->id)
                                        <form method="POST" action="{{ route('roles.destroy', $role) }}" class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this role? This will remove it from all users.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm">
                                                Delete
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-500 text-sm">Can only delete the last role</span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-2 text-center text-gray-500">No roles found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
