@props([
    'value',
    'label',
])
<div class="p-[60px] sm:p-[40px] md:p-[60px] text-center">
    <div class="text-[60px] md:text-[120px] font-druk uppercase text-oss-gray leading-none mb-2">{{ $value }}</div>
    <p class="text-oss-gray-dark uppercase font-bold tracking-wide text-[14px] leading-tight">{!! $label !!}</p>
</div>
