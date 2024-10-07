<{{ $as ?? 'div' }} {{ $attributes->except('as')->twMerge('w-full max-w-wrapper mx-auto') }}>
    {{ $slot }}
</{{ $as ?? 'div' }}>
