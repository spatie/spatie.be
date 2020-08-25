<section id=news class="section">
    <div class="wrap wrap-6">
        <div class="sm:col-span-3">
            <div class="line-l">
                <h2 class="title-sm">
                    <a href='https://github.com/issues?q=is%3Aopen+is%3Aissue+user%3Aspatie+is%3Apublic+label%3A%22good+first+issue%22'
                       class="link-black">Help us out</a>
                    <div class="title-subtext text-pink-dark">
                        Good first issues to solve
                    </div>
                </h2>
                @foreach($issues as $issue)
                    <p class="mt-4">
                        <a href="{{ $issue->url }}" target="_blank" rel="nofollow noreferrer noopener" class="link link-black">
                            {{ $issue->title }}
                        </a>
                        <br>
                        <span class="text-xs text-gray">
                            <a href="{{ $issue->repository->url }}" target="_blank" rel="nofollow noreferrer noopener">
                                {{ $issue->repository->name }}
                            </a>
                            <span class="char-separator" >•</span>
                            <a href="{{ $issue->url }}" target="_blank" rel="nofollow noreferrer noopener" class="link-underline link-blue">
                                #{{ $issue->number }}
                            </a>
                        </span>
                    </p>
                @endforeach
                <p class="mt-4">
                    <a class="link-underline link-blue"
                       href="https://github.com/search?q=is%3Aopen+is%3Aissue+user%3Aspatie+is%3Apublic+label%3A%22good+first+issue%22">
                        All good first issues on GitHub…
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
                        @include('front.pages.open-source.partials.contributor')
                    </div>
                </div>
            @endif
        </div>
        <div class="sm:col-span-3">
            <div class="line-l pt-8 | sm:pt-0">
                @include('front.pages.open-source.partials.insights')
            </div>
        </div>
    </div>
</section>
