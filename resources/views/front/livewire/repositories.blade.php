<section id="packages" class="border-t border-oss-gray-extra-dark pt-20 mb-20 max-w-[1320px] mx-auto">
    <div class="sm:flex justify-between items-end mb-20 w-full">
        <h2 class="font-druk uppercase font-bold text-[50px] md:text-[96px] leading-[0.9] mb-6 md:mb-0">All<br/>packages</h2>
        @if($this->filterable)
            <div class="flex flex-col sm:flex-row gap-4 sm:gap-12 items-baseline sm:items-center justify-between mb-8">
                <div class="">
                    <label for="sort" class="text-[16px] text-oss-gray-dark mr-6">
                        Sort by
                    </label>
                    <div class="select p-0 text-[16px] bg-oss-black border-none text-oss-gray">
                        <select class="text-oss-gray" name="sort" wire:model.live="sort">
                            <option value="-downloads">downloads</option>
                            <option value="name">name</option>
                            <option value="-stars">popularity</option>
                            <option value="-repository_created_at">date</option>
                        </select>
                        <span class="select-arrow pl-2.5 -mt-2">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16"><rect width="16" height="16" fill="#EAE8E5" rx="8"/><path fill="#172A3D" d="m8 11.61.471-.47 4-4 .473-.473L12 5.723l-.47.471L8 9.724 4.471 6.195l-.47-.473-.944.944.47.47 4 4 .473.474Z"/></svg>
                        </span>
                    </div>
                </div>
                <div class="relative w-full">
                    <input
                        type="search"
                        class="w-full form-input text-white bg-oss-black rounded-[12px] border-oss-gray-extra-dark placeholder-oss-gray py-4 px-6 h-[56px]"
                        placeholder="Find a package ..."
                        wire:model.live="search"
                    >
                    <svg class="w-4 h-4 absolute right-0 top-0 mt-4 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16"><path stroke="#EAE8E5" stroke-width="2" d="m15 15-4-4m-4 2A6 6 0 1 1 7 1a6 6 0 0 1 0 12Z"/></svg>
                </div>
            </div>
        @endif
    </div>

    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-10">
        @foreach($repositories as $repository)
            <x-oss-link-card :title="$repository->name">
                <p class="mb-28">{{ $repository->description }}</p>
                <div class="flex items-center gap-x-5 mb-5">
                    <a class="text-sm flex items-center gap-x-2" href="{{ $repository->url }}" target="_blank">
                        <svg class="w-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
                        <span class="underline">GitHub</span>
                    </a>
                    @if ($repository->documentation_url)
                        <a class="text-sm flex items-center gap-x-2" href="{{ $repository->documentation_url }}" target="_blank">
                            <svg class="w-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
                            <span class="underline">Documentation</span>
                        </a>
                    @endif
                </div>
                <div class="flex items-center gap-x-5">
                    <span class="text-sm flex items-center gap-x-2">
                        <svg class="w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 14"><path fill="#EAE8E5" d="m11 6-5 5-5-5V5h3V0h4v5h3v1ZM1 12h11v2H0v-2h1Z"/></svg>
                        <span>{{ number_format($repository->downloads) }}</span>
                    </span>
                    <span class="text-sm flex items-center gap-x-2">
                        <svg class="w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16"><path fill="#EAE8E5" d="m9.003 0 2.703 5.125 5.71.987-4.04 4.154L14.2 16l-5.197-2.556L3.803 16l.825-5.734L.591 6.112l5.706-.987L9.003 0Z"/></svg>
                        <span>{{ number_format($repository->stars) }}</span>
                    </span>
                </div>
            </x-oss-link-card>
        @endforeach
        @unless(count($repositories))
            <p class="mt-12 text-lg text-gray">
                Apparently there's not a Spatie package for everything! <br>
                Maybe check back later.
            </p>
        @endunless
    </div>
</section>
