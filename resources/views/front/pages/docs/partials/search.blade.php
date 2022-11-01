<div
    x-data="{
        query: @entangle('query'),
        selectedHit: 0,
    }"
    x-init="$watch('query', () => this.selectedHit = 0)"
    @keyup.down.prevent="selectedHit == {{ $hits->count() }} - 1 ? selectedHit = 0 : selectedHit++; document.getElementById('hit-' + selectedHit).scrollIntoView({behavior: 'smooth', block: 'nearest', inline: 'nearest'}); document.getElementById('hit-' + selectedHit).focus()"
    @keyup.up.prevent="selectedHit == 0 ? selectedHit = {{ $hits->count() }} - 1 : selectedHit--; document.getElementById('hit-' + selectedHit).scrollIntoView({behavior: 'smooth', block: 'nearest', inline: 'nearest'}); document.getElementById('hit-' + selectedHit).focus()"
    @keyup.slash.window="$refs.search.focus()"
    class="relative"
    style="width: 48rem; min-height: 16rem"
>
    <div style="width: calc(100% + 6rem)" class="relative border-b border-blue-lighter px-4 py-3 -mt-6 -mb-6 -mx-12 flex justify-between items-center">
        <input wire:model="query"
               x-ref="search"
               type="search"
               placeholder="Search our docs..."
               class="w-full relative z-10"
               @keyup.esc.window="query = ''"
        >

        <button x-on:click.prevent="$store.modals.close('search-modal')" class="text-xs w-12 flex text-gray border-gray items-center justify-center h-6 font-bold uppercase tracking-wide border rounded-lg">ESC</button>
    </div>

    <ul class="py-6 mt-6 -ml-8 flex flex-col gap-y-4 overflow-auto" style="width: calc(100% + 4rem); max-height: 40vh">
        @if ($query !== '')
            @forelse ($hits as $index => $hit)
                <li wire:key="{{ $hit->id }}" class="block">
                    <a id="hit-{{ $index }}" :class="selectedHit == {{ $index }} ? 'bg-blue-light text-white' : 'bg-gray-100'" class="block outline-none hover:bg-blue-light focus:text-white hover:text-white group px-4 py-3 rounded" href="{{ $hit->url }}">
                        <p class="mb-1" x-html="@js($hit->title()).replace(/({{ $query }})/gi, '<strong class=\'underline group-hover:text-white group-focus:text-white'+ (selectedHit == {{ $index }} ? 'text-white' : 'text-blue-light') +'\'>$1</strong>')"></p>
                        <p class="text-sm" x-html="@js($hit->entry).replace(/({{ $query }})/gi, '<strong class=\'underline group-hover:text-white group-focus:text-white'+ (selectedHit == {{ $index }} ? 'text-white' : 'text-blue-light') +'\'>$1</strong>')"></p>
                    </a>
                </li>
            @empty
                <p class="text-slate-500">No results found…</p>
            @endforelse
        @else
            <p class="text-slate-500">Enter a search term to find results in the documentation.</p>
        @endif
    </ul>
</div>
