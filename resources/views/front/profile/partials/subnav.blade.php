<div class="w-full max-w-[1080px] mx-auto px-7 lg:px-0 mt-8 print:hidden">
    <nav class="flex items-center justify-between bg-oss-purple-extra-dark shadow-oss-card rounded-[20px] px-6 py-4 text-oss-gray">
        {{ Menu::profile()
            ->addClass('flex gap-4 sm:gap-6 text-sm sm:text-base')
            ->setActiveClass('text-white font-bold')
        }}

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="text-oss-gray-dark hover:text-white transition-colors cursor-pointer text-sm">
                Log out
            </button>
        </form>
    </nav>
</div>
