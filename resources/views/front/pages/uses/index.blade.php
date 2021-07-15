<?php /** @var \Illuminate\Support\Collection $technologies */ ?>

<x-page
    title="Technology Stack"
    background="/backgrounds/uses.jpg">
    <x-slot name="description">
        Tools we use to get our work done –at home or in the office
    </x-slot>

    @include('front.pages.uses.partials.banner')

    <div class="mt-4 section section-group section-fade">
        @foreach (\App\Models\Enums\TechnologyType::toArray() as $type)
            <section id="{{ $type }}" class="section">
                <div class="wrap">
                    <h2 class="title line-after mb-12">{{ ucfirst($type) }}</h2>
                </div>
                <div class="wrap wrap-6 items-start">

                    @foreach($technologies->get($type) as $technology)
                        @include('front.pages.uses.partials.technology')
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>

</x-page>
