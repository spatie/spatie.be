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

    <x-oss-content>
        <x-slot:aside>
            <p class="leading-snug text-oss-gray-dark mb-0.5">This is just a sample. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </x-slot:aside>

        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et
            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
            ea commodo consequat.
        </p>
        <p>
            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est
            laborum.
        </p>
    </x-oss-content>

    <div class="grid md:grid-cols-2 gap-4 sm:gap-8 max-w-[880px] mx-auto mt-16 md:mt-20">
        <x-oss-link-card title="Flare" target="_blank" href="https://flareapp.io" link="Discover">
            Flare is the best error tracking service for Laravel, PHP and JavaScript. Whenever an error happens in your production code, we'll notify you.
        </x-oss-link-card>

        <x-oss-link-card title="Mailcoach" target="_blank" href="https://mailcoach.app" link="Discover">
            Mailcoach is a fully featured email marketing platform built for growing creators, developers, and businesses.
        </x-oss-link-card>
    </div>

</section>
