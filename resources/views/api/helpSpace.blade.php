<div class="mt-4">
    <h2 class="flex-grow spm-ticket-sidebar-head mb-px">Spatie</h2>
    <div class="relative flex-wrap w-full mt-2 bg-gray-200 rounded-lg px-4 py-4 3xl:mr-2">
        <h3 class="flex-grow spm-ticket-sidebar-head mb-px">Purchases</h3>
        <div class="text-sm mb-4">
            <ul>
                @foreach($purchases as $purchase)
                    <li>
                        {{ $purchase->id }}
                        {{ $purchase->purchasable?->getFullTitle() }}
                    </li>
                @endforeach
            </ul>

        </div>
        <a class="text-sm" href="https://spatie.be/nova/resources/users/{{ $user->id }}">View in Nova</a>
    </div>
</div>
