<div x-data="{ open: false }" x-on:click.outside="open = false" class="relative">
    <button x-on:click="open = !open" class="cursor-pointer focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-oss-spatie-blue flex items-center gap-1.5 -my-1 max-sm:hidden">
        <img
            src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim(auth()->user()->email))) }}?s=64&d=https%3A%2F%2Fui-avatars.com%2Fapi%2F/{{ urlencode(auth()->user()->name ?? 'U') }}/64/197593/ffffff/2/0.5/false/bold/true"
            alt="{{ auth()->user()->name }}"
            class="size-6 rounded-full object-cover"
        >
        <span class="text-sm text-oss-royal-blue">Account</span>
    </button>

    {{-- Invisible bridge to cover gap between trigger and dropdown --}}
    <div class="hidden sm:block absolute left-0 right-0 h-3"></div>

    {{-- Desktop: dropdown --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        x-cloak
        class="max-sm:hidden absolute right-0 mt-3 w-52 rounded-xl bg-white text-oss-royal-blue shadow-lg ring-1 ring-black/5 py-1"
    >
        <div class="px-5 py-2 mb-0.5 border-b border-black/5">
            <p class="font-bold truncate text-oss-royal-blue">{{ auth()->user()->name }}</p>
            <p class="text-xs truncate text-gray">{{ auth()->user()->email }}</p>
        </div>

        <div class="grid px-1 gap-0.5">
            <a href="{{ route('purchases') }}" class="px-4 py-2 hover:bg-blue-lightest transition-colors rounded-lg">
                Purchases
            </a>
            <a href="{{ route('invoices') }}" class="px-4 py-2 hover:bg-blue-lightest transition-colors rounded-lg">
                Invoices
            </a>
            <a href="{{ route('profile') }}" class="px-4 py-2 hover:bg-blue-lightest transition-colors rounded-lg">
                Profile
            </a>
            <a href="{{ route('profile.password') }}" class="px-4 py-2 hover:bg-blue-lightest transition-colors rounded-lg">
                Change password
            </a>
        </div>

        <div class="mt-0.5 pt-0.5 border-t border-black/5">
            <div class="grid px-1">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 cursor-pointer text-gray hover:bg-blue-lightest transition-colors rounded-lg">
                        Log out
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Mobile: inline list --}}
    <div class="sm:hidden border-t border-black/5 pt-3 mt-3">
        <span class="font-bold text-sm text-oss-royal-blue truncate">{{ auth()->user()->name }}</span>

        <nav class="flex flex-col gap-1 text-oss-royal-blue mt-2">
            <a href="{{ route('purchases') }}" class="py-1 hover:text-oss-spatie-blue transition-colors">Purchases</a>
            <a href="{{ route('invoices') }}" class="py-1 hover:text-oss-spatie-blue transition-colors">Invoices</a>
            <a href="{{ route('profile') }}" class="py-1 hover:text-oss-spatie-blue transition-colors">Profile</a>
            <a href="{{ route('profile.password') }}" class="py-1 hover:text-oss-spatie-blue transition-colors">Change password</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="py-1 cursor-pointer text-gray hover:text-oss-spatie-blue transition-colors">
                    Log out
                </button>
            </form>
        </nav>
    </div>
</div>
