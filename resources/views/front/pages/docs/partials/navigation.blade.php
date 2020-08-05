<div class="nav">
    <input type="search" class="form-input rounded-sm w-full py-0 px-2" placeholder="Search packages...">

    <a href="https://laravelpackage.training?utm_source=docs.spatie.be"><img
                style="margin: 2em 0;"
                src="https://d33wubrfki0l68.cloudfront.net/dc2ab82b48c72af8e3fa738348653bf0b08a011c/6eae2/images/package-training.jpg"></a>

    <nav class="nav_menu">

        @foreach($navigation as $key => $section)
            @if ($key !== '_root')
                <h2 class="title-sm text-sm mb-4">{{ $section['_index']['title'] }}</h2>
            @endif

            <ul class="mb-10 links-blue @if($key !== '_root') pl-3 border-l-2 border-gray-lightest @endif">
                @foreach($section['pages'] as $navItem)
                    <li>
                        <a href="{{ $navItem->url }}" class="px-1 rounded-sm @if($page->slug === $navItem->slug) bg-blue text-white @endif">
                            {{ $navItem->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endforeach
    </nav>
</div>
<div class="nav_button -menu" data-nav-switch=""></div>
