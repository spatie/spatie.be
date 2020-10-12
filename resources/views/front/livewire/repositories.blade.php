<div>
    @if($this->filterable)
        <div class="wrap flex justify-start mb-8">
            
        </div>
        <div class="wrap">
            <div class="flex items-baseline justify-between mb-8">
                <input
                type="search"
                class="form-input px-4"
                placeholder="Search packages..."
                wire:model="search"
                >
                <div class="ml-6">
                    <label for="sort" class="text-gray mr-2">
                            Sort
                    </label>
                    <div class="select">
                        <select name="sort" wire:model="sort">
                            <option value="-downloads">by downloads</option>
                            <option value="name">by name</option>
                            <option value="-stars">by popularity</option>
                            <option value="-repository_created_at">by date</option>
                        </select>
                        <span class="select-arrow">
                        {{ svg('icons/far-angle-down') }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="wrap">
        <div>
            @foreach($repositories as $repository)
                <div class="cells" style="grid-template-columns: 3fr 3fr 1fr">
                    <div class="cell-l">
                        <div>
                            <a class="font-sans-bold link-underline link-blue" href="{{ $repository->url }}" target="_blank" rel="nofollow noreferrer noopener">
                                {{ $repository->name }}
                            </a>
                        </div>
                        <div class="text-xs mt-2 text-gray">
                            @if($repository->language)
                                <span class="font-bold">
                                    {{ $repository->language }}
                                    <span class="char-separator">•</span>
                                </span>
                            @endif
                            @if($repository->downloads)
                                <span>
                                    {{ number_format($repository->downloads, 0, '.', ' ') }}
                                    <span class="icon fill-current text-gray" style="transform: translateY(-1px)">{{ svg('icons/fal-arrow-to-bottom') }}</span>
                                    <span class="char-separator">•</span>
                                </span>
                            @endif
                            {{ number_format($repository->stars, 0, '.', ' ') }} <span class="icon fill-current text-gray" style="transform: translateY(-2px)">{{ svg('icons/fal-star') }}</span>
                            @if($repository->has_issues)
                                <a href="{{ $repository->issues_url }}" target="_blank" rel="nofollow noreferrer noopener"
                                    class="bg-green-lightest text-green-dark rounded-full px-2 ml-2">
                                    easy issues
                                </a>
                            @endif
                            @if($repository->is_new)
                                <span class="bg-gold-lightest text-gold-darkest rounded-full px-2 ml-2">
                                    new
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="cell">
                        {{ $repository->description }}
                        <div class="text-xs mt-2 text-gray">
                            @foreach($repository->topics as $topic)
                                <span>
                                    {{ $topic }}
                                    @unless($loop->last)
                                        <span class="char-separator">•</span>
                                    @endunless
                                </span>
                            @endforeach
                        </div>
                    </div>
                    <div class="cell-r mt-4 flex flex-col justify-center | md:mt-0 md:grid-text-right">
                        @if($repository->blogpost_url)
                            <a href="{{ $repository->blogpost_url }}" target="_blank" rel="nofollow noreferrer noopener"
                                class="link-underline link-gray text-xs">
                                Introduction
                            </a>
                        @endif
                        @if($repository->documentation_url)
                            <a href="{{ $repository->documentation_url }}" target="_blank" rel="nofollow noreferrer noopener"
                                class="link-underline link-gray text-xs">
                                Documentation
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        @unless(count($repositories))
            <p class="mt-12 text-lg text-gray">
                Apparently there's not a Spatie package for everything! <br>
                Maybe check back later.
            </p>
        @endunless
    </div>
</div>
