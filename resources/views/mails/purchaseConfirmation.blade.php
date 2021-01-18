@component('mail::message')
# "Getting started with {{ $purchase->purchasable->product->title }}!"

Thank you so much for your purchase. This means a lot to us!

You can manage your purchase [on our website]({{ route('products.show', $purchase->purchasable->product) }})

@if($purchase->unlocksRayLicense())
    Your purchase also includes one license for Ray, which you can manage [here](https://spatie.be/products/ray).
@endif

As an extra bonus, you can grab any other product of ours at an extra {{ $purchase->user->nextPurchaseDiscountPercentage() }}% discount for the next 24 hours.

Just use the same account as your previous purchase to take advantage of this offer.

@component('mail::button', ['url' => route('products.index') . '?utm_source=promo&utm_medium=email&utm_campaign=discount-period'])
    View products
@endcomponent

Take care,<br>
All of us at Spatie
@endcomponent
