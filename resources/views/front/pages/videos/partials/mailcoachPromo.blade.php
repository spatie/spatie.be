<div class="card gradient gradient-green text-white mx-0">
    <div class="wrap-card grid md:grid-cols-2 md:items-start">
        <a class="font-sans-bold bg-white hover:text-green-dark justify-center flex items-center px-6 py-2 rounded-full text-green text-xl"
           href="https://mailcoach.app/videos">
            Get all videos
        </a>
        <div>
            <p class="text-base">
                These videos are part of a <strong><a href="https://mailcoach.app/videos">premium course on building Mailcoach</a></strong>.

                @if (sponsorIsViewingPage())
                    As a sponsor, you can grab the entire course with 15$ off with following coupon:
                @else
                    Sponsors will receive a coupon code that offers a discount when purchasing the course.
                @endif
            </p>

            @if (sponsorIsViewingPage())
                <div class="mt-2 font-mono opacity-75">{{ config('services.promo_codes.package_training') }}</div>
            @endif
        </div>
    </div>
</div>