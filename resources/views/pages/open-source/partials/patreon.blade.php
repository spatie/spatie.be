<section id="patreon" class="section">
    <div class="wrap-8">
        <div class="sm:spanx-3 sm:startx-1">
            <a class="illustration is-left is-rotated is-postcard-without-caption h-full" href="https://patreon.com/spatie">
                {{ image('support.jpg') }}
            </a>
        </div>
        <div class="sm:spanx-3 sm:startx-5">
            <div class="markup links-underline links-blue">
                <h2 class="title-2xl">Donations
                </h2>
                <p class="text-lg">
                    If you'd like to make a donation to keep us going, 
                    <a href="https://patreon.com/spatie" target="_blank" rel="noreferrer noopener">support us</a> on Patreon.
                    <a href="https://patreon.com/spatie" target="_blank" rel="noreferrer noopener"><img class="mt-8 h-10" src="/images/patreon.png"></a>
                </p>
            </div>

            @if(! $patreonPledgers->isEmpty())
                <p class="mt-8 text-lg">
                    Following patreons have helped us out in a substantial way.<br>
                </p>

                @foreach($patreonPledgers as $patreonPledger)
                    <div class="flex items-center mt-8 my-6">
                        <div class="avatar">
                            <img src="{{ $patreonPledger->avatar_url }}">
                        </div>
                        <div class="ml-4">
                            <h3 class="title-sm">
                                {{ $patreonPledger->name }}
                            </h3>
                            <p class="text-xs text-grey mt-2 links-underline links-grey">
                                {{ $patreonPledger->respectPhrase }}
                            </p>
                        </div>
                    </div>
                @endforeach

                <p class="mt-8 text-xs text-grey links-underline links-grey">
                    Want to be featured on our site as well? Check out our
                    <a href="https://patreon.com/spatie">Patreon campaign</a>.
                </p>
            @endif
        </div>
    </div>
</section>

