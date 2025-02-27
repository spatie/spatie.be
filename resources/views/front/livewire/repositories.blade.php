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
                            <option value="-stars">popularity</option>
                            <option value="-downloads">downloads</option>
                            <option value="name">name</option>
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
                        wire:model.debounce.live="search"
                    >
                    <svg class="w-4 h-4 absolute right-0 top-0 mt-4 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16"><path stroke="#EAE8E5" stroke-width="2" d="m15 15-4-4m-4 2A6 6 0 1 1 7 1a6 6 0 0 1 0 12Z"/></svg>
                </div>
            </div>
        @endif
    </div>

    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-10">
        @foreach($repositories as $repository)
            <x-oss-link-card as="a" :href="$repository->url" :title="$repository->name">
                <div class="h-full flex flex-col">
                    <p class="mb-24">{{ $repository->description }}</p>
                    <div class="flex items-center gap-x-5 mt-auto">
                        <span class="text-sm flex items-center gap-x-2">
                            <svg class="w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 14"><path fill="#EAE8E5" d="m11 6-5 5-5-5V5h3V0h4v5h3v1ZM1 12h11v2H0v-2h1Z"/></svg>
                            <span>{{ number_format($repository->downloads) }}</span>
                        </span>
                        <span class="text-sm flex items-center gap-x-2">
                            <svg class="w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16"><path fill="#EAE8E5" d="m9.003 0 2.703 5.125 5.71.987-4.04 4.154L14.2 16l-5.197-2.556L3.803 16l.825-5.734L.591 6.112l5.706-.987L9.003 0Z"/></svg>
                            <span>{{ number_format($repository->stars) }}</span>
                        </span>
                    </div>
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
    @if ($this->hasMore)
        <div class="w-full flex justify-center my-24" x-intersect="$wire.loadMore()">
            <svg class="animate-spin w-10 h-10 fill-current text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path class="fa-secondary" opacity=".4" d="M0 256C0 114.9 114.1 .5 255.1 0C237.9 .5 224 14.6 224 32c0 17.7 14.3 32 32 32C150 64 64 150 64 256s86 192 192 192c69.7 0 130.7-37.1 164.5-92.6c-3 6.6-3.3 14.8-1 22.2c1.2 3.7 3 7.2 5.4 10.3c1.2 1.5 2.6 3 4.1 4.3c.8 .7 1.6 1.3 2.4 1.9c.4 .3 .8 .6 1.3 .9s.9 .6 1.3 .8c5 2.9 10.6 4.3 16 4.3c11 0 21.8-5.7 27.7-16c-44.3 76.5-127 128-221.7 128C114.6 512 0 397.4 0 256z"/><path class="fa-primary" d="M224 32c0-17.7 14.3-32 32-32C397.4 0 512 114.6 512 256c0 46.6-12.5 90.4-34.3 128c-8.8 15.3-28.4 20.5-43.7 11.7s-20.5-28.4-11.7-43.7c16.3-28.2 25.7-61 25.7-96c0-106-86-192-192-192c-17.7 0-32-14.3-32-32z"/></svg>
        </div>
    @endif
</section>
