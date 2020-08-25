<div>
    @if (! $video->hasBeenCompletedByCurrentUser())
        <span wire:click="toggleCompleted" class="complete">
            <x-button class="button">
                Mark as completed
            </x-button>
        </span>
    @else
        <span wire:click="toggleCompleted">
            <x-button class="button bg-green-500 hover:bg-green-600">
                <span class="text-white mr-2">
                    ✓
                </span> Completed
            </x-button>
        </span>
    @endif
</div>
