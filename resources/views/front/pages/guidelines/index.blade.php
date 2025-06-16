<x-page title="Guidelines" background="/backgrounds/blog-index.jpg" body-class="bg-oss-gray" main-class="font-pt text-oss-royal-blue font-medium text-18 leading-140 antialiased">
    <x-slot name="description">
        A set of guidelines we use to bring our projects to a good end.
        Consistency is the key to writing maintainable software.
    </x-slot>

    <header class="wrapper-lg px-7 sm:px-16 mt-4 lg:mt-12 md:mb-16">
        <x-headers.super class="md:text-[96px] md:text-center text-white drop-shadow-2xl">
            Coding <br> Guidelines
        </x-headers.super>
    </header>

    <section>
        <div class="wrapper-lg px-7 sm:px-16 mt-8">
            <div class="sm:col-span-6 max-w-screen-sm mx-auto">
                <div class="markup links-underline links-blue">
                    <p class="text-lg">
                        Most projects are not created or maintained by one person. 
                        Instead, a group of people work together, each with their own preferences. 
                        If everyone used their own style, projects would be difficult to maintain.
                    </p>
                    <p class="text-lg">
                        Our team often discusses the pros and cons of our different programming styles. 
                        When we agree on something, we write it down in these guidelines and explain why we chose that approach.
                    </p>

                    <p class="text-lg">
                        We like to think of our guidelines as a living document. 
                        People, teams and opinions change over time. 
                        We don't adhere strictly to old rules, but constantly challenge them. 
                        New experiences lead to better guidelines.
                    </p>
                    <div class="mt-12">
                    @include('front.pages.guidelines.partials.writing-readable-php-cta')
                    </div>

                    <div class="mt-8">
                        <x-coloured-block color="terminal" icon="code">
                            <p>
                                You can integrate these guidelines with AI code assistants like <strong>Claude Code</strong>, <strong>GitHub Copilot</strong>, and <strong>Cursor</strong> to ensure consistent code generation that follows our standards.
                            </p>
                            <p class="mt-2">
                                Check out our <a href="{{ url('/guidelines/ai') }}" class="font-semibold text-cyan-400 hover:text-cyan-300 underline">AI integration guide</a>.
                            </p>
                        </x-coloured-block>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-group">
        <div class="wrap mb-24">
            <div class="grid gap-x-6 gap-y-16 | sm:grid-cols-3 items-stretch">
                @each('front.pages.guidelines.partials.page', $pages, 'page')
            </div>
        </div>
    </section>

</x-page>
