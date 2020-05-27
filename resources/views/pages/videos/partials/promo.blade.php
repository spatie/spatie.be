<div class="inset-green mx-0">
    <div class="wrap-inset md:items-start" style="--cols: auto 1fr">
        <a class="font-sans-bold bg-white hover:text-green-dark justify-center flex items-center px-6 py-2 rounded-full text-green text-xl"
           href="https://laravelpackage.training">
            Get all videos
        </a>
        <div>
            <p class="text-base">
                These videos are part of a <strong><a href="https://laravelpackage.training">premium course on package
                        development</a></strong>.

                @if (sponsorIsViewingPage())
                    As a sponsor, you can grab the entire course with 15$ off with following coupon:
                @endif
            </p>

            @if (sponsorIsViewingPage())
                <div class="mt-2 font-mono opacity-75">{{ config('services.promo_codes.package_training') }}</div>
            @endif
        </div>
    </div>
</div>