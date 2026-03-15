<aside class="w-full md:w-[220px] flex-shrink-0 print:hidden">
    <nav class="bg-oss-purple-extra-dark shadow-oss-card rounded-[20px] p-4">
        <ul class="space-y-1">
            <li>
                <a href="{{ route('purchases') }}" class="block px-4 py-2.5 rounded-lg transition-colors text-sm {{ request()->routeIs('purchases') ? 'bg-white/10 text-white font-bold' : 'text-oss-gray hover:bg-white/[0.05] hover:text-white' }}">
                    Purchases
                </a>
            </li>
            <li>
                <a href="{{ route('invoices') }}" class="block px-4 py-2.5 rounded-lg transition-colors text-sm {{ request()->routeIs('invoices') ? 'bg-white/10 text-white font-bold' : 'text-oss-gray hover:bg-white/[0.05] hover:text-white' }}">
                    Invoices
                </a>
            </li>
            <li>
                <a href="{{ route('profile') }}" class="block px-4 py-2.5 rounded-lg transition-colors text-sm {{ request()->routeIs('profile') && !request()->routeIs('profile.password') ? 'bg-white/10 text-white font-bold' : 'text-oss-gray hover:bg-white/[0.05] hover:text-white' }}">
                    Profile
                </a>
            </li>
            <li>
                <a href="{{ route('profile.password') }}" class="block px-4 py-2.5 rounded-lg transition-colors text-sm {{ request()->routeIs('profile.password') ? 'bg-white/10 text-white font-bold' : 'text-oss-gray hover:bg-white/[0.05] hover:text-white' }}">
                    Password
                </a>
            </li>
        </ul>
    </nav>
</aside>
