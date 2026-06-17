@extends('layouts.app')

@section('title', 'Verify Email')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold mb-6 text-center">Verify Your Email</h2>

    <p class="text-gray-700 mb-4">
        Thanks for signing up! Before getting started, please verify your email address by clicking the link we emailed to you.
        @if ($email)
            We sent it to <strong>{{ $email }}</strong>.
        @endif
        If you didn't receive the email, you can request another below.
    </p>

    @if (session('status') === 'verification-link-sent')
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            A new verification link has been sent to your email address.
        </div>
    @endif

    @if (session('status') === 'unverified')
        <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
            Please verify your email address before logging in.
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
        @csrf

        @if ($email)
            <input type="hidden" name="email" value="{{ $email }}">
        @else
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
        @endif

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Resend Verification Email
        </button>
    </form>

    <p class="text-center text-sm text-gray-600">
        <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-800">Back to login</a>
    </p>
</div>
@endsection
