<div class="mb-16 bg-white p-16 rounded-[16px] text-[18px]">
    <h1 class="font-druk uppercase text-blue font-bold text-[72px] leading-[0.9] mb-5">
        {{ ucfirst($repository->slug) }}
    </h1>
    <div class="mb-10">
        {{ $alias->slogan }}
    </div>
    @if($repository->slug !== 'laravel-medialibrary-pro')
        <div>
            <h3 class="font-bold mb-5">Useful links</h3>
            <ul class="text-base">
                <li class="flex items-center gap-x-2">
                    <svg class="w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 18 18">
                        <path fill="#172A3D"
                              d="m12.686 9-.53.53-4.5 4.5-.532.532L6.063 13.5l.53-.53L10.562 9 6.595 5.03l-.532-.53 1.061-1.062.53.53 4.5 4.5.532.532Z"/>
                    </svg>
                    <a class="underline" href="https://github.com/spatie/{{ $repository->slug }}">Repository</a>
                </li>
                <li class="flex items-center gap-x-2">
                    <svg class="w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 18 18">
                        <path fill="#172A3D"
                              d="m12.686 9-.53.53-4.5 4.5-.532.532L6.063 13.5l.53-.53L10.562 9 6.595 5.03l-.532-.53 1.061-1.062.53.53 4.5 4.5.532.532Z"/>
                    </svg>
                    <a class="underline"
                       href="https://github.com/spatie/{{ $repository->slug }}/discussions">Discussions</a>
                </li>
            </ul>
        </div>
    @endif
</div>
