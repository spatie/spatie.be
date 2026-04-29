<nav class="w-full md:w-[220px] flex-shrink-0 bg-oss-purple-extra-dark shadow-oss-card rounded-[20px] p-4 text-sm print:hidden">
    <ul class="space-y-0.5" role="list">
        <li>
            <a href="{{ route('purchases') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('purchases') ? 'bg-white/10 text-white font-bold' : 'text-oss-gray hover:bg-white/[0.05] hover:text-white' }}">
                Purchases
            </a>
        </li>
        <li>
            <a href="{{ route('invoices') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('invoices') ? 'bg-white/10 text-white font-bold' : 'text-oss-gray hover:bg-white/[0.05] hover:text-white' }}">
                Invoices
            </a>
        </li>
        <li>
            <a href="{{ route('profile') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('profile') && !request()->routeIs('profile.password') ? 'bg-white/10 text-white font-bold' : 'text-oss-gray hover:bg-white/[0.05] hover:text-white' }}">
                Profile
            </a>
        </li>
        <li>
            <a href="{{ route('profile.password') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('profile.password') ? 'bg-white/10 text-white font-bold' : 'text-oss-gray hover:bg-white/[0.05] hover:text-white' }}">
                Password
            </a>
        </li>
    </ul>
</nav>
