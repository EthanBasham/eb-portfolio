<x-app-layout>
    <x-slot name="header">
        <div class="mx-auto flex items-center justify-between px-4 sm:px-6 lg:px-8">
            <h1 class="text-xl font-semibold text-gray-900">{{ $page->title }}</h1>
            @can('manage-pages')
                <a
                    href="{{ route('pages.edit', $page) }}"
                    class="text-sm font-medium text-brand-600 hover:text-brand-500"
                >
                    Edit
                </a>
            @endcan
        </div>
    </x-slot>

    @if (session('status'))
        <div class="mx-auto max-w-3xl px-4 pt-6 sm:px-6 lg:px-8">
            <div class="rounded-md bg-brand-100 px-4 py-3 text-sm text-brand-900">
                {{ session('status') }}
            </div>
        </div>
    @endif

    @if ($page->isRaw())
        {!! $page->content !!}
    @else
        <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
            <div class="prose prose-gray max-w-none">
                {!! $page->renderedContent() !!}
            </div>
        </div>
    @endif
</x-app-layout>
