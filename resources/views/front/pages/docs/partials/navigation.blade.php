<nav class="h-full px-4 py-6 bg-white bg-opacity-50 shadow-light rounded-sm">
    
    <div class="flex items-center pb-4 border-b-2 border-gray-lighter">
        <div class="text-xs font-normal leading-normal select">
            <select name="alias" onChange="location=this.options[this.selectedIndex].value">
                @foreach($repository->aliases as $alias)
                    <option value="{{ $alias->slug }}">
                        {{ $alias->slug }} ({{ $alias->branch }})
                    </option>
                @endforeach
            </select>
            <span class="select-arrow">
            {{ svg('icons/far-angle-down') }}</span>
        </div>
        <a class="ml-auto flex items-center text-xs link-gray link-underline" href="{{ $alias->githubUrl }}/blob/{{$alias->slug}}/docs/{{ $page->slug }}.md"
            target="_blank">
            Edit 
            <span class="ml-1 w-4 h-4">
                {{ svg('github') }}
            </span>
        </a>
    </div>


    <div class="sticky top-0 pt-4 ">
    <input type="search" class="text-xs form-input w-full h-8 py-0 px-2 mb-8" id="algolia-search" placeholder="Search…">
    <ol class="text-xs grid gap-2 links-blue">
        @foreach($navigation as $key => $section)
            @if ($key !== '_root')
                <h2 class="title-sm text-sm mb-4">{{ $section['_index']['title'] }}</h2>
            @endif

            <ul class="mb-8 space-y-1 links-blue @if($key !== '_root') pl-3 border-l-2 border-gray-lighter border-opacity-75 @endif">
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

    <a href="https://laravelpackage.training?utm_source=docs.spatie.be"><img
                class="mb-8"
                src="https://d33wubrfki0l68.cloudfront.net/dc2ab82b48c72af8e3fa738348653bf0b08a011c/6eae2/images/package-training.jpg"></a>

    </div>

</nav>

