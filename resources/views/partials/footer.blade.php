<footer class="border-t border-gray-100 bg-white">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center justify-between gap-4 text-sm text-gray-500 md:flex-row">
            <p>&copy; {{ now()->year }} {{ config('app.name') }}. All rights reserved.</p>

            <nav aria-label="Footer" class="flex gap-6">
                <a href="{{ route('home') }}" class="hover:text-gray-700">Home</a>
                @guest
                    <a href="{{ route('login') }}" class="hover:text-gray-700">Log In</a>
                @endguest
            </nav>
        </div>
    </div>
</footer>
