@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-4">Welcome, {{ $user->name }}!</h2>
        <p class="text-gray-700">Email: {{ $user->email }}</p>
    </div>

    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-4">Your Roles</h2>
        @if($roles->count() > 0)
            <ul class="list-disc list-inside space-y-2">
                @foreach($roles as $role)
                    <li class="text-gray-700">
                        <strong>Role_{{ $role->number }}</strong> - {{ $role->name }}
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-600">You don't have any roles assigned yet.</p>
        @endif
    </div>

    @if($user->isRoleManager())
        <div class="mt-6 pt-6 border-t">
            <h2 class="text-xl font-semibold mb-4">Role Manager Actions</h2>
            <div class="space-x-4">
                <a href="{{ route('roles.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Manage Roles
                </a>
                <a href="{{ route('user-roles.index') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Assign Roles to Users
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
