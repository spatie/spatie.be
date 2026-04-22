@php
    $clients = [
        ['logo' => 'tomorrowland.svg', 'name' => 'Tomorrowland', 'caption' => 'Custom platform for one of the world\'s largest music festivals.'],
        ['logo' => 'the-team.svg', 'name' => 'THE-TEAM', 'caption' => 'TODO: add caption.'],
        ['logo' => 'ticketmatic.svg', 'name' => 'Ticketmatic', 'caption' => 'Ticketing infrastructure for venues and event organizers at scale.'],
        ['logo' => 'trainin.svg', 'name' => 'Trainin', 'caption' => 'TODO: add caption.'],
        ['logo' => 'megatix.svg', 'name' => 'Megatix', 'caption' => 'TODO: add caption.'],
        ['logo' => 'megatix.svg', 'name' => 'TODO: replace duplicate', 'caption' => 'TODO: add caption.'],
    ];
@endphp

<section id="clients" class="w-full max-w-[1320px] mx-auto px-7 lg:px-0">
    <div class="grid grid-cols-3">
        @foreach($clients as $client)
            <div class="flex flex-col items-center justify-center gap-4 p-10 border-dotted border-white/10 [&:not(:nth-child(3n+1))]:border-l [&:nth-child(n+4)]:border-t">
                <img src="/images/clients/{{ $client['logo'] }}" alt="{{ $client['name'] }}" class="h-8 opacity-60">
                <p class="text-center text-xs text-oss-gray-dark max-w-[200px]">{{ $client['caption'] }}</p>
            </div>
        @endforeach
    </div>
</section>
