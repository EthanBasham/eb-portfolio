<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Resume</h1>
    </x-slot>

    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Ethan Basham</h2>
                <p class="text-sm text-gray-500">Murfreesboro, TN</p>
            </div>
            <a
                href="{{ asset('docs/resume-ethan-basham.pdf') }}"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center justify-center rounded-md bg-brand-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-brand-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-600 focus-visible:ring-offset-2"
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
                <p class="mt-1 text-sm font-medium text-gray-800">Self-Employed Independent Contractor</p>
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
            </ul>
        </section>
    </div>
</x-app-layout>
