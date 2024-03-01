@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="opacity-50 relative inline-flex items-center px-4 py-2 text-sm bg-gray-lightest cursor-default rounded-sm">
                    <span class="icon mr-1 text-gray">{{ app_svg('icons/far-angle-left') }}</span> @lang('pagination.previous')
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="relative inline-flex items-center px-4 py-2 text-sm bg-gray-lightest cursor-pointer rounded-sm">
                    <span class="icon mr-1">{{ app_svg('icons/far-angle-left') }}</span> @lang('pagination.previous')
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="relative inline-flex items-center px-4 py-2 text-sm bg-gray-lightest cursor-pointer rounded-sm">
                    @lang('pagination.next') <span class="icon ml-1">{{ app_svg('icons/far-angle-right') }}</span>
                </a>
            @else
                <span class="opacity-50 relative inline-flex items-center px-4 py-2 text-sm bg-gray-lightest cursor-default rounded-sm">
                    @lang('pagination.next') <span
                            class="icon ml-1 text-gray">{{ app_svg('icons/far-angle-right') }}</span>
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-center">


            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-md">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="border border-transparent opacity-50 relative inline-flex items-center px-4 py-2 text-sm cursor-default rounded-sm"
                                  aria-hidden="true">
                                <span class="icon text-gray">{{ app_svg('icons/far-angle-left') }}</span>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                           class="border border-transparent hover:bg-gray-lightest relative inline-flex items-center px-4 py-2 text-sm cursor-pointer rounded-sm"
                           aria-label="{{ __('pagination.previous') }}">
                            <span class="icon">{{ app_svg('icons/far-angle-left') }}</span>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="border border-transparent relative inline-flex items-center px-4 py-2 text-sm cursor-default rounded-sm">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="border border-transparent relative inline-flex items-center px-4 py-2 bg-gray-lightest text-sm font-bold cursor-default rounded-sm">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                       class="border border-transparent hover:bg-gray-lightest relative inline-flex items-center px-4 py-2 text-sm cursor-pointer rounded-sm"
                                       aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                           class="border border-transparent hover:bg-gray-lightest relative inline-flex items-center px-4 py-2 text-sm cursor-pointer rounded-sm"
                           aria-label="{{ __('pagination.next') }}">
                            <span class="icon">{{ app_svg('icons/far-angle-right') }}</span>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="border border-transparent opacity-50 relative inline-flex items-center px-4 py-2 text-sm cursor-default rounded-sm"
                                  aria-hidden="true">
                                <span class="icon text-gray">{{ app_svg('icons/far-angle-right') }}</span>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
