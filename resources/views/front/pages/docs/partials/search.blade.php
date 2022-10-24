<div
    x-data="{
        query: @entangle('query'),
        selectedHit: 0,
    }"
    x-init="$watch('query', () => this.selectedHit = 0)"
    @keyup.down.prevent="selectedHit == {{ $hits->count() }} ? selectedHit = 0 : selectedHit++; document.getElementById('hit-' + selectedHit).scrollIntoView({behavior: 'smooth', block: 'nearest', inline: 'nearest'}); document.getElementById('hit-' + selectedHit).focus()"
    @keyup.up.prevent="selectedHit == 0 ? selectedHit = 0 : selectedHit--; document.getElementById('hit-' + selectedHit).scrollIntoView({behavior: 'smooth', block: 'nearest', inline: 'nearest'}); document.getElementById('hit-' + selectedHit).focus()"
    @keyup.slash.window="$refs.search.focus()"
    class="relative w-[48rem] min-h-[16rem]"
>
    <div class="w-[calc(100%+6rem)] relative border px-4 py-3 -mt-6 -mb-6 -mx-12 flex justify-between items-center">
        <i class="fas fa-search text-slate-400 mr-1 absolute z-20"></i>
        <input wire:model="query"
               x-ref="search"
               type="search"
               placeholder="Search our docs..."
               class="w-full relative z-10 pl-6"
               @keyup.esc.window="query = ''"
        >

        <button x-on:click.prevent="$store.modals.close('search-modal')" class="text-[10px] w-12 flex items-center justify-center h-6 font-bold uppercase tracking-wide border rounded-lg">ESC</button>
    </div>

    <ul class="w-[calc(100%+3rem)] py-6  mt-6 -ml-6 flex flex-col gap-y-4 max-h-[40vh] overflow-auto">
        @if ($query !== '')
            @forelse ($hits as $index => $hit)
                <li wire:key="{{ $hit->id }}" class="block">
                    <a id="hit-{{ $index }}" :class="selectedHit == {{ $index }} ? 'bg-indigo-700 text-white' : 'bg-gray-100'" class="block focus:bg-indigo-700 hover:bg-indigo-700 focus:text-white hover:text-white group px-6 py-4 rounded" href="{{ $hit->url }}">
                        <p class="mb-1" x-html="@js($hit->title()).replace(/({{ $query }})/gi, '<strong class=\'underline group-hover:text-white group-focus:text-white'+ (selectedHit == {{ $index }} ? 'text-white' : 'text-indigo-700') +'\'>$1</strong>')"></p>
                        <p class="text-sm" x-html="@js($hit->entry).replace(/({{ $query }})/gi, '<strong class=\'underline group-hover:text-white group-focus:text-white'+ (selectedHit == {{ $index }} ? 'text-white' : 'text-indigo-700') +'\'>$1</strong>')"></p>
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
