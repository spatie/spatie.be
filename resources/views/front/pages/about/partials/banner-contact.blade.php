<p class="text-2xl mt-12 grid col-gap-16 row-gap-4 | md:mt-16 md:grid-flow-col justify-start items-start">
    <span>
        <a class="link link-black" href="mailto:info@spatie.be">info@spatie.be</a>
        <br>
        <a class="link link-black" href="https://twitter.com/intent/tweet?text=Dear+@spatie_be+…" target="_blank" rel="noreferrer noopener">@spatie_be</a>
        <br>
        <a class="link link-black" href="#tel">+32 3 292 56 79</a>
    </span>
    <a class="group block link link-black" href="https://goo.gl/maps/A2zoLK3nVF9V8jydA" target="_blank" rel="noreferrer noopener">
            Kruikstraat 22, Box 12
            <br>
            2018 Antwerp
            <br>
            Belgium
            <span class="icon px-2 fill-current text-pink group-hover:opacity-75 transition-fill transition-100">
                {{ svg('icons/fas-map-marker-alt') }}
            </span>
        </span>
    </a>
    @isset($financialContacts)
        <span class="text-xs mt-2 leading-loose">
            <span class="w-8 inline-block text-gray">VAT</span> BE0809.387.596
            <br>
            {{-- IBAN nr spaced out for readability but selectable with double click. --}}
            <span class="w-8 inline-block text-gray">IBAN</span> BE36<span class=ml-1>7350</span><span class=ml-1>5382</span><span class=ml-1>4981</span>
            <br>
            <span class="w-8 inline-block text-gray">BIC</span> KREDBEBB
        </span>
    @endisset
</p>
