<nav class="">
    <div class="flex w-full items-center gap-5 mb-10">
        <ul class="flex flex-col gap-y-2">
            @foreach ($pages as $guidelinePage)
                <li value="{{ $guidelinePage->slug }}"
                    class="{{ $page->slug === $guidelinePage->slug ? 'text-oss-spatie-blue font-bold' : '' }}">
                    <a href="/guidelines/{{ $guidelinePage->slug }}">
                        {{ $guidelinePage->title }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</nav>
