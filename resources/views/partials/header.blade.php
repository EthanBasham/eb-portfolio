<header class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between gap-y-2 py-2 md:flex-nowrap">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logos/keyboard-climber-400x400.png') }}" alt="" class="h-[75px] w-[75px] rounded-md" width="75" height="75">
                <span class="flex flex-col leading-tight">
                    <span class="text-lg font-semibold text-brand-600">{{ config('app.name') }}</span>
                    <span class="text-sm text-gray-500">Senior Full-Stack Software Engineer</span>
                </span>
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

            <nav id="nav-menu" class="nav-menu w-full md:w-auto md:py-0" aria-label="Primary">
                <div class="flex flex-col gap-1 py-2 md:flex-row md:items-center md:justify-end md:gap-6 md:py-0">
                    <a
                        href="{{ route('home') }}"
                        class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 {{ request()->routeIs('home') ? 'text-brand-600' : '' }}"
                    >
                        Home
                    </a>

                    <a
                        href="{{ route('resume') }}"
                        class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 {{ request()->routeIs('resume') ? 'text-brand-600' : '' }}"
                    >
                        Resume
                    </a>
                </div>
            </nav>
        </div>
    </div>
</header>
