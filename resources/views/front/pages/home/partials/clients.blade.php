<section id="clients" class="section">
    <div class="wrap">
        <h2 class="title-sm | text-center text-gray">
            <a class="link-underline link-black" href="{{ route('web-development') }}#clients">Clients we work with</a>
        </h2>
    </div>
    <div class="wrap grid grid-cols-2 mt-8 col-gap-8 row-gap-2 | md:grid-cols-4 md:col-gap-16">
        @foreach(config('clients') as $client)
            <div class="text-center">
                <a class="w-full max-w-logoclient inline-block" href="{{ $client['website'] }}" target="_blank" rel="noreferrer noopener">{{ svg($client['logo']) }}</a>
            </div>
        @endforeach
    </div>
</section>
