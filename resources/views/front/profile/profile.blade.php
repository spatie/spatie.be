<x-page
    title="Profile"
    body-class="bg-oss-black text-oss-gray font-medium font-pt antialiased mb-0"
    dark
>

    @include('layout.partials.gradient-background', [
        'color1' => '#2EC4B6',
        'color2' => '#197593',
        'color3' => '#50E69B',
        'rotationZ' => '270',
        'positionX' => '0.3',
        'positionY' => '-0.2',
        'uDensity' => '1.6',
        'uFrequency' => '4.0',
        'uStrength' => '2.5',
    ])

    <x-profile-layout title="My profile">
        @if (auth()->user()->github_id)
            <div class="mb-8">
                <span class="flex items-center">
                    <span class="icon fill-current w-4 mr-2">{{ app_svg('github') }}</span>
                    <span class="font-bold">{{ auth()->user()->github_username }}</span>
                    <a class="ml-4 underline text-oss-spatie-blue hover:text-white" href="{{ route('github-disconnect') }}">Disconnect from GitHub</a>
                </span>
            </div>
        @endif

        <div class="bg-oss-purple-extra-dark shadow-oss-card rounded-[20px] p-7 md:py-12 md:px-12">
            <form class="space-y-6" action="{{ route('profile') }}" method="POST">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium mb-1.5">Your name</label>
                    <input class="w-full px-4 py-3 bg-white/[0.07] border border-white/10 text-white rounded-lg placeholder-white/30 focus:border-oss-spatie-blue focus:outline-none" type="text" name="name" id="name"
                           autocomplete="name" value="{{ old('name', auth()->user()->name) }}">
                    @error('name')
                    <div class="text-oss-red text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium mb-1.5">Your email</label>
                    <input class="w-full px-4 py-3 bg-white/[0.07] border border-white/10 text-white rounded-lg placeholder-white/30 focus:border-oss-spatie-blue focus:outline-none" type="email" name="email" id="email"
                           autocomplete="email" value="{{ old('email', auth()->user()->email) }}">
                    @error('email')
                    <div class="text-oss-red text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                @if (auth()->user()->email)
                    <div>
                        <label for="newsletter" class="flex items-center cursor-pointer">
                            <input class="form-checkbox mr-4" type="checkbox" name="newsletter"
                                   id="newsletter" {{ auth()->user()->isSubscribedToNewsletter() ? 'checked' : ''}}>
                            Keep me in the loop when there is new Spatie content
                        </label>
                    </div>
                @endif

                <button class="w-full sm:w-auto flex items-center justify-center px-6 py-3.5 bg-oss-green-pale text-oss-royal-blue font-bold rounded-lg hover:opacity-90 transition-opacity cursor-pointer" type="submit">
                    Save profile
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-white/10">
                <form action="{{ route('profile') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="underline text-oss-red text-sm" type="submit"
                            onclick="return confirm('Are you sure you want to delete your account?')">Delete my account
                    </button>
                </form>
            </div>
        </div>
    </x-profile-layout>
</x-page>
