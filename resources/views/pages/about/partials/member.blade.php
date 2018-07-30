<div id="{{ $member->slug }}" class="wrap-6 items-start section">
    <div class="sm:spanx-2">
        <h3 class="title-sm">
            {{ $member->first_name }} {{ $member->last_name }}
            <div class="title-subtext text-grey-light">{{ $member->role }}</div>
        </h3>
        <div class="avatar mt-4">
            {{ gravatar_img($member->email) }}
        </div>
    </div>
    <div class="line-l markup links-underline links-blue | sm:spanx-4 text-sm">
        <p>{{ $member->description }}</p>
        <ul class="text-xs">
            @if($member->public_email)
                <li><a href="mailto:{{ $member->email }}">{{ $member->email }}</a></li>
            @endif
            @if($member->twitter)
                <li><a href="https://twitter.com/{{ $member->twitter }}">{{ '@'.$member->twitter }}</a></li>
            @endif
            @if($member->website)
                <li><a href="{{ $member->website }}">{{ $member->website_domain }}</a></li>
            @endif
        </ul>
    </div>
</div>
