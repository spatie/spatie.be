@props(['title', 'phase', 'current', 'sections'])

@php
    $phases = [
        'research-and-analysis' => ['01', 'Research & Analysis', 'Research'],
        'strong-foundation' => ['02', 'Build a Strong Foundation', 'Foundation'],
        'flexible-development' => ['03', 'Flexible Development', 'Development'],
    ];
@endphp

<x-page :title="$title" body-class="bg-oss-black text-oss-gray font-medium font-pt antialiased mb-0" dark>
    <x-slot:description>{{ $description }}</x-slot:description>
    <x-og-image view="og-image.services" />

    <div class="process-page process-page-{{ $phase }}">
        <a class="process-back" href="{{ route('web-development') }}#process"><span aria-hidden="true">←</span> Web development</a>

        <nav class="process-phase-nav" aria-label="Development phases">
            @foreach($phases as $slug => [$number, $label, $shortLabel])
                <a href="{{ route('web-development.'.$slug) }}" aria-label="{{ $number }} {{ $label }}" @if($slug === $current) aria-current="page" @endif>
                    <span class="process-phase-number">{{ $number }}</span>
                    <span class="hidden md:inline">{{ $label }}</span>
                    <span class="md:hidden">{{ $shortLabel }}</span>
                </a>
            @endforeach
        </nav>

        <header class="process-hero">
            <div>
                <span class="process-number">{{ $phase }} <span>/ 03</span></span>
                <h1>{{ $heading }}</h1>
                <p>{{ $intro }}</p>
            </div>
            <x-services-phase-tag :phase="$phase" class="process-hero-tag" aria-hidden="true" />
        </header>

        <div class="process-reading-layout">
            <nav class="process-index" aria-label="On this page">
                <span class="mb-3 text-xs uppercase font-bold">On this page</span>
                @foreach($sections as $id => $label)
                    <a href="#{{ $id }}">{{ $label }} <span aria-hidden="true">↘</span></a>
                @endforeach
            </nav>
            <article class="process-content">
                {{ $slot }}
                <nav class="process-onward" aria-label="Continue">
                    @if($phase === '02')
                        <a class="process-prev" rel="prev" href="{{ route('web-development.research-and-analysis') }}">← Research &amp; Analysis</a>
                    @elseif($phase === '03')
                        <a class="process-prev" rel="prev" href="{{ route('web-development.strong-foundation') }}">← Build a Strong Foundation</a>
                    @endif
                    {{ $next }}
                </nav>
            </article>
        </div>
    </div>

    @include('layout.partials.modal-match', ['caption' => 'Time to talk?'])
</x-page>
