<footer class="bg-grey-lightest gradient-linear shadow-inner-light | print:shadow-none print:bg-transparent print:gradient-none" style="--gradient-angle: 120deg; --gradient-from:#f3efea; --gradient-to:#e1ded9;">
    <div class="flex-none pt-16 pb-8 | print:pb-2" role="navigation">
        <div class="wrap links links-grey leading-loose | md:leading-normal">
            @include('layout.partials.menu')
            <hr class="my-8 h-2px text-grey opacity-25 rounded | print:text-black" style="page-break-after: avoid;">
            <div class="grid gapy-4 text-sm | sm:grid-repeat sm:gapx-8 | md:flex flex-row-reverse justify-between" style="--col-repeat:2;--row-repeat:1;">
                <address class="grid gapy-4 | sm:gap-0 | md:grid-flow-column md:gapx-8 md:text-right">
                    <div>
                        <a class="group flex items-end | md:flex-row-reverse" href="https://goo.gl/maps/Qe39fmR5RTC2" target="_blank" rel="nofollow noreferrer noopener">
                            <span>
                                Samberstraat 69D
                                <br>
                                2060 Antwerp, Belgium
                            </span>
                            <span class="icon px-2 fill-grey-lighter group-hover:fill-pink transition-fill transition-fast | print:hidden">
                                {{ svg('icons/fas-map-marker-alt') }}
                            </span>
                        </a>
                    </div>
                    <div>
                        <a href="mailto:info@spatie.be">info@spatie.be</a>
                        <br>
                        <a href="#tel">+32 3 292 56 79</a>
                    </div>
                </address>
                <ul class="hidden grid-flow-column gapx-8 | sm:block md:order-0 md:grid | print:hidden">
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
                        <a href="https://patreon.com/spatie" target="_blank" rel="nofollow noreferrer noopener">
                            Patreon
                        </a>
                    </li>
                    <li>
                        <a href="https://twitter.com/spatie_be" target="_blank" rel="nofollow noreferrer noopener">
                            Twitter
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="wrap links links-grey text-xs py-4 opacity-50 | print:hidden">
        <a href="{{ route('legal.privacy') }}">Privacy</a>
        <a class="ml-4" href="{{ route('legal.disclaimer') }}">Disclaimer</a>
    </div>
</footer>

@include('layout.partials.modal-telephone')
