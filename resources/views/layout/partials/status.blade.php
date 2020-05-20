@auth
    <div class="py-2 px-8 md:px-16 flex items-center justify-end bg-blue-darker links-white links-underline text-white text-xs">
        <span class="mx-2 inline-block align-center w-4 fill-pink">
            {{ svg('icons/fas-heart') }}
        </span>
        <span class="opacity-75">
        Thanks for being our sponsor, {{ auth()->user()->github_username }}!
        </span>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="ml-1 px-2 py-1 rounded-full inline-block bg-blue-darkest">Log out</button>
        </form>
    </span>
    </div>
@endauth