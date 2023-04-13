<nav class="h-full md:px-4 py-6 md:bg-white md:bg-opacity-50 md:shadow-light rounded-sm">
    <div class="flex items-center pb-4 border-b-2 border-gray-lighter">
        <div class="text-xs font-normal leading-normal select">
            <select name="alias" onChange="location='/docs/{{ $repository->slug }}/' + this.options[this.selectedIndex].value">
                @foreach($repository->aliases as $aliasOption)
                    <option value="{{ $aliasOption->slug }}" {{ $page->alias === $aliasOption->slug ? 'selected="selected"' : '' }}>
                        {{ $aliasOption->slug }} ({{ $aliasOption->branch }})
                    </option>
                @endforeach
            </select>
            <span class="select-arrow">
            {{ svg('icons/far-angle-down') }}</span>
        </div>
        <div class="ml-auto pl-2 flex items-center">
            <a class="text-xs link-gray link-underline" href="{{ $alias->githubUrl }}/blob/{{$alias->branch}}/docs/{{ $page->slug }}.md"
                target="_blank">
                Edit
            </a>
            <a class="ml-2 flex text-xs link-gray" href="{{ $alias->githubUrl }}/tree/{{$alias->branch}}"
                target="_blank">
                <span class="w-4 h-4">
                    {{ svg('github') }}
                </span>
            </a>
        </div>

    </div>

    <div class="hidden">
        Other versions for crawler

        @foreach($repository->aliases as $aliasOption)
            <a href="https://spatie.be/{{ $aliasOption->slug }}">{{ $aliasOption->slug }}</a>
        @endforeach
    </div>

    <div class="w-full my-4 pb-4 border-b-2 border-gray-lighter">
        <input
            type="text"
            name="search"
            placeholder="Search..."
            class="cursor-pointer w-full border border-blue rounded px-2 py-1 text-sm"
            x-data="{}"
            x-on:click.prevent="$store.modals.open('search-modal')"
            readonly
        />
        <x-modal name="search-modal" dismissable medium>
            <livewire:search-docs />
        </x-modal>
    </div>

    <div class="pt-4 ">
        <ol class="text-xs grid gap-2 links-blue">
            @foreach($navigation as $key => $section)
                @if ($key !== '_root')
                    <h2 class="title-sm text-sm">{{ $section['_index']['title'] }}</h2>
                @endif

                <ul class="mb-6 space-y-1 links-blue @if($key !== '_root') pl-2 border-l-2 border-gray-lighter border-opacity-75 @endif">
                    @foreach($section['pages'] as $navItem)
                        <li class="leading-snug">
                            <a href="{{ $navItem->url }}" class="@if($page->slug === $navItem->slug) font-bold @endif">
                                {{ $navItem->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endforeach
        </ol>
    </div>

</nav>

