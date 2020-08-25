@if ($editing)
    <div class="inline-flex">
        <input
            type="search"
            class="text-xs form-input w-full h-8 py-0 px-2 mb-8 rounded-r-none border-r-0"
            placeholder="Domain"
            wire:model="domain"
            wire:keydown.enter="save"
        >
        <a href="#" class="text-sm cursor-pointer
            bg-green-dark bg-opacity-75 hover:bg-opacity-100 rounded-r-sm
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
        <span>{{ $domain ?: 'No domain set' }}</span>
        <a href="#" class="ml-1 link-blue link-underline" wire:click.prevent="edit">
            Edit
        </a>
        <span class="char-separator mx-1">•</span>
@endif
