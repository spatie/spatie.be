<section id="team">
    <div class="wrap">
        <h2 class="title line-after mb-16">Meet the team</h2>
    </div>
    @foreach($members as $member)
        @include('pages.about.partials.member')
    @endforeach
</section>
