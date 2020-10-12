<section id="team" class="section">
    <div class="wrap">
        <h2 class="title line-after mb-12">Meet the team</h2>
    </div>
    <div class="wrap wrap-6 items-start">
        @foreach($members as $member)
            @include('front.pages.about.partials.member')
        @endforeach
    </div>
</section>
