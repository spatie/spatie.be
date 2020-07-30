<x-page
        title="Update password"
        background="/backgrounds/auth.jpg"
>
    @include('front.profile.partials.subnav')

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Change password
            </h1>
        </div>
    </section>

    <section class="section section-group pt-0">
        <div class="wrap">
            <form class="space-y-6" action="{{ route('profile.password') }}" method="POST">
                @csrf
                @method('PUT')

                <x-field>
                    <x-label for="current_password">Current password</x-label>
                    <input class="form-input" type="password" name="current_password" id="current_password">
                    @error('current_password')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </x-field>

                <div class="grid gap-6 | md:grid-cols-2">
                    <x-field>
                        <x-label for="password">New password</x-label>
                        <input class="form-input" type="password" name="password" id="password">
                        @error('password')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </x-field>

                    <x-field>
                        <x-label for="password_confirmation">Confirm new password</x-label>
                        <input class="form-input" type="password" name="password_confirmation" id="password_confirmation">
                        @error('password_confirmation')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </x-field>
                </div>

                <x-button type="submit">Change password</x-button>
            </form>
        </div>
    </section>
</x-page>
