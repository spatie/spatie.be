<nav class="h-full">
    <div class="w-full mb-5">
        <div class="relative">
            <input
                type="text"
                name="search"
                placeholder="Search..."
                class="cursor-pointer w-full rounded px-5 py-2.5 text-sm"
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

    <div class="flex w-full items-center gap-5 mb-10">
        <label for="alias" class="text-oss-royal-blue-light">Version</label>
        <div class="w-full leading-normal select bg-transparent p-0 border rounded border-oss-gray-medium">
            <select id="alias" class="text-oss-royal-blue w-full font-medium rounded-[4px] px-5 py-2.5 border-oss-gray-medium outline-none font-pt" name="alias"
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

    <ol class="grid gap-2">
        @foreach($navigation as $key => $section)
            @if ($key !== '_root')
                <h2 class="text-base font-bold mb-2">{{ $section['_index']['title'] }}</h2>
            @endif

            <ul class="space-y-2 mb-8">
                @foreach($section['pages'] as $navItem)
                    <li class="leading-snug">
                        <a wire:navigate href="{{ $navItem->url }}" class="@if($page->slug === $navItem->slug) font-bold text-blue @else text-oss-royal-blue @endif">
                            {{ $navItem->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endforeach
    </ol>

    <button
        x-data="{ copied: false }"
        x-on:click="
            fetch(window.location.href.replace(/\/$/, '') + '.md')
                .then(r => r.text())
                .then(text => {
                    $clipboard(text);
                    copied = true;
                    setTimeout(() => copied = false, 2000);
                })
        "
        class="text-sm inline-flex items-center gap-2 mt-6 hover:underline cursor-pointer text-oss-royal-blue"
    >
        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9.75a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
        </svg>
        <span x-text="copied ? 'Copied!' : 'Copy as markdown'"></span>
    </button>
</nav>

