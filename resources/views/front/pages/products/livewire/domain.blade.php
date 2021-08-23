<span class="inline-flex items-center w-full">
    @if ($editing)
        <div class="inline-flex">
            <div>
                <input
                    type="text"
                    class="text-xs form-input w-full h-8 py-0 px-2 rounded-r-none border-r-0"
                    placeholder="Domain"
                    wire:model="domain"
                    wire:keydown.enter="save"
                >
                @error('domain')
                    <p class="text-red">{{ $message }}</p>
                @enderror
            </div>
            <a
                href="#"
                wire:click.prevent="save"
                class="text-sm cursor-pointer
                    bg-green-dark bg-opacity-75 hover:bg-opacity-100 rounded-r-sm
                    border-2 border-transparent
                    justify-center flex items-center
                    px-6 h-8
                    font-sans-bold text-white
                    transition-bg duration-300
                    focus:outline-none focus:border-blue-light whitespace-no-wrap"
            >
                Save
            </a>
        </div>
    @else
            <span class="text-sm">{{ $domain ?: 'No domain set' }}</span>
            <a href="#"
               class="ml-1 link-blue link-underline"
               wire:click.prevent="edit"
            >Edit</a>
    @endif
</span>
