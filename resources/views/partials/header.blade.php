<header class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <a href="{{ route('home') }}" class="text-lg font-semibold text-brand-600">
                {{ config('app.name') }}
            </a>

            <button
                type="button"
                class="nav-toggle inline-flex items-center justify-center rounded-md p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-500 md:hidden"
                aria-expanded="false"
                aria-controls="nav-menu"
            >
                <span class="nav-toggle__label">Toggle navigation</span>
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <nav id="nav-menu" class="nav-menu md:py-0" aria-label="Primary">
            <div class="flex flex-col gap-1 py-2 md:flex-row md:items-center md:justify-end md:gap-6 md:py-0">
                <a
                    href="{{ route('home') }}"
                    class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 {{ request()->routeIs('home') ? 'text-brand-600' : '' }}"
                >
                    Home
                </a>

                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
                        Dashboard
                    </a>
                    <a href="{{ route('profile.edit') }}" class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
                        Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
                            Log Out
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
                        Log In
                    </a>
                    <a href="{{ route('register') }}" class="rounded-md bg-brand-600 px-3 py-2 text-sm font-medium text-white hover:bg-brand-500">
                        Register
                    </a>
                @endauth
            </div>
        </nav>
    </div>
</header>
