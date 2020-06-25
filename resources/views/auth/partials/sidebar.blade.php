<div class="bg-blue text-white flex flex-col p-6 w-1/3">
    <a href="{{ route('profile') }}">My profile</a>
    <a href="{{ route('profile.password') }}">Password</a>

    <form class="mt-12" action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="">Log out</button>
    </form>
</div>
