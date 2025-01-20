@php($dark ??= false)
<footer
    @if ($dark)
        class="bg-oss-footer-dark text-oss-gray-dark"
    @else
        class="bg-white text-oss-royal-blue border-t border-oss-gray | print:bg-transparent"
    @endif
>
    <div class="flex-none pt-16 pb-8 | print:pb-2" role="navigation">
        <div class="wrap links @unless($dark) links-gray text-gray @endunless leading-loose | md:leading-normal">
            <div class="grid grid-cols-2 items-start text-sm | md:flex md:justify-between">
                {{ Menu::main()
                    ->addClass(
                        'md:grid grid-flow-col gap-6 justify-between md:text-lg | print:hidden'
                    )
                    ->setActiveClass('text-blue font-bold')
                 }}

                <div class="grid | md:grid-flow-col md:items-center md:ml-12 md:gap-12">
                    @include('layout.partials.service', ['dark' => $dark, 'footer' => true])
                </div>
            </div>
            <hr class="my-8 h-2px text-gray opacity-25 rounded | print:text-black" style="page-break-after: avoid;">
            <div class="grid gap-4 text-sm | sm:grid-cols-2 sm:gap-8 | md:flex flex-row-reverse justify-between">
                <address class="grid gap-4 | sm:gap-0 | md:grid-flow-col md:gap-8 md:text-right">
                    <div>
                        <a class="group flex items-end | md:flex-row-reverse"
                           href="https://goo.gl/maps/A2zoLK3nVF9V8jydA" target="_blank"
                           rel="nofollow noreferrer noopener">
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
                        <a href="https://www.instagram.com/spatie_be" target="_blank"
                           rel="nofollow noreferrer noopener">
                            Instagram
                        </a>
                    </li>
                    <li>
                        <a href="https://be.linkedin.com/company/spatie" rel="me" target="_blank"
                           rel="nofollow noreferrer noopener">
                            LinkedIn
                        </a>
                    </li>
                    <li>
                        <a href="https://twitter.com/spatie_be" target="_blank" rel="nofollow noreferrer noopener">
                            Twitter
                        </a>
                    </li>
                    <li>
                        <a href="https://phpc.social/@spatie" rel="me" target="_blank"
                           rel="nofollow noreferrer noopener">
                            Mastodon
                        </a>
                    </li>
                    <li>
                        <a href="https://www.youtube.com/channel/UCoBbei3S9JLTcS2VeEOWDeQ" target="_blank"
                           rel="nofollow noreferrer noopener">
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
