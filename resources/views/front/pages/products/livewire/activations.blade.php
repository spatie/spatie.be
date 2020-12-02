<div wire:poll.5s>
    @if(count($activations))
        <table>
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Activated at</td>
                    <td></td>
                </tr>
            </thead>
            @foreach($activations as $activation)
                <tr wire:key="{{ $activation->id }}">
                    <td>{{ $activation->name }}</td>
                    <td>{{ $activation->created_at->format('Y-m-d H:i:s') }}</td>
                    <td wire:click="delete({{ $activation->id }})">Delete</td>
                </tr>
            @endforeach
        </table>
    @else
        Product has not been activated.
    @endif
</div>
