<footer class="bg-grey-lightest gradient-linear shadow-inner-light" style="--gradient-angle: 120deg; --gradient-from:#f3efea; --gradient-to:#e1ded9;">
    <div class="flex-none pt-16 pb-8" role="navigation">
        <div class="wrap links links-grey leading-loose | md:leading-normal">
            @include('layout.partials.menu')
            <hr class="my-8 h-2px text-grey opacity-25 rounded">
            <div class="grid gapy-4 text-sm | sm:grid-repeat sm:gapx-8 | md:flex flex-row-reverse justify-between" style="--col-repeat:2;--row-repeat:1;">
                <address class="grid gapy-4 | sm:gap-0 | md:grid-flow-column md:gapx-8 md:text-right">
                    <div>
                        <a class="group flex items-end | md:flex-row-reverse" href="https://goo.gl/maps/Qe39fmR5RTC2" target="_blank">
                            <span>
                                Samberstraat 69D
                                <br>
                                2060 Antwerp, Belgium
                            </span>
                            <span class="px-2 text-grey-lighter group-hover:text-pink transition-color transition-fast">
                                <i class="fas fa-map-marker-alt"></i>
                            </span>
                        </a>
                    </div>
                    <div>
                        <a href="mailto:info@spatie.be">info@spatie.be</a>
                        <br>
                        <a href="#tel">+32 3 292 56 79</a>
                    </div>
                </address>
                <ul class="hidden grid-flow-column gapx-8 | sm:block md:order-0 md:grid">
                    <li>
                        <a href="https://github.com/spatie" target="_blank">
                            GitHub
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/spatie_be" target="_blank">
                            Instagram
                        </a>
                    </li>
                    <li>
                        <a href="https://patreon.com/spatie" target="_blank">
                            Patreon
                        </a>
                    </li>
                    <li>
                        <a href="https://twitter.com/spatie_be" target="_blank">
                            Twitter
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="wrap links links-grey text-xs py-4 opacity-50">
        <a href="{{ route('legal.privacy') }}">Privacy</a>
        <a class="ml-4" href="{{ route('legal.disclaimer') }}">Disclaimer</a>
    </div>
</footer>

@include('layout.partials.modal-telephone')
