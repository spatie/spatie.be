<div class="nav">
    <a href="https://laravelpackage.training?utm_source=docs.spatie.be"><img
                style="max-width: 75%; margin: 2em 0;"
                src="https://d33wubrfki0l68.cloudfront.net/dc2ab82b48c72af8e3fa738348653bf0b08a011c/6eae2/images/package-training.jpg"></a>

    <nav class="nav_menu">

        @foreach($navigation as $key => $section)
            @if ($key !== '_root')
                <strong>{{ $section['_index']['title'] }}</strong>
            @endif

            <ul>
                @foreach($section['pages'] as $page)
                    <li><a href="{{ $page->url }}">{{ $page->title }}</a></li>
                @endforeach
            </ul>
        @endforeach
    </nav>
</div>
<div class="nav_button -menu" data-nav-switch=""></div>
