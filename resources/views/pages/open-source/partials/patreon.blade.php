<div class="flex items-center mt-8 my-6">
    <div class="avatar">
        <img src="{{ $patreonPledger->avatarUrl }}">
    </div>
    <div class="ml-4">
        <h3 class="title-sm">
            {{ $patreonPledger->name }}
        </h3>
        <p class="text-xs text-grey mt-2 links-underline links-grey">
            {{ $patreonPledger->respectPhrase }}
        </p>
    </div>
</div>
