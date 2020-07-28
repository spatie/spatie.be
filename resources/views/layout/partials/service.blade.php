    {{ Menu::service()
        ->addClass('grid md:grid-flow-col md:gap-6')
        ->setActiveClass('font-sans-bold')
    }}
    @auth
        <a href="{{ route('profile') }}">Profile</a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="ml-1 px-2 py-1 rounded-full inline-block bg-blue-darkest">Log out</button>
        </form>
    @else
        <a href="{{ route('login') }}">
            <span class="icon fill-current">
                <span class="mr-2 md:hidden">Log in</span> {{ svg('icons/fas-user') }}
            </span>
        </a>
    @endauth
