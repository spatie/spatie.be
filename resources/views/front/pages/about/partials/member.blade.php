<div id="{{ $member->slug }}" class="pb-4">
    <div class="flex items-center mb-4">
        <div class="flex-none mr-4">
            <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($member->email))) }}?s=96&d=mp" alt="{{ $member->first_name }}" width="48" height="48" class="w-12 h-12 rounded-full object-cover">
        </div>
        <div>
            <h3 class="font-bold text-lg text-white">{{ $member->first_name }} {{ $member->last_name }}</h3>
            <p class="text-oss-gray-dark">{{ $member->role }}</p>
        </div>
    </div>
    <div>
        <p>{{ $member->description }}</p>
        <ul class="mt-2 space-y-1 text-sm">
            @if($member->public_email)
                <li><a class="underline hover:text-white" href="mailto:{{ $member->email }}">{{ $member->email }}</a></li>
            @endif
            @if($member->twitter)
                <li><a class="underline hover:text-white" href="https://x.com/{{ $member->twitter }}">{{ '@'.$member->twitter }}</a></li>
            @endif
            @if($member->website)
                <li><a class="underline hover:text-white" href="{{ $member->website }}">{{ $member->website_domain }}</a></li>
            @endif
        </ul>
    </div>
</div>
