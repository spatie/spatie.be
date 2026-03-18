<{{ $as ?? 'div' }} {{ $attributes->except(['as'])->merge(['class' => 'px-6 md:px-16']) }}>
    {{ $slot }}
</{{ $as ?? 'div' }}>
