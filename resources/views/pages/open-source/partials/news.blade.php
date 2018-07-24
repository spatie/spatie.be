<section id=news class="section">
    <div class="wrap-6">
        <div class="sm:spanx-3">
            <div class="line-l">
                <h2 class="title-sm">
                    <a href='https://github.com/issues?q=is%3Aopen+is%3Aissue+user%3Aspatie+is%3Apublic+label%3A%22good+first+issue%22'
                       class="link-black">Help us out</a>
                    <div class="title-subtext text-pink">
                        Easy issues to solve
                    </div>
                </h2>
                <p class="mt-4">
                    <a class="link link-black" href="#">
                        Connect with S3
                    </a>
                    <br>
                    <span class="text-xs text-grey">Laravel Media Library <span class="char-separator">•</span> <a class="link-underline link-blue" href="#">#152</a></span>
                </p>
                <p class="mt-4">
                    <a class="link link-black" href="#">
                        Upgrade to Laravel 5.7
                    </a>
                    <br>
                    <span class="text-xs text-grey">Laravel Media Library <span class="char-separator">•</span> <a class="link-underline link-blue" href="#">#153</a></span>
                </p>
                <p class="mt-4">
                    <a class="link-underline link-blue"
                       href='https://github.com/issues?q=is%3Aopen+is%3Aissue+user%3Aspatie+is%3Apublic+label%3A%22good+first+issue%22'>
                        All easy issues on GitHub…
                    </a>
                </p>
            </div>
            @if($contributor)
                <div class="mt-12 pl-4">
                    <p>
                        We would be nowhere without the help of the great community.
                        Just look at this wonderful human being!
                    </p>
                    <div class="mt-4">
                        @include('pages.open-source.partials.contributor')
                    </div>
                </div>
            @endif
        </div>
        <div class="sm:spanx-3">
            <div class="line-l pt-8 | sm:pt-0">
                @include('pages.open-source.partials.insights')
            </div>
        </div>
    </div>
</section>
