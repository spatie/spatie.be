<x-page
        title="Update password"
        background="/backgrounds/home.jpg"
>

    <div class="wrap flex">
        @include('auth.partials.sidebar')

        <div class="ml-4">
            <h1>Update password</h1>

            <form action="{{ route('profile.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password">Current password</label>
                    <input type="password" name="current_password" id="current_password">
                    @error('current_password')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password">New password</label>
                    <input type="password" name="password" id="password">
                    @error('password')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation">New password confirmation</label>
                    <input type="password" name="password_confirmation" id="password_confirmation">
                    @error('password_confirmation')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit">Save</button>
            </form>
        </div>
    </div>
</x-page>
