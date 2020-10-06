@if(app()->environment('production'))
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-131225353-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-131225353-2');

        @if(session()->has('sold_purchasable'))
            @php
                /** @var \App\Models\Purchasable $purchasable */
                $purchasable = session()->get('sold_purchasable')
            @endphp

        gtag('event', 'purchase', {
            "transaction_id": "24.031608523954162",
            "affiliation": "Google online store",
            "value": 23.07,
            "currency": "USD",
            "tax": 1.24,
            "shipping": 0,
            "items": [
                {
                    "id": "P12345",
                    "name": "Android Warhol T-Shirt",
                    "list_name": "Search Results",
                    "brand": "Google",
                    "category": "Apparel/T-Shirts",
                    "variant": "Black",
                    "list_position": 1,
                    "quantity": 2,
                    "price": '2.0'
                },
                {
                    "id": "P67890",
                    "name": "Flame challenge TShirt",
                    "list_name": "Search Results",
                    "brand": "MyBrand",
                    "category": "Apparel/T-Shirts",
                    "variant": "Red",
                    "list_position": 2,
                    "quantity": 1,
                    "price": '3.0'
                }
            ]
        });

            {{--gtag('event', 'purchase', {--}}
            {{--    "transaction_id": "{{session()->getId()}}_{{$purchasable->id}}",--}}
            {{--    "affiliation": "Spatie.be",--}}
            {{--    "value": {{ $purchasable->getAverageEarnings() }},--}}
            {{--    "currency": "EUR",--}}
            {{--    "tax": 0.0,--}}
            {{--    "shipping": 0.0,--}}
            {{--    "items": [--}}
            {{--        {--}}
            {{--            "id": "{{ $purchasable->id }}",--}}
            {{--            "name": "{{ $purchasable->title }}",--}}
            {{--            "quantity": 1,--}}
            {{--            "price": {{ $purchasable->getAverageEarnings() }}--}}
            {{--        }--}}
            {{--    ]--}}
            {{--});--}}
        @endif
    </script>
@endif
