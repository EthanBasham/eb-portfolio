<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">About</h1>
    </x-slot>

    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        <blockquote class="border-l-3 border-gray-300 bg-brand-200 px-4 py-3 text-lg text-gray-700">
            Before I was writing Laravel, I was raising chickens and doing chores on my
            family's dairy farm. These days the work looks a little different, but the
            two aren't as unrelated as they sound.
        </blockquote>

        <section class="mt-8" aria-labelledby="background-heading">
            <h2 id="background-heading" class="text-lg font-semibold text-gray-900">Where I'm From</h2>
            <img
                src="{{ asset('images/about/rhode-island-red-hen.webp') }}"
                alt="A Rhode Island Red hen"
                class="mt-4 h-56 w-full rounded-lg object-cover shadow-sm sm:h-72"
            >
            <p class="mt-3 text-gray-700">
                I grew up on a dairy farm outside Murfreesboro &mdash; raising chickens and
                selling eggs, and staying busy through 4-H. Growing up on a farm means you
                learn early that work doesn't wait for you to feel like doing it, a habit
                that's served me well in software, even if the deadlines look a little
                different now.
            </p>
            <p class="mt-4 text-gray-700">
                I was homeschooled through high school, which meant a lot of self-directed
                learning early on. That turned out to be great preparation for a career
                where half the job is figuring out things nobody explicitly taught you
                &mdash; a skill I leaned on more than I expected once I started my
                internship.
            </p>
        </section>

        <section class="mt-8" aria-labelledby="origin-heading">
            <h2 id="origin-heading" class="text-lg font-semibold text-gray-900">How I Got Into Code</h2>
            <p class="mt-3 text-gray-700">
                My first language was C/C++. I was always "the computer kid" growing up,
                and between loving math and loving logic, software development was an easy
                bet.
            </p>
            <p class="mt-3 text-gray-700">
                The real gateway drug, though, was Minecraft. I spent hours in command
                blocks and redstone trying to build increasingly elaborate custom games
                for my friends. I distinctly remember being endlessly frustrated trying to
                remember when to use <code class="rounded bg-gray-100 px-1 py-0.5 text-sm">{</code>
                versus <code class="rounded bg-gray-100 px-1 py-0.5 text-sm">[</code>
                &mdash; with no idea I was actually wrestling with JSON.
            </p>
            <p class="mt-3 text-gray-700">
                Not long after, I built my first "real" program: a C# app that generated
                custom spreadsheets from my dad's dairy feed recipes, so he'd know exactly
                how much to order. It wasn't glamorous, but it was the first time code
                solved an actual problem for someone I cared about, and I was hooked.
            </p>
            <p class="mt-3 text-gray-700">
                In college I got a taste of a few more languages &mdash; Python, F#, some
                others &mdash; but it was my internship that changed everything. I had zero
                web development experience, but a professor vouched for me to Bondware Web
                Solutions, who took a chance on me. I spent a couple of frantic weeks
                cramming HTML, CSS, and JavaScript from YouTube tutorials before even
                touching PHP, then landed straight into Laravel once I started. That fast,
                sink-or-swim ramp-up is where the self-taught habits from homeschooling
                really paid off.
            </p>
        </section>

        <section class="mt-8" aria-labelledby="approach-heading">
            <h2 id="approach-heading" class="text-lg font-semibold text-gray-900">Coding Philosophy</h2>
            <blockquote class="mt-3 border-l-3 border-gray-300 bg-brand-200 px-4 py-3 text-gray-700">
                Write concise, readable code with minimal whitespace clutter so it's easy
                to scan. Use comments as section headers for complex logic, not narration.
                Stay organized, and resist the urge to over-engineer. I'm pragmatic first
                &mdash; I'd rather ship a working solution than write a thesis about the
                "right" way to do it.
            </blockquote>
        </section>

        <section class="mt-8" aria-labelledby="beyond-resume-heading">
            <h2 id="beyond-resume-heading" class="text-lg font-semibold text-gray-900">Beyond the R&eacute;sum&eacute;</h2>
            <p class="mt-3 text-gray-700">
                After graduating, Bondware brought me on full-time as a junior engineer,
                and I was quickly pulled onto the team migrating a large ecommerce platform
                off a legacy proprietary system onto Laravel. Eventually I became the sole
                developer across all of Bondware's projects and started training and
                mentoring interns to help carry the load. One of them turned out to be one
                of the best developers I've had the privilege of working with &mdash; we
                hired her on full-time, and watching her grow into that role is one of the
                things I'm proudest of from my time there.
            </p>
            <p class="mt-3 text-gray-700">
                Alongside that, I've worked with Brockport Research Institute since late
                2019 &mdash; a project that scratches a different itch. It feels more like
                mine: I work directly with the client, hear the actual problems they're
                facing, and have the freedom to experiment with technologies and approaches
                that a bigger, more process-heavy project wouldn't allow.
            </p>
        </section>

        <section class="mt-8" aria-labelledby="hobbies-heading">
            <h2 id="hobbies-heading" class="text-lg font-semibold text-gray-900">Outside of Work</h2>
            <img
                src="{{ asset('images/about/climbing-holds.webp') }}"
                alt="Colorful indoor rock climbing holds on a wall"
                class="mt-4 h-56 w-full rounded-lg object-cover shadow-sm sm:h-72"
            >
            <p class="mt-3 text-gray-700">
                Rock climbing is my biggest hobby these days &mdash; I've been climbing
                indoors for about four years now, and I'm finally making the jump outdoors
                this fall. I tried a few other ways to stay active, but climbing stuck
                because it's as much about problem-solving as it is about strength.
            </p>
            <p class="mt-4 text-gray-700">
                I'm also a fairly serious strategy gamer. World of Tanks is where I first
                got real leadership experience, believe it or not &mdash; I ended up
                leading a rotating group of 10&ndash;20 guys through 15v15 matches, ranging
                in age from 12 to 70 and scattered across the US, Canada, and beyond.
                Coordinating that many personalities toward one plan taught me more about
                leadership than I expected a video game to.
            </p>
            <p class="mt-3 text-gray-700">
                I also play guitar (very much an amateur), lean classic country, watch a
                lot of football (fantasy league included), and I'm a sucker for a good
                escape room.
            </p>
            <p class="mt-3 text-gray-700">
                My faith is a significant part of who I am &mdash; I'm active in my local
                church, including preaching part-time, which has done more for my public
                speaking than any class or conference ever did.
            </p>
        </section>
    </div>
</x-app-layout>
