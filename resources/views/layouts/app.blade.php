<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <nav class="bg-white border-b border-gray-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    @auth
                        <div class="relative" data-dropdown>
                            <button
                                type="button"
                                data-dropdown-trigger
                                aria-expanded="false"
                                aria-haspopup="true"
                                class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold text-gray-900 transition-colors hover:bg-gray-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500/40 aria-expanded:bg-gray-100"
                            >
                                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-900 text-white">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                    </svg>
                                </span>
                                <span>App Menu</span>
                            </button>

                            <div
                                data-dropdown-panel
                                class="absolute left-0 top-full z-50 mt-2 w-52 origin-top-left scale-95 rounded-xl border border-gray-200/80 bg-white p-1.5 opacity-0 shadow-xl shadow-gray-200/50 transition duration-200 pointer-events-none invisible"
                            >
                                <a
                                    href="#"
                                    id="job-1-link"
                                    class="flex items-center rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50"
                                >
                                    Job_1
                                </a>
                            </div>
                        </div>
                    @endauth
                </div>

                <div class="flex items-center gap-2">
                    @auth
                        <div class="relative" data-dropdown>
                            <button
                                type="button"
                                data-dropdown-trigger
                                aria-expanded="false"
                                aria-haspopup="true"
                                class="inline-flex items-center gap-2.5 rounded-full py-1 pl-1 pr-3 transition-colors hover:bg-gray-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500/40 aria-expanded:bg-gray-100"
                            >
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-600 text-sm font-semibold text-white">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                                <span class="max-w-[10rem] truncate text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                            </button>

                            <div
                                data-dropdown-panel
                                class="absolute right-0 top-full z-50 mt-2 w-56 origin-top-right scale-95 rounded-xl border border-gray-200/80 bg-white p-1.5 opacity-0 shadow-xl shadow-gray-200/50 transition duration-200 pointer-events-none invisible"
                            >
                                @if(Auth::user()->isRoleManager())
                                    <div class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-gray-400">Admin</div>
                                    <a href="{{ route('roles.index') }}" class="flex items-center rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50">
                                        Manage Roles
                                    </a>
                                    <a href="{{ route('user-roles.index') }}" class="flex items-center rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50">
                                        Assign Roles
                                    </a>
                                    <div class="my-1.5 border-t border-gray-100"></div>
                                @endif
                                <a href="{{ route('profile.show') }}" class="flex items-center rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50">
                                    Profile
                                </a>
                                <a href="{{ route('profile.password') }}" class="flex items-center rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50">
                                    Password Reset
                                </a>
                                <div class="my-1.5 border-t border-gray-100"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center rounded-lg px-3 py-2.5 text-left text-sm font-medium text-red-600 transition-colors hover:bg-red-50">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-100">Login</a>
                        <a href="{{ route('register') }}" class="rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropdowns = document.querySelectorAll('[data-dropdown]');

            function closeDropdown(dropdown) {
                const trigger = dropdown.querySelector('[data-dropdown-trigger]');
                const panel = dropdown.querySelector('[data-dropdown-panel]');

                trigger?.setAttribute('aria-expanded', 'false');
                panel?.classList.add('invisible', 'opacity-0', 'scale-95', 'pointer-events-none');
                panel?.classList.remove('visible', 'opacity-100', 'scale-100', 'pointer-events-auto');
            }

            function openDropdown(dropdown) {
                dropdowns.forEach((other) => {
                    if (other !== dropdown) {
                        closeDropdown(other);
                    }
                });

                const trigger = dropdown.querySelector('[data-dropdown-trigger]');
                const panel = dropdown.querySelector('[data-dropdown-panel]');

                trigger?.setAttribute('aria-expanded', 'true');
                panel?.classList.remove('invisible', 'opacity-0', 'scale-95', 'pointer-events-none');
                panel?.classList.add('visible', 'opacity-100', 'scale-100', 'pointer-events-auto');
            }

            dropdowns.forEach((dropdown) => {
                const trigger = dropdown.querySelector('[data-dropdown-trigger]');
                const panel = dropdown.querySelector('[data-dropdown-panel]');

                trigger?.addEventListener('click', function (event) {
                    event.stopPropagation();
                    const isOpen = trigger.getAttribute('aria-expanded') === 'true';

                    if (isOpen) {
                        closeDropdown(dropdown);
                    } else {
                        openDropdown(dropdown);
                    }
                });
            });

            document.addEventListener('click', function (event) {
                dropdowns.forEach((dropdown) => {
                    if (!dropdown.contains(event.target)) {
                        closeDropdown(dropdown);
                    }
                });
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    dropdowns.forEach(closeDropdown);
                }
            });

            const job1Link = document.getElementById('job-1-link');
            if (job1Link) {
                job1Link.addEventListener('click', function (event) {
                    event.preventDefault();
                });
            }
        });
    </script>
</body>
</html>
