<x-page title="{{ $post->title }}" background="/backgrounds/blogs.jpg">
    {{ $post->date?->format('d F Y') ?? 'Preview' }}

    <h1>{{ $post->title }}</h1>

    @if($post->header_image)
        <img class="w-full rounded-md my-4" alt="" src="{{ $post->header_image }}"/>
    @endif

    <div>
        @foreach ($post->authors as $author)
            <div class="flex items-center gap-x-2">
                <img src="{{ $author->gravatar_url }}" alt="" class="h-6 w-6 rounded-full bg-indigo-50">
                <div class="text-[0.6rem] leading-6">
                    <p class="font-semibold text-indigo-900">
                                <span>
                                    <span class="absolute inset-0"></span>
                                    {{ $author->name }}
                                </span>
                    </p>
                </div>
            </div>
        @endforeach
    </div>
    <div>
        {!! $post->content !!}
    </div>

    <a href="{{ route('insights') }}">Back to insights</a>

    @if(count($otherPosts))
        <h2>Continue reading</h2>
        @foreach($otherPosts as $otherPost)
            <a href="{{ route('insights.show', $otherPost->slug) }}">
                {{ $otherPost->title }}
                {{ htmlspecialchars_decode(strip_tags($post->summary)) }}
            </a>
        @endforeach
    @endif

    <livewire:newsletter />
</x-page>
