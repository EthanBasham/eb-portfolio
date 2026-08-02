<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Edit: {{ $page->title }}</h1>
    </x-slot>

    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        @if ($errors->any())
            <div class="mb-6 rounded-md bg-red-50 px-4 py-3 text-sm text-red-700">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $currentFormat = old('format', $page->format->value);
        @endphp

        <form method="POST" action="{{ route('pages.update', $page) }}">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    value="{{ old('title', $page->title) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-600 focus:ring-brand-600"
                >
            </div>

            <div class="mt-6">
                <span class="block text-sm font-medium text-gray-700">Format</span>
                <div class="mt-2 flex gap-6">
                    @foreach (\App\Enums\PageFormat::cases() as $format)
                        <label class="flex items-center gap-2 text-sm text-gray-700">
                            <input
                                type="radio"
                                name="format"
                                value="{{ $format->value }}"
                                class="format-radio border-gray-300 text-brand-600 focus:ring-brand-600"
                                @checked($currentFormat === $format->value)
                            >
                            {{ $format->label() }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700">Content</label>

                {{-- The one field actually submitted — populated from whichever
                editor below is active, right before the form submits. --}}
                <input type="hidden" name="content" id="content">

                <div class="format-editor {{ $currentFormat === 'wysiwyg' ? '' : 'hidden' }}" data-format="wysiwyg">
                    <input
                        type="hidden"
                        id="wysiwyg-initial"
                        value="{{ $currentFormat === 'wysiwyg' ? old('content', $page->content) : '' }}"
                    >
                    <div id="editor-container" class="mt-1 bg-white"></div>
                    <p class="mt-2 text-sm text-gray-500">
                        The image button in the toolbar embeds files directly (no upload needed) &mdash;
                        fine for a few images, but large or many images will bloat this page's stored
                        content since they're embedded inline rather than saved as separate files.
                    </p>
                </div>

                <div class="format-editor {{ $currentFormat === 'md' ? '' : 'hidden' }}" data-format="md">
                    <textarea
                        id="markdown-editor"
                        rows="30"
                        class="mt-1 block w-full rounded-md border-gray-300 font-mono text-sm shadow-sm focus:border-brand-600 focus:ring-brand-600"
                    >{{ $currentFormat === 'md' ? old('content', $page->content) : '' }}</textarea>
                    <p class="mt-2 text-sm text-gray-500">
                        Markdown &mdash; rendered safely; any raw HTML typed into the source is
                        displayed as literal text rather than executed.
                    </p>
                </div>

                <div class="format-editor {{ $currentFormat === 'raw' ? '' : 'hidden' }}" data-format="raw">
                    <textarea
                        id="raw-editor"
                        rows="30"
                        class="mt-1 block w-full rounded-md border-gray-300 font-mono text-sm shadow-sm focus:border-brand-600 focus:ring-brand-600"
                    >{{ $currentFormat === 'raw' ? old('content', $page->content) : '' }}</textarea>
                    <p class="mt-2 text-sm text-gray-500">
                        Raw HTML &mdash; this isn't sanitized before rendering, since only
                        Admin-role accounts can reach this form. Be careful.
                    </p>
                </div>
            </div>

            <div class="mt-6 flex items-center gap-4">
                <button
                    type="submit"
                    class="rounded-md bg-brand-700 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-brand-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-700 focus-visible:ring-offset-2"
                >
                    Save
                </button>
                <a href="{{ route($page->slug) }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
