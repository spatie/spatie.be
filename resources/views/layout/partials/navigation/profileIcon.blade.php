<div x-data="{ open: false }" x-on:click.outside="open = false" class="relative">
    <button x-on:click="open = !open" class="cursor-pointer focus:outline-none flex items-center -my-1" x-ref="avatarBtn">
        <img
            src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim(auth()->user()->email))) }}?s=64&d=https%3A%2F%2Fui-avatars.com%2Fapi%2F/{{ urlencode(auth()->user()->name ?? 'U') }}/64/197593/ffffff/2/0.5/false/bold/true"
            alt="{{ auth()->user()->name }}"
            class="w-7 h-7 rounded-full object-cover"
        >
    </button>

    <template x-teleport="body">
        <div
            x-show="open"
            x-on:click.outside="open = false"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            x-cloak
            x-init="$watch('open', (val) => {
                if (val) {
                    const rect = $refs.avatarBtn.getBoundingClientRect();
                    $el.style.top = (rect.bottom + window.scrollY + 12) + 'px';
                    $el.style.left = (rect.right - 192) + 'px';
                }
            })"
            class="fixed w-48 rounded-[12px] py-2 text-sm"
            style="z-index: 9999; background-color: #1a1a2e; box-shadow: 0 8px 30px rgba(0,0,0,0.5); color: #A5A4A3;"
        >
            <div class="px-4 py-2 mb-1" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                <p class="font-bold truncate" style="color: #fff;">{{ auth()->user()->name }}</p>
                <p class="text-xs truncate" style="color: #A5A4A3;">{{ auth()->user()->email }}</p>
            </div>

            <a href="{{ route('purchases') }}" class="block px-4 py-2" style="color: #EAE8E5;" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.07)';this.style.color='#fff'" onmouseout="this.style.backgroundColor='transparent';this.style.color='#EAE8E5'">
                Purchases
            </a>
            <a href="{{ route('invoices') }}" class="block px-4 py-2" style="color: #EAE8E5;" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.07)';this.style.color='#fff'" onmouseout="this.style.backgroundColor='transparent';this.style.color='#EAE8E5'">
                Invoices
            </a>
            <a href="{{ route('profile') }}" class="block px-4 py-2" style="color: #EAE8E5;" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.07)';this.style.color='#fff'" onmouseout="this.style.backgroundColor='transparent';this.style.color='#EAE8E5'">
                Profile
            </a>
            <a href="{{ route('profile.password') }}" class="block px-4 py-2" style="color: #EAE8E5;" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.07)';this.style.color='#fff'" onmouseout="this.style.backgroundColor='transparent';this.style.color='#EAE8E5'">
                Change password
            </a>

            <div class="mt-1 pt-1" style="border-top: 1px solid rgba(255,255,255,0.1);">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 cursor-pointer" style="color: #A5A4A3;" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.07)';this.style.color='#fff'" onmouseout="this.style.backgroundColor='transparent';this.style.color='#A5A4A3'">
                        Log out
                    </button>
                </form>
            </div>
        </div>
    </template>
</div>
