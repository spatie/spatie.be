<x-page
    title="Documentation"
    body-class="bg-oss-gray font-pt"
    background="/backgrounds/about-blurred.jpg"
    livewire
>
    <section
        x-data="{
            query: '',
            haystacks: @js($haystacks),
            get noMatches() {
                return this.query !== '' && ! this.haystacks.some(h => h.includes(this.query.toLowerCase()));
            },
        }"
        @keydown.window.escape="query = ''"
    >
        <div class="text-white drop-shadow-2xl">
            <div class="px-3 w-full max-w-[1320px] mx-auto py-10">
                <div class="flex flex-col justify-between lg:flex-row lg:items-center gap-6 lg:gap-12">
                    <h1 class="font-druk uppercase text-[64px] lg:text-[108px] leading-[0.85] font-bold">Docs</h1>
                    <div class="flex-1 max-w-md relative">
                        <input
                            type="search"
                            aria-label="Filter packages"
                            placeholder="Filter packages…"
                            autocomplete="off"
                            x-model="query"
                            class="w-full bg-white text-oss-royal-blue rounded-[12px] h-14 px-5 pr-12 placeholder:text-oss-gray-dark"
                        >
                        <svg class="w-5 h-5 right-4 top-1/2 -translate-y-1/2 absolute text-oss-gray-extra-dark" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" d="m19 19-4-4m-4 2a6 6 0 1 1 0-12 6 6 0 0 1 0 12Z"/></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-3 w-full max-w-[1320px] mx-auto mb-24">
            <p class="text-lg font-medium text-oss-gray-extra-dark mb-10">
                Showing {{ $repositories->count() }} packages with documentation. View the full list of <a href="{{ route('open-source.packages') }}" class="font-semibold text-oss-royal-blue underline underline-offset-2 hover:no-underline" wire:navigate>{{ floor($totalPackageCount / 100) * 100 }}+ open-source packages</a>.
            </p>

            <nav aria-label="Package categories" class="flex flex-wrap gap-x-6 gap-y-3 mb-10 text-oss-royal-blue">
                @foreach($groupedRepositories->keys() as $category)
                    <a href="#{{ \Illuminate\Support\Str::slug($category) }}" class="font-semibold underline underline-offset-2 hover:no-underline">{{ $category }}</a>
                @endforeach
            </nav>

            <div class="space-y-12">
                @foreach($groupedRepositories as $category => $categoryRepositories)
                    <section
                        id="{{ \Illuminate\Support\Str::slug($category) }}"
                        aria-labelledby="{{ \Illuminate\Support\Str::slug($category) }}-heading"
                        x-show="!query || @js($categoryRepositories->keys()->map(fn ($index) => $haystacks[$index])->values()).some(h => h.includes(query.toLowerCase()))"
                    >
                        <h2 id="{{ \Illuminate\Support\Str::slug($category) }}-heading" class="text-2xl font-semibold text-oss-royal-blue mb-4">{{ $category }} packages</h2>
                        <div class="lg:columns-2 lg:gap-x-12 border-t border-oss-gray-medium/70">
                            @each('front.pages.docs.partials.repository', $categoryRepositories, 'repository')
                        </div>
                    </section>
                @endforeach
            </div>

            <p
                x-show="noMatches"
                x-cloak
                class="text-center py-16 text-oss-gray-extra-dark"
            >
                No packages match “<span class="font-semibold text-oss-royal-blue" x-text="query"></span>”.
            </p>
        </div>
    </section>

    @livewire('spotlight')
</x-page>
