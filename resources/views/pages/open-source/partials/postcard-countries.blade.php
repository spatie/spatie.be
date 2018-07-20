<div class="wrap mt-16">
    <div class="inset-blue pb-16">
        <div class="wrap-inset md:items-center" style="--cols: 1fr 1fr">
            <h2 class="title-xl">
                Most active <br>countries
            </h2>
            <ul class="text-2xl leading-tight">
                @foreach($countries as $country)
                    <li class="flex items-center my-4">
                        <span class="inline-flex flex-none mr-4 rounded-full w-8 h-8 text-xs bg-blue font-sans-bold text-white items-center justify-center shadow">{{ $country['postcard_count'] }}</span>
                        {{ $country['name'] }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
