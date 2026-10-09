<section class="w-full max-w-[1320px] mx-auto px-7 lg:px-0">
    <div class="grid md:grid-cols-[11fr_9fr] gap-16 md:items-start">
        <div class="relative h-full">
            <img src="/images/team_2026.jpg" alt="The Spatie team" class="rounded-xl w-full h-full object-cover mix-blend-luminosity">
            <img class="absolute left-0 top-8 -translate-x-1/2" src="/images/icon_oss_trust.svg" alt="">
        </div>
        <div class="space-y-8">
            <div class="space-y-4">
                <h2 class="font-druk uppercase text-[40px] sm:text-[56px] leading-[0.9] text-white text-pretty">Specialists who know <br />Laravel inside out</h2>
            </div>
            <div class="space-y-5 text-lg text-oss-gray-light text-pretty">
                <p>By asking the right questions first, we make thoughtful architecture decisions, and ship clean code your team can maintain and extend long after launch.</p>
                <p>Over time, we have created a collection of <a class="underline hover:text-white" href="{{ route('open-source.packages') }}">open source building blocks</a> that allow us to focus all our time and effort on making your project unique, rather than on the scaffolding.<p>
                <p>And with our experiences in building with AI, we can ship faster, iterate more quickly, and develop more prototypes that can validate your ideas.</p>
            </div>
            <a class="text-lg font-bold inline-block bg-oss-green px-5 py-4 text-center text-oss-royal-blue rounded-lg transition hover:opacity-90" href="#match">Brief us your project</a>
        </div>
    </div>

<div id="process" class="mt-16 md:mt-20">
    <div class="process-overview grid md:grid-cols-3">
        <a class="process-card space-y-4" href="{{ route('web-development.research-and-analysis') }}" aria-labelledby="process-research-link">
            <span id="process-research-link" class="sr-only">Research &amp; Analysis: Grab a notebook</span>
            <div class="flex items-center gap-3 text-4xl">
                <span class="font-druk text-oss-purple">01</span>
                <h3 class="font-druk uppercase text-white leading-tight">Research & Analysis</h3>
            </div>
            <p class="text-lg text-oss-gray-medium">
                First we dig deep into your domain: everyone needs to know what we're really solving. New projects and legacy apps bursting out of their seams alike.
            </p>
            <x-services-phase-tag phase="01" aria-hidden="true" />
        </a>

        <a class="process-card space-y-4" href="{{ route('web-development.strong-foundation') }}" aria-labelledby="process-foundation-link">
            <span id="process-foundation-link" class="sr-only">Build a Strong Foundation: Hard hats on</span>
            <div class="flex items-center gap-3 text-4xl">
                <span class="font-druk text-oss-purple">02</span>
                <h3 class="font-druk uppercase text-white leading-tight">Build a Strong Foundation</h3>
            </div>
            <p class="text-lg text-oss-gray-medium">
                A Laravel codebase built for developers and agents alike. Clear structure, automated tests, and sensible abstractions that don't fight you when requirements change.
            </p>
            <x-services-phase-tag phase="02" aria-hidden="true" />
        </a>

        <a class="process-card space-y-4" href="{{ route('web-development.flexible-development') }}" aria-labelledby="process-development-link">
            <span id="process-development-link" class="sr-only">Flexible Development: Plot twists welcome</span>
            <div class="flex items-center gap-3 text-4xl">
                <span class="font-druk text-oss-purple">03</span>
                <h3 class="font-druk uppercase text-white leading-tight">Flexible Development</h3>
            </div>
            <p class="text-lg text-oss-gray-medium">
                We work in short cycles with frequent check-ins. Priorities can shift, but our process is designed for it, so you always get the most valuable thing next.
            </p>
            <x-services-phase-tag phase="03" aria-hidden="true" />
        </a>
        <svg class="process-clothesline" viewBox="0 0 300 40" preserveAspectRatio="none" fill="none" aria-hidden="true">
            <path d="M0 8 Q50 32 100 8 Q150 32 200 8 Q250 32 300 8" stroke="currentColor" stroke-width="1.5" vector-effect="non-scaling-stroke" />
            <circle cx="1" cy="8" r="1" fill="currentColor" />
            <circle cx="299" cy="8" r="1" fill="currentColor" />
        </svg>
    </div>
</div>

</section>
