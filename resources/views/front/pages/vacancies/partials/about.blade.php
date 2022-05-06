@unless($hideRick ?? false)
<div class="wrap wrap-6">
    <div class="sm:col-span-4">
        <p class="text-2xl">
            Cool that you found out about this vacancy! 
            <br>Are you a recruiter? <a class="link-underline link-blue" title="📵 Stop calling us and dance 🕺!" href="{{ route('vacancies.recruiters')}}">Read on</a>.
        </p>
    </div>
</div>
@endif

<div class="wrap wrap-6 items-center">
    <div class="my-16 sm:col-span-3 markup links-underline links-blue">
        <h3 class="title">Spatie</h3>
        <p>We are architects and builders, tinkering on the front line; an open-source mastodon operated by a highly talented bunch the size of a soccer team.
            We purposefully keep the company small but knowledgeable.
        </p>
        <p>
        What does this bring to you? Learn and grow fast in a respectful, almost familiar environment. Yet you'll have an enormous impact on users worldwide.
        Together we'll decide where we'll go next. 
        </p>
        <p>Rest assured: there will be laughs and great food along the way.</p> 
    </div>
    <div class="hidden | sm:block sm:col-span-3 sm:col-start-4">
        <div class="ml-24 w-full h-0" style="padding-bottom: 75%">
            <div class="absolute inset-0 illustration h-full" title="Team">
                {{ image('vacancies/about-2.jpg') }}
            </div>
        </div>
    </div>
    <div class="sm:hidden illustration is-rotated is-postcard-without-caption h-full" title="Team">
        {{ image('vacancies/about-2.jpg') }}
    </div>
</div>
