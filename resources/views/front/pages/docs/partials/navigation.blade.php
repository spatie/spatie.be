<div class="nav">
    <a href="https://laravelpackage.training?utm_source=docs.spatie.be"><img
                style="max-width: 75%; margin: 2em 0;"
                src="https://d33wubrfki0l68.cloudfront.net/dc2ab82b48c72af8e3fa738348653bf0b08a011c/6eae2/images/package-training.jpg"></a>

    <nav class="nav_menu">

        @foreach($navigation as $key => $section)
            @if ($key !== '_root')
                <h2 class="title-sm text-sm mb-4">{{ $section['_index']['title'] }}</h2>
            @endif

            <ul class="mb-10 links-blue @if($key !== '_root') pl-4 border-l-2 border-gray-lightest @endif">
                @foreach($section['pages'] as $page)
                    <li><a href="{{ $page->url }}">{{ $page->title }}</a></li>
                @endforeach
            </ul>
        @endforeach
    </nav>
</div>
<div class="nav_button -menu" data-nav-switch=""></div>
