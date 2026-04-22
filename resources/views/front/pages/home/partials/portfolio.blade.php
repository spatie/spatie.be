<section class="w-full px-7 lg:px-0">
    <x-oss-staggered-title offset="md:-ml-[12.5rem]">
        <x-slot:icon>
            <svg class="w-8 h-8 sm:w-12 sm:h-12 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 48 48"><g fill="#FF354F" clip-path="url(#clip0_products_heart)"><path d="M24 48a24 24 0 1 0 0-48 24 24 0 0 0 0 48ZM12.366 26.334c-2.757-2.793-2.757-7.33 0-10.125a6.983 6.983 0 0 1 9.975 0L24 17.897l1.66-1.688a6.983 6.983 0 0 1 9.974 0c2.757 2.794 2.757 7.332 0 10.125L26.11 36.01c-.58.591-1.34.882-2.109.882-.769 0-1.528-.291-2.11-.882l-9.524-9.675Z" opacity=".4"/><path d="M12.366 16.21c-2.756 2.793-2.756 7.33 0 10.124l9.525 9.675c.581.591 1.34.882 2.11.882.768 0 1.527-.291 2.109-.882l9.525-9.675c2.756-2.793 2.756-7.33 0-10.125a6.984 6.984 0 0 0-9.975 0L24 17.897l-1.659-1.688a6.984 6.984 0 0 0-9.975 0Z"/></g><defs><clipPath id="clip0_products_heart"><path fill="#fff" d="M0 0h48v48H0z"/></clipPath></defs></svg>
        </x-slot:icon>
        <x-slot:line1>
            <span>Made with love</span>
        </x-slot:line1>
        <x-slot:line2>
            <span>and Laravel</span>
        </x-slot:line2>
    </x-oss-staggered-title>

    <x-oss-content alignItems="">
        <x-slot:aside>
            <p class="leading-snug text-oss-gray-dark mb-0.5">We <a class="underline transition hover:text-white" href="/newsletter">have a quarterly(-ish) newsletter</a> with product updates, what's going on behind the scenes, and interesting links.</p>
        </x-slot:aside>

        <p class="text-xl">
            We use Laravel for almost all our web development projects, and it's the foundation for many of our products too. Our own products run on the same stack we build for clients, so we know firsthand what it takes to keep software running in production.
        </p>
        <span class="inline-flex gap-2 underline underline-offset-4 decoration-white/25 transition hover:decoration-white"><a href="/products">Our products &amp; courses</a><span class="icon">{{ app_svg('icons/far-angle-right') }}</span></span>
    </x-oss-content>

    <div class="grid md:grid-cols-3 border border-white/10 rounded-xl max-w-[1320px] mx-auto mt-16 md:mt-20 divide-y md:divide-y-0 md:divide-x divide-white/10">

        <div class="p-9 space-y-6 text-lg text-oss-gray-medium">
            <a class="flex h-12 items-center" href="https://mailcoach.app" target="_blank">
                <img class="h-[40px]" src="/images/mailcoach_logo_white.svg" alt="Mailcoach">
            </a>
            <p>An email marketing platform for sending campaigns, automations and transactional emails. Available as a hosted service or a self-hosted Laravel package.</p>
            <div class="flex gap-4">
                <a class="underline underline-offset-4 decoration-white/25 transition hover:decoration-white" href="https://mailcoach.app" target="_blank">Try Mailcoach for free</a>
                <a class="underline underline-offset-4 decoration-white/25 transition hover:decoration-white" href="https://www.mailcoach.app/self-hosted/" target="_blank">Self-hosted</a>
            </div>
        </div>

        <div class="p-9 space-y-6 text-lg text-oss-gray-medium">
            <a class="flex h-12 items-center" href="https://flareapp.io" target="_blank">
                <img class="h-[48px]" src="/images/flare_logo_white.svg" alt="Flare">
            </a>
            <p>Error tracking and performance monitoring for Laravel, PHP and JavaScript. Get alerted when bugs hit production, with integrations for GitHub, Jira, Linear and more.</p>
            <div class="">
                <a class="underline underline-offset-4 decoration-white/25 transition hover:decoration-white" href="https://flareapp.io" target="_blank">Try Flare for free</a>
            </div>
        </div>

        <div class="p-9 space-y-6 text-lg text-oss-gray-medium">
            <a class="flex h-12 items-center" href="https://myray.app" target="_blank">
                <img class="h-[25px]" src="/images/ray_logo_gradient.svg" alt="Ray">
            </a>
            <p>A desktop debugging app for Laravel, PHP and JavaScript. All the speed of dump() and console.log(), but with a dedicated interface to keep your output organized.</p>
            <div class="">
                <a class="underline underline-offset-4 decoration-white/25 transition hover:decoration-white" href="https://myray.app" target="_blank">Try Ray for free</a>
            </div>
        </div>

        {{-- <x-oss-link-card title="Flare" target="_blank" href="https://flareapp.io" link="Discover">
            Flare is the best error tracking service for Laravel, PHP and JavaScript. Whenever an error happens in your production code, we'll notify you.
        </x-oss-link-card> --}}

        {{-- <x-oss-link-card title="Mailcoach" target="_blank" href="https://mailcoach.app" link="Discover">
            Mailcoach is a fully featured email marketing platform built for growing creators, developers, and businesses.
        </x-oss-link-card> --}}

    </div>

</section>
