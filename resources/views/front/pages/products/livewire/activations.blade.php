<div class="markup-tables" wire:poll.5s>
    @if(count($activations))
        <table class="my-4 text-xs">
            <thead>
                <tr>
                    <th>Name</th>
                    <th colspan="2">Activated at</th>
                    <th></th>
                </tr>
            </thead>
            @foreach($activations as $activation)
                <tr wire:key="{{ $activation->id }}">
                    <td>{{ $activation->name }}</td>
                    <td>{{ $activation->created_at->format('Y-m-d') }}</td>
                    <td>{{ $activation->created_at->format('H:i:s') }}</td>
                    <td>
                        <button wire:click="delete({{ $activation->id }})"class="link link-red">Delete</button>
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        <p class="text-xs text-gray">Product has not been activated.</p>
    @endif
</div>
