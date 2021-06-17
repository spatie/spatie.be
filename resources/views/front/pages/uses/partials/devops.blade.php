<section id="devops" class="section">
    <div class="wrap">
        <h2 class="title line-after mb-12">Devops</h2>
    </div>
    <div class="wrap wrap-6 items-start">

        @foreach($technologies->get('devops') as $technology)
            @include('front.pages.uses.partials.technology')
        @endforeach
    </div>
</section>
