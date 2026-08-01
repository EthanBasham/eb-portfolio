<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Projects</h1>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        @if ($projects->isEmpty())
            <p class="text-gray-600">No projects have been published yet.</p>
        @else
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($projects as $project)
                    <article class="flex flex-col rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-gray-900">
                            <a
                                href="{{ route('projects.show', $project) }}"
                                class="hover:text-brand-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-600 rounded-sm"
                            >
                                {{ $project->title }}
                            </a>
                        </h2>
                        <p class="mt-2 flex-1 text-sm text-gray-600">
                            {{ $project->summary }}
                        </p>
                    </article>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $projects->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
