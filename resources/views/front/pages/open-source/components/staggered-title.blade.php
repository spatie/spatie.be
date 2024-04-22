<h2 class="font-druk uppercase md:text-center text-[50px] sm:text-[72px] md:text-[96px] leading-[0.9] mb-16 md:mb-20">
    <span class="inline-flex items-center gap-x-2 md:gap-x-8">
        {{ $icon }}
        <span>{{ $line1 }}</span>
    </span><br/>
    <span class="{{ $offset ?? 'md:-ml-[6rem]' }}">{{ $line2 }}</span><br/>
    @isset($line3)<span>{{ $line3 }}</span>@endisset
</h2>
