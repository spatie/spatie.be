<x-page
    title="Update password"
    body-class="bg-oss-black text-oss-gray font-medium font-pt antialiased mb-0"
    dark
>
    @include('layout.partials.gradient-background', [
        'color1' => '#197593',
        'color2' => '#50E69B',
        'color3' => '#2EC4B6',
        'rotationZ' => '120',
        'positionX' => '-0.5',
        'positionY' => '0.4',
        'uDensity' => '1.3',
        'uFrequency' => '5.0',
        'uStrength' => '3.0',
    ])

    @include('front.profile.partials.subnav')

    <div class="px-3 sm:px-16 md:px-10 lg:px-16 pb-20">
        <section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0 mt-8 sm:mt-16">
            <h1 class="font-druk uppercase text-[50px] sm:text-[72px] leading-[0.9] font-bold mb-10">Change password</h1>

            <div class="bg-oss-purple-extra-dark shadow-oss-card rounded-[20px] p-7 md:py-12 md:px-12 max-w-[640px]">
                <form class="space-y-6" action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password" class="block text-sm font-medium mb-1.5">Current password</label>
                        <input class="w-full px-4 py-3 bg-white/[0.07] border border-white/10 text-white rounded-lg placeholder-white/30 focus:border-oss-spatie-blue focus:outline-none" type="password" name="current_password" id="current_password">
                        @error('current_password')
                            <p class="text-oss-red text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="password" class="block text-sm font-medium mb-1.5">New password</label>
                            <input class="w-full px-4 py-3 bg-white/[0.07] border border-white/10 text-white rounded-lg placeholder-white/30 focus:border-oss-spatie-blue focus:outline-none" type="password" name="password" id="password">
                            @error('password')
                                <p class="text-oss-red text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium mb-1.5">Confirm new password</label>
                            <input class="w-full px-4 py-3 bg-white/[0.07] border border-white/10 text-white rounded-lg placeholder-white/30 focus:border-oss-spatie-blue focus:outline-none" type="password" name="password_confirmation" id="password_confirmation">
                            @error('password_confirmation')
                                <p class="text-oss-red text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <button class="w-full sm:w-auto flex items-center justify-center px-6 py-3.5 bg-oss-green-pale text-oss-royal-blue font-bold rounded-lg hover:opacity-90 transition-opacity cursor-pointer" type="submit">
                        Change password
                    </button>
                </form>
            </div>
        </section>
    </div>
</x-page>
