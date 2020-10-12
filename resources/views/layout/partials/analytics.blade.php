@if(app()->environment('production'))
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-131225353-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-131225353-2', {
            'linker': {
                'accept_incoming': true
            }
        });

        @if(session()->has('sold_purchasable'))
            @php
                /** @var \App\Models\Purchasable $purchasable */
                $purchasable = session()->get('sold_purchasable')
            @endphp

            gtag('event', 'purchase', {
                "transaction_id": "{{session()->getId()}}_{{$purchasable->id}}",
                "affiliation": "Spatie.be",
                "value": {{ $purchasable->getAverageEarnings() }},
                "currency": "EUR",
                "tax": 0.0,
                "shipping": 0.0,
                "items": [
                    {
                        "id": "{{ $purchasable->id }}",
                        "name": "{{ $purchasable->title }}",
                        "quantity": 1,
                        "price": {{ $purchasable->getAverageEarnings() }}
                    }
                ]
            });
        @endif
    </script>
@endif
