{{ Menu::service()
    ->setActiveClass('font-sans-bold')
}}

@auth
    <div class="py-2 px-8 md:px-16 flex items-center justify-end bg-blue-darker links-white links-underline text-white text-xs">
        @if (auth()->user()->isSponsoring())
            <span class="mx-2 inline-block align-center w-4 fill-current text-pink">
                {{ svg('icons/fas-heart') }}
            </span>
            <span class="opacity-75">
            Thanks for being our sponsor, {{ auth()->user()->name ?? auth()->user()->github_username }}!
            </span>
        @endif
        <a href="{{ route('profile') }}">Profile</a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="ml-1 px-2 py-1 rounded-full inline-block bg-blue-darkest">Log out</button>
        </form>
    </div>
@else
    <div class="py-2 px-8 md:px-16 flex items-center justify-end bg-blue-darker links-white links-underline text-white text-xs">
        <a href="{{ route('login') }}" class="ml-1 px-2 py-1 rounded-full inline-block bg-blue-darkest">Login</a>
    </div>
@endauth

@if(session()->has('not-a-sponsor'))
    <div class="py-2 px-8 md:px-16 flex items-center justify-end bg-red links-white links-underline text-white text-xs">
        <span class="mx-2 inline-block align-center w-4 fill-current text-white">
            {{ svg('github') }}
        </span>
        <span class="opacity-75">
            Aaaaw… you're not a sponsor yet!
        </span>
        <a class="ml-2 link-white link-underline" href="https://github.com/sponsors/spatie" target="_blank">                                             
            Become a GitHub Sponsor
        </a>
    </div>
@endif
