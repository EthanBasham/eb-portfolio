<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Page::query()->updateOrCreate(
            ['slug' => 'about'],
            [
                'title' => 'About',
                'format' => 'wysiwyg',
                'content' => $this->aboutContent(),
            ]
        );

        Page::query()->updateOrCreate(
            ['slug' => 'resume'],
            [
                'title' => 'Resume',
                'format' => 'raw',
                'content' => $this->resumeContent(),
            ]
        );
    }

    /**
     * Clean semantic HTML for the Quill/WYSIWYG-managed About page. Images use
     * plain <img> tags — Quill's Image blot matches on tag name (see
     * node_modules/quill/formats/image.js), so these load and round-trip
     * correctly through the editor, unlike Trix which only understood its own
     * upload-attachment format.
     */
    private function aboutContent(): string
    {
        return <<<'HTML'
            <blockquote>Before I was writing Laravel, I was raising chickens and doing chores on my family's dairy farm. These days the work looks a little different, but the two aren't as unrelated as they sound.</blockquote>

            <h2>Where I'm From</h2>
            <p><img src="/images/about/rhode-island-red-hen.webp" alt="A Rhode Island Red hen"></p>
            <p>I grew up on a dairy farm outside Murfreesboro &mdash; raising chickens and selling eggs, and staying busy through 4-H. Growing up on a farm means you learn early that work doesn't wait for you to feel like doing it, a habit that's served me well in software, even if the deadlines look a little different now.</p>
            <p>I was homeschooled through high school, which meant a lot of self-directed learning early on. That turned out to be great preparation for a career where half the job is figuring out things nobody explicitly taught you &mdash; a skill I leaned on more than I expected once I started my internship.</p>

            <h2>How I Got Into Code</h2>
            <p>My first language was C/C++. I was always "the computer kid" growing up, and between loving math and loving logic, software development was an easy bet.</p>
            <p>The real gateway drug, though, was Minecraft. I spent hours in command blocks and redstone trying to build increasingly elaborate custom games for my friends. I distinctly remember being endlessly frustrated trying to remember when to use <code>{</code> versus <code>[</code> &mdash; with no idea I was actually wrestling with JSON.</p>
            <p>Not long after, I built my first "real" program: a C# app that generated custom spreadsheets from my dad's dairy feed recipes, so he'd know exactly how much to order. It wasn't glamorous, but it was the first time code solved an actual problem for someone I cared about, and I was hooked.</p>
            <p>In college I got a taste of a few more languages &mdash; Python, F#, some others &mdash; but it was my internship that changed everything. I had zero web development experience, but a professor vouched for me to Bondware Web Solutions, who took a chance on me. I spent a couple of frantic weeks cramming HTML, CSS, and JavaScript from YouTube tutorials before even touching PHP, then landed straight into Laravel once I started. That fast, sink-or-swim ramp-up is where the self-taught habits from homeschooling really paid off.</p>

            <h2>Coding Philosophy</h2>
            <blockquote>Write concise, readable code with minimal whitespace clutter so it's easy to scan. Use comments as section headers for complex logic, not narration. Stay organized, and resist the urge to over-engineer. I'm pragmatic first &mdash; I'd rather ship a working solution than write a thesis about the "right" way to do it.</blockquote>

            <h2>Beyond the R&eacute;sum&eacute;</h2>
            <p>After graduating, Bondware brought me on full-time as a junior engineer, and I was quickly pulled onto the team migrating a large ecommerce platform off a legacy proprietary system onto Laravel. Eventually I became the sole developer across all of Bondware's projects and started training and mentoring interns to help carry the load. One of them turned out to be one of the best developers I've had the privilege of working with &mdash; we hired her on full-time, and watching her grow into that role is one of the things I'm proudest of from my time there.</p>
            <p>Alongside that, I've worked with Brockport Research Institute since late 2019 &mdash; a project that scratches a different itch. It feels more like mine: I work directly with the client, hear the actual problems they're facing, and have the freedom to experiment with technologies and approaches that a bigger, more process-heavy project wouldn't allow.</p>

            <h2>Outside of Work</h2>
            <p><img src="/images/about/climbing-holds.webp" alt="Colorful indoor rock climbing holds on a wall"></p>
            <p>Rock climbing is my biggest hobby these days &mdash; I've been climbing indoors for about four years now, and I'm finally making the jump outdoors this fall. I tried a few other ways to stay active, but climbing stuck because it's as much about problem-solving as it is about strength.</p>
            <p>I'm also a fairly serious strategy gamer. World of Tanks is where I first got real leadership experience, believe it or not &mdash; I ended up leading a rotating group of 10&ndash;20 guys through 15v15 matches, ranging in age from 12 to 70 and scattered across the US, Canada, and beyond. Coordinating that many personalities toward one plan taught me more about leadership than I expected a video game to.</p>
            <p>I also play guitar (very much an amateur), lean classic country, watch a lot of football (fantasy league included), and I'm a sucker for a good escape room.</p>
            <p>My faith is a significant part of who I am &mdash; I'm active in my local church, including preaching part-time, which has done more for my public speaking than any class or conference ever did.</p>
            HTML;
    }

    /**
     * Resume's exact current bespoke markup, copied verbatim (raw format
     * bypasses the WYSIWYG editor entirely, so it isn't subject to any of
     * its quirks). asset() calls resolved to literal root-relative paths
     * since raw content is rendered via {!! !!}, not re-parsed as Blade.
     */
    private function resumeContent(): string
    {
        return <<<'HTML'
            <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Ethan Basham</h2>
                        <p class="text-sm text-gray-500">Murfreesboro, TN</p>
                    </div>
                    <a
                        href="/docs/resume-ethan-basham.pdf"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center justify-center rounded-md bg-brand-700 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-brand-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-700 focus-visible:ring-offset-2"
                    >
                        Download PDF
                    </a>
                </div>

                <p class="mt-6 text-gray-700">
                    Software engineering leader with 9 years of experience building and operating
                    business-critical web applications, cloud infrastructure, and internal software
                    systems. Proven track record reducing operational costs, leading development
                    initiatives, and delivering technical solutions from concept through deployment.
                </p>

                <section class="mt-8" aria-labelledby="skills-heading">
                    <h3 id="skills-heading" class="text-lg font-semibold text-gray-900">Skills</h3>
                    <dl class="mt-3 space-y-2 text-sm text-gray-700">
                        <div>
                            <dt class="font-medium text-gray-900">Languages &amp; Frameworks</dt>
                            <dd>PHP, Laravel, Symfony, JavaScript, MySQL, HTML/CSS, SASS</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-900">Cloud &amp; DevOps</dt>
                            <dd>AWS EC2, RDS, S3, CloudFront, CloudWatch, Rekognition, WAF, SES, GitLab CI/CD</dd>
                        </div>
                    </dl>
                </section>

                <section class="mt-8" aria-labelledby="experience-heading">
                    <h3 id="experience-heading" class="text-lg font-semibold text-gray-900">Experience</h3>

                    <div class="mt-4">
                        <div class="flex flex-wrap items-baseline justify-between gap-x-4">
                            <h4 class="font-semibold text-gray-900">Bondware Web Solutions</h4>
                            <span class="text-sm text-gray-500">July 2017 &mdash; Current</span>
                        </div>

                        <div class="mt-3">
                            <p class="font-medium text-gray-800">
                                Senior Full-Stack Software Developer
                                <span class="font-normal text-gray-500">(Jan 2022 &mdash; Current)</span>
                            </p>
                            <ul class="mt-1 list-disc space-y-1 pl-5 text-sm text-gray-700">
                                <li>Reduced AWS infrastructure costs by more than 20% through architecture simplification and resource optimization while maintaining application performance and reliability.</li>
                                <li>Led and mentored junior developers across four concurrent PHP projects, improving delivery consistency and code quality through team cohesion, earned trust, and accountability.</li>
                                <li>Leveraged Claude Code to increase coding speed, and to automate test creation.</li>
                                <li>Established testing and QA processes that improved release confidence and reduced production issues.</li>
                            </ul>
                        </div>

                        <div class="mt-3">
                            <p class="font-medium text-gray-800">
                                Junior Developer
                                <span class="font-normal text-gray-500">(May 2020 &mdash; Jan 2022)</span>
                            </p>
                            <ul class="mt-1 list-disc space-y-1 pl-5 text-sm text-gray-700">
                                <li>Designed and developed a JavaScript-based visual webpage editor from the ground up that became a core feature of the ContentEngine platform.</li>
                                <li>Joined a 2-man team on the project to migrate a large ecommerce site (Renderosity) from a proprietary PHP platform to Laravel.</li>
                                <li>Utilized GitLab CI/CD, issue tracking, and agile-based workflow to improve consistency.</li>
                            </ul>
                        </div>

                        <div class="mt-3">
                            <p class="font-medium text-gray-800">
                                Intern Developer
                                <span class="font-normal text-gray-500">(July 2017 &mdash; May 2020)</span>
                            </p>
                            <ul class="mt-1 list-disc space-y-1 pl-5 text-sm text-gray-700">
                                <li>Self-taught full-stack web development with emphasis on Laravel for quick impact with little experience.</li>
                                <li>Became the primary contributor to Bondware's flagship ContentEngine software.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-6">
                        <div class="flex flex-wrap items-baseline justify-between gap-x-4">
                            <h4 class="font-semibold text-gray-900">Brockport Research Institute</h4>
                            <span class="text-sm text-gray-500">December 2019 &mdash; Current</span>
                        </div>
                        <p class="mt-3 font-medium text-gray-800">Self-Employed Independent Contractor</p>
                        <ul class="mt-1 list-disc space-y-1 pl-5 text-sm text-gray-700">
                            <li>Designed, developed, and maintained a Laravel-based CMS supporting day-to-day business operations.</li>
                            <li>Gathered requirements directly from stakeholders and translated business needs into technical solutions.</li>
                            <li>Delivered changes on time, and provided demos of each feature to ensure client comprehension.</li>
                            <li>Managed the full software lifecycle independently, including architecture, development, deployment, support, contract negotiation, and invoicing.</li>
                        </ul>
                    </div>
                </section>

                <section class="mt-8" aria-labelledby="education-heading">
                    <h3 id="education-heading" class="text-lg font-semibold text-gray-900">Education</h3>
                    <div class="mt-3 space-y-3 text-sm text-gray-700">
                        <div>
                            <p class="font-medium text-gray-900">B.S. of Computer Science &mdash; Middle Tennessee State University</p>
                            <p class="text-gray-500">Sep 2018 &mdash; May 2020; summa cum laude, GPA: 4.0/4.0</p>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">A.S. of Computer Science &mdash; Motlow State Community College</p>
                            <p class="text-gray-500">Sep 2015 &mdash; May 2018; summa cum laude, GPA: 3.975/4.0</p>
                        </div>
                    </div>
                </section>

                <section class="mt-8" aria-labelledby="strengths-heading">
                    <h3 id="strengths-heading" class="text-lg font-semibold text-gray-900">Professional Strengths</h3>
                    <ul class="mt-3 flex flex-wrap gap-2 text-sm">
                        <li class="rounded-full bg-gray-100 px-3 py-1 text-gray-700">Technical Leadership</li>
                        <li class="rounded-full bg-gray-100 px-3 py-1 text-gray-700">Cost Optimization</li>
                        <li class="rounded-full bg-gray-100 px-3 py-1 text-gray-700">Stakeholder Management</li>
                        <li class="rounded-full bg-gray-100 px-3 py-1 text-gray-700">Agile Development</li>
                        <li class="rounded-full bg-gray-100 px-3 py-1 text-gray-700">Public Speaking</li>
                        <li class="rounded-full bg-gray-100 px-3 py-1 text-gray-700">AI Augmentation</li>
                        <li class="rounded-full bg-gray-100 px-3 py-1 text-gray-700">Team Dynamics</li>
                    </ul>
                </section>
            </div>
            HTML;
    }
}
