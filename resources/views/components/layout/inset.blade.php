<{{ $as ?? 'div' }} {{ $attributes->except(['as'])->twMerge('px-6 md:px-16') }}>
    {{ $slot }}
</{{ $as ?? 'div' }}>
