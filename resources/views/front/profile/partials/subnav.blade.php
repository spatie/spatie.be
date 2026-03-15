<nav class="w-full md:w-[220px] flex-shrink-0 print:hidden">
    <ul class="space-y-1">
        <li>
            <a href="{{ route('purchases') }}" class="block px-4 py-2.5 rounded-lg transition-colors {{ request()->routeIs('purchases') ? 'text-white font-bold' : 'text-oss-gray-dark hover:text-white' }}">
                Purchases
            </a>
        </li>
        <li>
            <a href="{{ route('invoices') }}" class="block px-4 py-2.5 rounded-lg transition-colors {{ request()->routeIs('invoices') ? 'text-white font-bold' : 'text-oss-gray-dark hover:text-white' }}">
                Invoices
            </a>
        </li>
        <li>
            <a href="{{ route('profile') }}" class="block px-4 py-2.5 rounded-lg transition-colors {{ request()->routeIs('profile') && !request()->routeIs('profile.password') ? 'text-white font-bold' : 'text-oss-gray-dark hover:text-white' }}">
                Profile
            </a>
        </li>
        <li>
            <a href="{{ route('profile.password') }}" class="block px-4 py-2.5 rounded-lg transition-colors {{ request()->routeIs('profile.password') ? 'text-white font-bold' : 'text-oss-gray-dark hover:text-white' }}">
                Password
            </a>
        </li>
    </ul>
</nav>
