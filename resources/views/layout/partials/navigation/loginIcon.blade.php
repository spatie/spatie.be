<a href="{{ route('login') }}">
    <span class="icon fill-current text-oss-royal-blue" title="Log in">
        <span class="mr-2 md:hidden">Log in</span>
        {{ $active ? app_svg('icons/fas-user') : app_svg('icons/far-user') }}
    </span>
</a>
