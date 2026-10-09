@props(['phase'])

<span {{ $attributes->class(['phase-tag', 'phase-tag-'.$phase]) }}>
    <span class="phase-tag-pin" aria-hidden="true"></span>
    @if($phase === '01')
        <span class="phase-tag-script">Grab a</span>
        <span class="phase-tag-title">notebook</span>
    @elseif($phase === '02')
        <span class="phase-tag-title">Hard hats</span>
        <span class="phase-tag-script">on</span>
    @else
        <span class="phase-tag-script">Plot twists</span>
        <span class="phase-tag-title">welcome</span>
    @endif
    <span class="phase-tag-arrow" aria-hidden="true">↗</span>
</span>
