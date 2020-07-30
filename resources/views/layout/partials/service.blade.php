   
    <a href="{{ route('about') }}">About us</a>
    
    <a href="{{ route('docs') }}">Docs</a>

    @auth
        <a href="{{ route('profile') }}">
            <span class="icon fill-current" title="Profile">
                <span class="mr-2 md:hidden">Profile</span> 
                @if (auth()->user()->isSponsoring())
                    <span style="font-size: .6rem" class="absolute z-10 top-0 right-0 -mr-2 -mt-1 icon text-pink">
                        {{ svg('icons/fas-heart') }}
                    </span>
                @endif
                {{ svg('icons/fas-user') }}
            </span>
        </a>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">
                <span class="icon fill-current hover:text-pink-dark" title="Log out">
                    <span class="mr-2 md:hidden">Log out</span> 
                    {{ svg('icons/fas-power-off') }}
                </span>
            </button>
        </form>
    @else
        <a href="{{ route('login') }}">
            <span class="icon fill-current" title="Log in">
                <span class="mr-2 md:hidden">Log in</span> 
                {{ svg('icons/fas-user') }}
            </span>
        </a>
    @endauth
