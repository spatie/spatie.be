<nav class="h-full" x-data="{ open: false, isDesktop: window.matchMedia('(min-width: 768px)').matches }" x-init="window.matchMedia('(min-width: 768px)').addEventListener('change', e => { isDesktop = e.matches; if (isDesktop) open = false })">
    <div class="w-full mb-5">
        <div class="relative">
            <input
                type="text"
                name="search"
                placeholder="Search…"
                class="cursor-pointer w-full rounded-lg px-5 py-2.5 text-sm bg-oss-gray-medium placeholder-oss-gray-extra-dark"
                x-data="{}"
                x-on:click.prevent="$store.modals.open('search-modal')"
                readonly
            />
            <svg class="w-6 h-6 right-0 top-0 mt-2 mr-2.5 absolute" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="#3A3C3E" stroke-width="2" d="m19 19-4-4m-4 2a6 6 0 1 1 0-12 6 6 0 0 1 0 12Z"/></svg>
        </div>
        <x-modal name="search-modal" dismissable medium>
            <livewire:search-docs/>
        </x-modal>
    </div>

    <div class="flex w-full items-center gap-5 mb-6">
        <label for="alias" class="text-oss-royal-blue-light">Version</label>
        <div class="w-full leading-normal select bg-transparent p-0 border rounded-lg border-oss-gray-medium">
            <select id="alias" class="text-oss-royal-blue w-full font-medium rounded-lg px-5 py-2.5 border-oss-gray-medium outline-none font-pt" name="alias"
                    onChange="location='/docs/{{ $repository->slug }}/' + this.options[this.selectedIndex].value">
                @foreach($repository->aliases as $aliasOption)
                    <option value="{{ $aliasOption->slug }}" {{ $page->alias === $aliasOption->slug ? 'selected="selected"' : '' }}>
                        {{ $aliasOption->slug }}
                    </option>
                @endforeach
            </select>
            <span class="select-arrow mr-4">
                <svg class="w-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 7"><path fill="#050508" d="m5 6.61.471-.47 4-4 .473-.473L9 .723l-.47.47L5 4.724 1.471 1.196l-.47-.473-.944.944.47.47 4 4L5 6.61Z"/></svg>
            </span>
        </div>
    </div>

    <div class="hidden">
        Other versions for crawler

        @foreach($repository->aliases as $aliasOption)
            <a href="https://spatie.be/docs/{{ $repository->slug }}/{{ $aliasOption->slug }}">{{ $aliasOption->slug }}</a>
        @endforeach
    </div>

    <button
        @click="open = !open"
        class="flex w-full items-center justify-between rounded-lg border border-oss-royal-blue/10 bg-white px-4 py-3 text-left text-base font-bold md:hidden"
    >
        <span>{{ $page->title }}</span>
        <svg class="size-5 shrink-0 transition-transform" :class="open && 'rotate-180'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
        </svg>
    </button>

    <div x-show="isDesktop || open" x-collapse @click.outside="open = false">
        <ol class="grid gap-2 mt-2 max-h-[70dvh] overflow-y-auto rounded-lg border border-oss-royal-blue/10 bg-white px-4 py-3 md:mt-0 md:max-h-none md:overflow-visible md:rounded-none md:border-0 md:bg-transparent md:px-0 md:py-0">
            @foreach($navigation as $key => $section)
                @if ($key !== '_root')
                    <h2 class="text-base font-bold mb-2">{{ $section['_index']['title'] }}</h2>
                @endif

                <ul class="space-y-2 mb-8" role="list">
                    @foreach($section['pages'] as $navItem)
                        <li class="leading-snug text-[15px]">
                            <a wire:navigate href="{{ $navItem->url }}" class="@if($page->slug === $navItem->slug) font-bold text-blue @else text-oss-royal-blue @endif">
                                {{ $navItem->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endforeach
        </ol>
    </div>
</nav>

