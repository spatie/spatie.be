@php($dark ??= false)
@php($footerCta ??= false)
<footer
    @if ($dark)
        class="bg-oss-black text-oss-gray-dark font-pt"
    @else
        class="bg-white text-oss-royal-blue border-t border-oss-gray font-pt | print:bg-transparent"
    @endif
>

    @if($footerCta)
    <div class="px-3 font-medium {{ $dark ? 'text-oss-gray-light bg-oss-footer-dark border-white/10' : 'bg-oss-gray-light border-oss-gray-medium/50' }} border-t overflow-hidden">
        <div class="px-7 py-12 md:pb-32 md:py-24">
            <div class="w-full max-w-[720px] mx-auto">
                <div class="text-center">
                    <div class="space-y-10 text-xl sm:text-2xl font-medium">
                        @php($avatars = \App\Models\Member::all()->shuffle()->take(6))
                        <div class="flex justify-center -space-x-2">
                            @foreach($avatars as $index => $member)
                                <img
                                    src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($member->email))) }}?s=80&d=mp"
                                    style="z-index: {{ 6 - $index }}"
                                    class="w-10 h-10 rounded-full border-2 {{ $dark ? 'border-oss-footer-dark' : 'border-oss-gray-light' }} object-cover"
                                    alt=""
                                >
                            @endforeach
                        </div>
                        <h2 class="font-druk uppercase text-[50px] sm:text-[72px] md:text-[96px] leading-[0.9]">Hire us for<br /> your next project</h2>
                        <p>We act as advisors and architects, not just developers. We want to be as proud of your project as you are. Tailor-made web development in Laravel is what we do best.</p>
                        <a class="text-lg font-bold inline-block bg-oss-green-pale px-5 py-4 text-center text-oss-royal-blue rounded-lg transition hover:opacity-90" href="#match">Brief us your project</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="flex-none pt-16 pb-8 | print:pb-2" role="navigation">
        <div class="wrap links @unless($dark) links-gray text-gray @endunless leading-loose | md:leading-normal">
            <div class="grid grid-cols-2 items-start text-sm | md:flex md:justify-between">
                {{ Menu::main()
                    ->addClass(
                        'md:grid grid-flow-col gap-6 justify-between md:text-base | print:hidden'
                    )
                    ->setActiveClass('text-white font-bold')
                 }}

                <div class="grid | md:grid-flow-col md:items-center md:ml-12 md:gap-12">
                    {{ Menu::serviceFooter()
                        ->addItemClass(($dark ?? false) ? 'hover:text-oss-royal-blue-light' : 'text-oss-royal-blue-light sm:text-oss-royal-blue')
                        ->setActiveClass('font-bold')
                    }}
                </div>
            </div>
            <hr class="my-8 h-2px text-gray opacity-25 rounded | print:text-black" style="page-break-after: avoid;">
            <div class="grid gap-4 text-sm | sm:grid-cols-2 sm:gap-8 | md:flex flex-row-reverse justify-between">
                <address class="grid gap-4 | sm:gap-0 | md:grid-flow-col md:gap-8 md:text-right">
                    <div>
                        <a class="group flex items-end | md:flex-row-reverse"
                           href="https://goo.gl/maps/A2zoLK3nVF9V8jydA" target="_blank" rel="nofollow noreferrer noopener">
                            <span>
                                Kruikstraat 22, Box 12
                                <br>
                                2018 Antwerp, Belgium
                            </span>
                            <span class="icon mb-px px-1 fill-current text-gray-lighter group-hover:text-pink transition-all transition-100 | print:hidden">
                                {{ app_svg('icons/fas-map-marker-alt') }}
                            </span>
                        </a>
                    </div>
                    <div>
                        <a href="mailto:info@spatie.be">info@spatie.be</a>
                        <br>
                        <a href="#tel">+32 3 292 56 79</a>
                    </div>
                </address>
                <ul class="hidden | md:grid md:grid-flow-col md:gap-6 | print:hidden">
                    <li>
                        <a href="https://github.com/spatie" target="_blank" rel="nofollow noreferrer noopener">
                            GitHub
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/spatie_be" target="_blank" rel="nofollow noreferrer noopener">
                            Instagram
                        </a>
                    </li>
                    <li>
                        <a href="https://be.linkedin.com/company/spatie" rel="me" target="_blank" rel="nofollow noreferrer noopener">
                            LinkedIn
                        </a>
                    </li>
                    <li>
                        <a href="https://x.com/spatie_be" target="_blank" rel="nofollow noreferrer noopener">
                            X
                        </a>
                    </li>
                    <li>
                        <a href="https://bsky.app/profile/spatie.be" target="_blank" rel="nofollow noreferrer noopener">
                               Bluesky
                        </a>
                    </li>
                    <!-- Keeping this here for Mastodon profile verificaiton -->
                    <li class="hidden">
                        <a href="https://phpc.social/@spatie" rel="me" target="_blank" rel="nofollow noreferrer noopener">
                            Mastodon
                        </a>
                    </li>
                    <li>
                        <a href="https://www.youtube.com/channel/UCoBbei3S9JLTcS2VeEOWDeQ" target="_blank" rel="nofollow noreferrer noopener">
                            YouTube
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="wrap">
        <ul class="grid md:grid-flow-col justify-start @if($dark) text-oss-gray-dark @else links links-gray opacity-50 @endif text-xs py-4 | md:justify-end md:gap-6 | print:hidden">
            <li><a href="{{ route('legal.privacy') }}">Privacy</a></li>
            <li><a href="{{ route('legal.disclaimer') }}">Disclaimer</a></li>
        </ul>
    </div>
</footer>

@include('layout.partials.modal-telephone')
@include('layout.partials.modal-match', ["caption" => "How can we help you?"])
