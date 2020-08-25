@if ($editing)
    <div class="inline-flex">
        <input
            type="search"
            class="text-xs form-input w-full h-8 py-0 px-2 mb-8"
            placeholder="Domain"
            wire:model="domain"
        >
        <a href="#" class="cursor-pointer
bg-green-dark bg-opacity-75 hover:bg-opacity-100 rounded-sm
border-2 border-transparent
justify-center flex items-center
px-6 h-8
font-sans-bold text-white
transition-bg duration-300
focus:outline-none focus:border-blue-light whitespace-no-wrap" wire:click.prevent="save">
            Save
        </a>
    </div>
@else
    <div class="inline-flex">
        <span>{{ $domain ?? 'no domain set' }}&nbsp;</span>
        <a href="#" class="text-green-dark underline" wire:click.prevent="edit">
            edit
        </a>
        <span class="char-searator mx-1">•</span>
    </div>
@endif
