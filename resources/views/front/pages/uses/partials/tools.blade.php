<section id="integrations" class="section">
    <div class="wrap">
        <h2 class="title line-after mb-12">Tools</h2>
    </div>
    <div class="wrap wrap-6 items-start">

        @foreach($technologies['tools'] as $technology)
            @include('front.pages.uses.partials.technology')
        @endforeach
    </div>
</section>
