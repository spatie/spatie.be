@props([
    'color' => 'purple',
    'ref' => 'spatie-docs',
    'thin' => false,
])
<aside {{ $attributes->class(['agency-banner', "agency-banner-{$color}", 'agency-banner-thin' => $thin]) }}>
    {{ $slot }}
    <a href="{{ route('web-development') }}?ref={{ $ref }}" class="agency-banner-button">
        Brief us your project
    </a>
</aside>
