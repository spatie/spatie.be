@if(app()->environment('production'))
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-WGCBMG');</script>

        @if(session()->has('sold_purchasable'))
            <script>
                @php
                    /** @var \App\Domain\Shop\Models\Purchasable $purchasable */
                    $purchasable = session()->get('sold_purchasable')
                @endphp

                window.dataLayer = window.dataLayer || [];
                dataLayer.push({
                    'event': 'purchase',
                    'ecommerce': {
                        'purchase': {
                            'actionField': {
                                'id': "{{session()->getId()}}_{{$purchasable->id}}",
                                'affiliation': 'Spatie.be',
                                'revenue': {{ $purchasable->getAverageEarnings() }},
                            },
                            'products': [
                                {
                                    "id": "{{ $purchasable->id }}",
                                    "sku": "{{ $purchasable->id }}",
                                    "name": "{{ $purchasable->product->title }} | {{ $purchasable->title }}",
                                    "quantity": 1,
                                    "price": {{ $purchasable->getAverageEarnings() }}
                                }
                            ]
                        }
                    }
                });
            </script>
        @endif
@endif
