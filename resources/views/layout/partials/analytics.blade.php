@if (app()->environment('production'))
    @if(request()->segment(1) !== 'docs')
        <script src="https://cdn.usefathom.com/script.js" data-site="OMNDKUTR" defer></script>
    @endif
@endif

@php
    $gtmId = app()->environment('production') ? 'GTM-WGCBMG' : 'GTM-TEST';
    $hasPurchaseEvent = ($usesSession ?? true) && session()->has('sold_purchasable');
    $gtmStrategy = $hasPurchaseEvent ? 'eager' : ($gtmStrategy ?? 'delayed');
@endphp

@if($hasPurchaseEvent)
    <script>
        @php
            /** @var \App\Domain\Shop\Models\Purchasable|\App\Domain\Shop\Models\Bundle $purchasable */
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
                            "name": "{{ $purchasable->getFullTitle() }}",
                            "quantity": 1,
                            "price": {{ $purchasable->getAverageEarnings() }}
                        }
                    ]
                }
            }
        });
    </script>
@endif

@unless($gtmStrategy === 'disabled')
    <script>
        (function(window, document, scriptTag, layerName, id, strategy) {
            window[layerName] = window[layerName] || [];

            function loadGtm() {
                if (window.spatieGtmLoaded) return;

                window.spatieGtmLoaded = true;
                window[layerName].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js',
                });

                var firstScript = document.getElementsByTagName(scriptTag)[0];
                var script = document.createElement(scriptTag);
                var dataLayer = layerName !== 'dataLayer' ? '&l=' + layerName : '';

                script.async = true;
                script.src = 'https://www.googletagmanager.com/gtm.js?id=' + id + dataLayer;
                firstScript.parentNode.insertBefore(script, firstScript);
            }

            if (strategy === 'eager') {
                loadGtm();

                return;
            }

            ['pointerdown', 'keydown', 'touchstart', 'scroll'].forEach(function(eventName) {
                window.addEventListener(eventName, loadGtm, { once: true, passive: true });
            });

            if ('requestIdleCallback' in window) {
                window.requestIdleCallback(loadGtm, { timeout: 3500 });

                return;
            }

            window.setTimeout(loadGtm, 3500);
        })(window, document, 'script', 'dataLayer', '{{ $gtmId }}', '{{ $gtmStrategy }}');
    </script>
@endunless
