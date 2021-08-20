<div class="max-w-full text-sm" wire:poll.5s>
    @if ($activations->count())
        @foreach ($activations as $activation)
            <div class="flex justify-between items-center mb-2">
                <p class="w-1/2 truncate">{{ $activation->name }}</p>
                <p class="">{{ $activation->created_at->format('Y-m-d H:i') }}</p>
                <button wire:click="delete({{ $activation->id }})" class="link link-red">Delete</button>
            </div>
        @endforeach
    @else
        <p class="text-sm text-gray">No activations yet.</p>
    @endif
</div>
