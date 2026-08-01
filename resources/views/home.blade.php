<x-app-layout>
    <section
        id="hero"
        class="bg-gray-900 bg-cover bg-center"
        style="background-image: linear-gradient(rgba(17, 24, 39, 0.6), rgba(17, 24, 39, 0.6)), url('{{ asset('images/heros/laravel-code-hero-light.png') }}');"
    >
        <div class="mx-auto max-w-7xl px-4 py-24 text-center sm:px-6 sm:py-32 lg:px-8">
            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl">
                Hi, I'm {{ config('app.name') }}.
            </h1>
            <p class="mx-auto mt-4 max-w-2xl text-lg text-gray-200">
                I have spent the past 9 years building business-critical web applications for
                multiple companies with Laravel/PHP on AWS. I have owned every part of the
                projects I've managed, and I pride myself on cutting costs without cutting corners.
            </p>
            <div class="mt-8 flex flex-col items-center justify-center gap-4 sm:flex-row">
                <a
                    href="{{ route('projects.index') }}"
                    class="rounded-md bg-brand-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-brand-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-600 focus-visible:ring-offset-2"
                >
                    View my projects
                </a>
                <a
                    href="mailto:hello@example.com"
                    class="rounded-md px-5 py-3 text-sm font-semibold text-white ring-1 ring-inset ring-white/40 hover:bg-white/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-gray-900"
                >
                    Get in touch
                </a>
            </div>
        </div>
    </section>

    <section class="bg-gray-50 py-16" aria-labelledby="featured-projects-heading">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 id="featured-projects-heading" class="text-2xl font-bold text-gray-900">
                Featured projects
            </h2>

            @if ($featuredProjects->isEmpty())
                <p class="mt-4 text-gray-600">
                    Featured projects will show up here once they're published.
                </p>
            @else
                <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($featuredProjects as $project)
                        <article class="flex flex-col rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                            <h3 class="text-lg font-semibold text-gray-900">
                                <a
                                    href="{{ route('projects.show', $project) }}"
                                    class="hover:text-brand-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-600 rounded-sm"
                                >
                                    {{ $project->title }}
                                </a>
                            </h3>
                            <p class="mt-2 flex-1 text-sm text-gray-600">
                                {{ $project->summary }}
                            </p>
                            <div class="mt-4 flex gap-4 text-sm">
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
                        </article>
                    @endforeach
                </div>
            @endif

            <div class="mt-10">
                <a href="{{ route('projects.index') }}" class="text-sm font-semibold text-brand-600 hover:text-brand-500">
                    See all projects &rarr;
                </a>
            </div>
        </div>
    </section>
</x-app-layout>
