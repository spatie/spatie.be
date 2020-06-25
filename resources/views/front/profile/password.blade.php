<x-page
        title="Update password"
        background="/backgrounds/home.jpg"
>

    <div class="wrap flex">
        @include('front.profile.partials.sidebar')

        <div class="my-6 ml-4">
            <h1 class="text-xl mb-6">Update password</h1>

            <form class="space-y-6" action="{{ route('profile.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid">
                    <label for="current_password">Current password</label>
                    <input class="form-input" type="password" name="current_password" id="current_password">
                    @error('current_password')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid">
                    <label for="password">New password</label>
                    <input class="form-input" type="password" name="password" id="password">
                    @error('password')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid">
                    <label for="password_confirmation">New password confirmation</label>
                    <input class="form-input" type="password" name="password_confirmation" id="password_confirmation">
                    @error('password_confirmation')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>

                <button class="bg-blue hover:bg-blue-dark text-white px-5 py-2 rounded-sm text-sm" type="submit">Save</button>
            </form>
        </div>
    </div>
</x-page>
