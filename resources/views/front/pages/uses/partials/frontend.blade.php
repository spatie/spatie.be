<section id="frontend" class="section">
    <div class="wrap">
        <h2 class="title line-after mb-12">Frontend</h2>
    </div>
    <div class="wrap wrap-6 items-start">

        @foreach($technologies['frontend'] as $technology)
            @include('front.pages.uses.partials.technology')
        @endforeach
    </div>
</section>
