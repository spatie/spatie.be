<section id="support" class="section">
    <div class="wrap-8">
        <div class="sm:spanx-3 sm:startx-2">
            <div class="markup links-underline links-blue">
               <h2 class="title-2xl">Support us
                </h2>
                <p class="text-lg">
                    A lot of our packages are postcardware: free to use if you send us a postcard. All cards will be published on <a href="{{ route('open-source.postcards') }}">our wall</a>.
                </p>
                <p class="text-lg">
                    With a growing portfolio of {{ App\Models\Repository::count() }} packages, maintaining and supporting all issues and updates has become a substantial portion of our workload.<br>
                    Reach out and <a href="https://patreon.com/spatie" target="_blank" rel="noreferrer noopener">support us</a> on Patreon.
                    <a href="https://patreon.com/spatie" target="_blank" rel="noreferrer noopener"><img class="mt-8 h-10" src="/images/patreon.png"></a>
                </p>
            </div>
        </div>
        <div class="sm:spanx-3 sm:startx-6">
            <a class="illustration is-right is-rotated is-postcard-without-caption h-full" href="https://patreon.com/spatie" >
                {{ image('support.jpg') }}
            </a>
        </div>
    </div>
    @if($patreonPledger !== null)
    <div class="wrap pt-16">
        <p class="text-lg">
            Following patreons have helped us out in a substantial way.<br>
            Time to pay our respect!
        </p>
    </div>
    <div class="wrap-6">
        {{-- start loop for patreons --}}
        <div class="sm:spanx-2">
            @include('pages.open-source.partials.patreon')
        </div>
        {{-- end loop for patreons --}}
    </div>
    <div class="wrap">
        <p class="mt-8 text-xs text-grey links-underline links-grey">
            Want to be featured on our site as well? Check out our <a href="https://patreon.com/spatie">Patreon campaign</a>.
        </p>
    </div>
    @endif
</section>
