<x-page
    title="Readable PHP - A premium course by Spatie"
    background="/backgrounds/event-sourcing.jpg"
    description="In this premium course you'll learn how to write readable PHP"
>
    <section id="banner" class="banner" role="banner">
        <div class="wrap max-w-lg">
            <h1 class="banner-slogan">
                Writing readable PHP
            </h1>
            <p class="banner-intro">
                A premium course coming early 2022
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
                    Expect maximum 3 emails about this course in the next few months.
                </p>
            @endif

            <p class="mt-12 text-lg">
                One of the things we often say at Spatie is that writing code that works is just the bare minimum. New, working code should be refactored so that it's optimized for readability. Code that is easy to understand, is in most cases also easier to change.
            </p>

            <p class="text-lg">
                In this course, you'll learn how to write <strong>readable and testable PHP code</strong> that will be joy to maintain for many years to come. We'll make use of the latest and greatest features of PHP. We'll not focus on theory, but you'll see many <strong>practical examples</strong>. You'll also gain access to a private forum where you can discuss all the lessons in our course.
            </p>

            <p class="text-lg">
                The knowledge shared in this course is the result of a world-class team, that has created and is maintaining many small and big Laravel projects and open source projects. We guarantee that after this course, you'll write better code. Your colleagues and future self will thank you!
            </p>

            <p class="mt-16 line-after">
                Created by the team that brought you:
            <p>
            <ul>
                <li><a href="https://laravel-beyond-crud.com">Laravel Beyond CRUD</a></li>
                <li><a href="https://testing-laravel.com">Testing Laravel</a></li>
                <li><a href="https://event-sourcing-laravel.com">Event Sourcing in Laravel</a></li>
                <li><a href="https://front-line-php.com">Front Line PHP</a></li>
                <li><a href="https://laravelpackage.training">Laravel Package Training</a></li>
            </ul>
        </div>
    </section>
</x-page>
