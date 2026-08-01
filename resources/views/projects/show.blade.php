<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">{{ $project->title }}</h1>
    </x-slot>

    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        <p class="text-lg text-gray-600">{{ $project->summary }}</p>

        @if ($project->description)
            <div class="prose mt-6 max-w-none text-gray-700">
                {{ $project->description }}
            </div>
        @endif

        <div class="mt-8 flex gap-4 text-sm">
            @if ($project->url)
                <a href="{{ $project->url }}" class="font-medium text-brand-600 hover:text-brand-500" target="_blank" rel="noopener noreferrer">
                    Live site
                </a>
            @endif
            @if ($project->repo_url)
                <a href="{{ $project->repo_url }}" class="font-medium text-brand-600 hover:text-brand-500" target="_blank" rel="noopener noreferrer">
                    Source
                </a>
            @endif
        </div>

        <div class="mt-10">
            <a href="{{ route('projects.index') }}" class="text-sm font-semibold text-brand-600 hover:text-brand-500">
                &larr; Back to all projects
            </a>
        </div>
    </div>
</x-app-layout>
