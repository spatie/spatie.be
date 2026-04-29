<section id="team" class="w-full max-w-[1080px] mx-auto px-7 lg:px-0">
    <h2 class="font-druk uppercase text-[40px] sm:text-[72px] leading-[0.9] mb-12">Meet the team</h2>
    <div class="grid sm:grid-cols-2 gap-12">
        @foreach($members as $member)
            @include('front.pages.about.partials.member')
        @endforeach
    </div>
</section>
