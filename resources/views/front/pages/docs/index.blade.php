<x-page title="Documentation" body-class="bg-oss-gray font-pt antialiased font-medium leading-[1.4]">
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
        <div class="bg-oss-royal-blue text-white">
            <div class="px-3 w-full max-w-[1320px] mx-auto py-10">
                <div class="flex flex-col lg:flex-row lg:items-center gap-6 lg:gap-12">
                    <h1 class="font-druk uppercase text-[64px] lg:text-[88px] leading-[0.85] font-bold shrink-0">Docs</h1>
                    <p class="text-lg lg:text-xl text-white/70 max-w-md">
                        Find extensive documentation for many of our packages here.
                    </p>
                    <div class="flex-1 relative">
                        <input
                            type="search"
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

        <div class="px-3 w-full max-w-[1320px] mx-auto mt-8 mb-24">
            <p class="text-sm text-oss-gray-extra-dark mb-10 max-w-2xl">
                These {{ $repositories->count() }} packages have their documentation hosted right here. Looking for everything else we ship? Browse the complete catalogue of <a href="{{ route('open-source.packages') }}" class="font-semibold text-oss-royal-blue underline underline-offset-2 hover:no-underline" wire:navigate>{{ floor($totalPackageCount / 100) * 100 }}+ open-source packages</a>.
            </p>

            <div class="lg:columns-2 lg:gap-x-12 border-t border-oss-gray-medium/70">
                @each('front.pages.docs.partials.repository', $repositories, 'repository')
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
