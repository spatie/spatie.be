<div id="{{ $member->slug }}" class="pb-4">
    <div class="flex items-center mb-4">
        <div class="flex-none mr-4">
            <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($member->email))) }}?s=96&d=mp" alt="{{ $member->first_name }}" width="48" height="48" class="w-12 h-12 rounded-full object-cover">
        </div>
        <div>
            <h3 class="font-bold text-lg/tight">{{ $member->first_name }} {{ $member->last_name }}</h3>
            <p class="text-base text-oss-royal-blue-light">{{ $member->role }}</p>
        </div>
    </div>
    <div>
        <p>{{ $member->description }}</p>
        <ul class="mt-2 gap-3 text-sm flex items-center flex-wrap">
            @if($member->public_email)
                <li><a class="underline text-oss-spatie-blue transition-colors hover:text-oss-royal-blue" href="mailto:{{ $member->email }}">{{ $member->email }}</a></li>
            @endif
            @if($member->twitter)
                <li><a class="underline text-oss-spatie-blue transition-colors hover:text-oss-royal-blue" href="https://x.com/{{ $member->twitter }}">{{ '@'.$member->twitter }}</a></li>
            @endif
            @if($member->website)
                <li><a class="underline text-oss-spatie-blue transition-colors hover:text-oss-royal-blue" href="{{ $member->website }}">{{ $member->website_domain }}</a></li>
            @endif
        </ul>
    </div>
</div>
