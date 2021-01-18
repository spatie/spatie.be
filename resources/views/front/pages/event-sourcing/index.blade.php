<x-page
    title="Event sourcing"
    background="/backgrounds/product.jpg"
    description="Event sourcing"
>
    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Welcome in <br>our store
            </h1>
            <p class="banner-intro">
                By artisans for artisans
            </p>
        </div>
    </section>

    <section id="cta" class="pb-16">
        Event sourcing is an amazing set of techniques that allows you to model business processes in elegant way. Using event sourcing it's easy to make decisions based on what happened in the past.

        In this premium course, we'll walk you through all the basics. Though the knowledge presented is framework agnostic, the examples will be Laravel specific

        @if(session()->has('subscribed'))
            Thank you for subscribing!

            @if(auth()->user())
                For the next 24 hours, you can buy any of our products with an extra %10 discount.
            @endif
        @else
            <form class="space-y-6" method="POST">
                @csrf

                <x-field>
                    <x-label for="email">Your email</x-label>
                    <input class="form-input" type="email" name="email" id="email" value="{{ optional(auth()->user())->email }}">
                    @error('email')
                    <div class="text-pink-dark">{{ $message }}</div>
                    @enderror
                </x-field>

                <x-button type="submit">Submit</x-button>

                We will use your mail to keep you up to date about the event sourcing course. This will only be 2 or 3 mails in the next few months.
            </form>
        @endif
    </section>
</x-page>
