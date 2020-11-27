@component('mail::message')
# Get {{ $user->nextPurchaseDiscountPercentage() }}% discount on your next purchase

Thank you so much for purchasing one of our products. It really means a lot to us.

For the next 24 hours you can grab any other product of ours at an extra {{ $user->nextPurchaseDiscountPercentage() }}% discount.

Just use the same account as your previous purchase to take advantage of this offer.

@component('mail::button', ['url' => route('products.index')])
    View products
@endcomponent

Take care,<br>
All of us at Spatie
@endcomponent
