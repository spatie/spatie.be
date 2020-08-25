<a href="{{ route('login') }}">
    <span class="icon fill-current" title="Log in">
        <span class="mr-2 md:hidden">Log in</span>
        {{ $active ? svg('icons/fas-user') : svg('icons/far-user') }}
    </span>
</a>
