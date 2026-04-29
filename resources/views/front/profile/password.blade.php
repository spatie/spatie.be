<x-page
    title="Update password"
    body-class="bg-oss-black text-oss-gray font-medium font-pt antialiased mb-0"
    dark
>

    @include('layout.partials.bg-color')

    <x-profile-layout title="Change password">
        <div class="bg-oss-purple-extra-dark shadow-oss-card rounded-[20px] p-7 md:py-12 md:px-12">
            <form class="space-y-6" action="{{ route('profile.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="block text-sm font-medium mb-1.5">Current password</label>
                    <input class="w-full px-4 py-3 bg-white/[0.07] border border-white/10 text-white rounded-lg placeholder-white/30 focus:border-oss-spatie-blue focus:outline-none" type="password" name="current_password" id="current_password" autocomplete="current-password">
                    @error('current_password')
                        <p class="text-oss-red text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label for="password" class="block text-sm font-medium mb-1.5">New password</label>
                        <input class="w-full px-4 py-3 bg-white/[0.07] border border-white/10 text-white rounded-lg placeholder-white/30 focus:border-oss-spatie-blue focus:outline-none" type="password" name="password" id="password" autocomplete="new-password">
                        @error('password')
                            <p class="text-oss-red text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium mb-1.5">Confirm new password</label>
                        <input class="w-full px-4 py-3 bg-white/[0.07] border border-white/10 text-white rounded-lg placeholder-white/30 focus:border-oss-spatie-blue focus:outline-none" type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password">
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
    </x-profile-layout>
</x-page>
