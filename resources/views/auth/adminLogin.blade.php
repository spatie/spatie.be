<x-blank :no-index="true" body-class="bg-oss-black text-oss-gray font-pt antialiased">
    <x-slot name="title">Admin sign in</x-slot>

    <main class="min-h-[100svh] flex items-center justify-center px-5 py-12 sm:px-8">
        <div class="w-full max-w-[520px]">
            <a href="{{ url('/') }}" aria-label="Spatie home" class="inline-flex h-12 w-28 mb-10 rounded-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-8 focus-visible:outline-white">
                @app_svg('logo')
            </a>

            <section aria-labelledby="admin-sign-in-heading" class="rounded-[24px] sm:rounded-[40px] bg-oss-purple-extra-dark p-7 sm:p-12">
                <h1 id="admin-sign-in-heading" class="font-druk font-bold uppercase text-[56px] sm:text-[72px] leading-[0.95] text-white">Admin sign in</h1>
                <p id="admin-sign-in-description" class="mt-5 text-lg leading-relaxed text-oss-gray-medium">
                    Use your approved <span class="whitespace-nowrap text-white">@spatie.be</span> Google account to access the admin.
                </p>

                @error('google')
                    <div role="alert" class="mt-7 flex items-start gap-3 rounded-lg border border-oss-red/40 bg-oss-red/10 p-4 text-oss-gray">
                        <svg aria-hidden="true" class="mt-0.5 h-5 w-5 shrink-0 text-oss-red" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                            <circle cx="12" cy="12" r="9" />
                            <path stroke-linecap="round" d="M12 7v6m0 4h.01" />
                        </svg>
                        <p class="text-base leading-relaxed">{{ $message }}</p>
                    </div>
                @enderror

                <form class="mt-8" method="POST" action="{{ route('filament.admin.auth.google') }}" x-data="{ submitting: false }" x-on:submit="submitting = true" x-on:pageshow.window="submitting = false">
                    @csrf
                    <button type="submit" aria-describedby="admin-sign-in-description" x-bind:disabled="submitting" x-bind:aria-busy="submitting" class="flex min-h-[56px] w-full cursor-pointer items-center justify-center gap-3 rounded-lg bg-white px-4 py-4 text-base sm:text-lg font-bold leading-6 text-oss-black transition-colors duration-150 hover:bg-oss-gray focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-white disabled:cursor-wait disabled:bg-oss-gray-medium disabled:text-oss-royal-blue motion-reduce:transition-none">
                        <svg aria-hidden="true" class="h-5 w-5 shrink-0" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M21.6 12.23c0-.71-.06-1.39-.18-2.05H12v3.88h5.38a4.6 4.6 0 0 1-1.99 3.02v2.51h3.23c1.89-1.74 2.98-4.3 2.98-7.36Z" />
                            <path fill="#34A853" d="M12 22c2.7 0 4.96-.9 6.62-2.41l-3.23-2.51c-.9.6-2.04.97-3.39.97-2.6 0-4.8-1.76-5.59-4.12H3.07v2.59A10 10 0 0 0 12 22Z" />
                            <path fill="#FBBC05" d="M6.41 13.93a6 6 0 0 1 0-3.86V7.48H3.07a10 10 0 0 0 0 9.04l3.34-2.59Z" />
                            <path fill="#EA4335" d="M12 5.95c1.47 0 2.79.51 3.83 1.51l2.87-2.87A9.6 9.6 0 0 0 12 2a10 10 0 0 0-8.93 5.48l3.34 2.59C7.2 7.71 9.4 5.95 12 5.95Z" />
                        </svg>
                        <span aria-live="polite">
                            <span x-show="! submitting">Continue with Google</span>
                            <span x-show="submitting" x-cloak>Connecting to Google…</span>
                        </span>
                    </button>
                </form>

                <p class="mt-6 text-sm leading-relaxed text-oss-gray-dark">Need access? Ask an administrator to add your address.</p>
            </section>

            <a href="{{ url('/') }}" class="mt-6 inline-flex min-h-[44px] items-center gap-2 rounded-sm text-oss-gray-medium transition-colors duration-150 hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-white motion-reduce:transition-none">
                <svg aria-hidden="true" class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8 5-5 5 5 5M3 10h14" />
                </svg>
                Back to website
            </a>
        </div>
    </main>
</x-blank>
