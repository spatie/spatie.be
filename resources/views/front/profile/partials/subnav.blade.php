<div class="submenu-wrap">
    <nav class="submenu gradient gradient-pink text-white | print:hidden">

        {{ Menu::profile() }}

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">
                <span class="icon fill-current hover:text-pink-dark" title="Log out">
                    {{ app_svg('icons/fas-power-off') }}
                </span>
            </button>
        </form>
    </nav>
</div>
