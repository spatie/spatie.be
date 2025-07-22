<x-page title="Guidelines" background="/backgrounds/guidelines.jpg">
    <x-slot name="description">
        A set of guidelines we use to bring our projects to a good end.
        Consistency is the key to writing maintainable software.
    </x-slot>

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Guidelines
            </h1>
            <p class="banner-intro">
                Consistency is key
            </p>
        </div>
    </section>

    <section>
        <div class="wrap wrap-6 mb-16">
            <div class="sm:col-span-6 max-w-lg">
                <div class="markup links-underline links-blue">
                    <p class="text-lg">
                        Most projects are not built or maintained by a single person. Instead, there is a collection of
                        people involved, who all have their own personal preferences. If everyone would use their
                        personal style, maintainability would suffer.
                    </p>
                    <p class="text-lg">
                        The members of our team regularly discuss the pros and cons of each of their
                        individual programming preferences. When reaching a consensus, we write it down in these
                        guidelines, together with the reasons why a certain approach was picked.
                    </p>

                    <p class="text-lg">
                        We consider our guidelines as a living document. People, teams, and opinions change over time.
                        We don't dogmatically keep following rules we agreed on in the past, but keep challenging them.
                        New experiences lead to new and improved guidelines.
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
