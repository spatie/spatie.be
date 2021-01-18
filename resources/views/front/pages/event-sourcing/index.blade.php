<x-page
    title="Event sourcing"
    background="/backgrounds/event-sourcing.jpg"
    description="Event sourcing"
>
    <section id="banner" class="banner" role="banner">
        <div class="wrap max-w-lg">
            <h1 class="banner-slogan">
                A new course <br>on event sourcing
            </h1>
            <p class="banner-intro">
                Coming summer 2021
            </p>
        </div>
    </section>

    <section class="pb-16">
        <div class="wrap max-w-lg markup links-underline links-blue">  

        @if(session()->has('subscribed'))

        <div class="card gradient gradient-green text-white">
            <div class="wrap-card grid md:grid-cols-2 md:items-center">
                <h2 class="title-xl">
                    Thank you!
                </h2>
                <p class="text-xl">
                    Thank you for subscribing. We'll keep you in the loop!
                    @if(auth()->user())
                        For the next 24 hours, you can buy any of <a href="{{ route('products.index') }}">our products</a> with an extra %10 discount.
                    @endif
                </p>
            </div>
        </div>

            @else
                <h2 class="title-sm">Keep me informed</h2>
                <form class="flex items-end" method="POST">
                    @csrf
                    <div class="flex-grow mr-px">
                        <input class="w-full form-input" placeholder="Email" type="email" name="email" id="email" value="{{ optional(auth()->user())->email }}">
                        @error('email')
                        <div class="text-pink-dark">{{ $message }}</div>
                        @enderror
                    </div>

                    <x-button type="submit">Submit</x-button>
                </form>
                <p class="mt-2 text-sm text-gray"> 
                    Expect maximum 3 mails about this course in the next few months.
                </p>

            @endif

            <p class="mt-12 text-lg">
                Event sourcing is an amazing set of techniques that allows you to model business processes in elegant way. Using event sourcing it's easy to make decisions based on what happened in the past.
            </p>

            <p class="text-lg">
                In this premium course, we'll walk you through all the basics. Though the knowledge presented is framework agnostic, the examples will embrace Laravel.
                <br>
                The course will include a cart package that will be event sourced and can be used in your e-commerce projects.
            </p>

            <p>
                Created by the team that brought you <a href="https://laravel-beyond-crud.com">Laravel Beyond CRUD</a>, <a href="https://front-line-php.com">Front Line PHP</a> and <a href="https://laravelpackage.training">Laravel Package Training</a>.
            
                Want to get started with event sourcing already? Check out our free, open source <a href="https://spatie.be/docs/laravel-event-sourcing">laravel-event-sourcing package</a>.
            </p>

            
        </div>
    </section>
</x-page>
