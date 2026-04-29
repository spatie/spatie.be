<div {{ $attributes->merge([
    'class' => 'max-w-[625px] bg-oss-purple-extra-dark shadow-oss-card rounded-[20px] md:rounded-[48px] p-7 md:py-16 md:px-12',
]) }}>
    <h3 class="flex items-center gap-4 mb-6 text-4xl">
        {{-- <div class="bg-oss-purple text-oss-black w-[30px] h-[30px] rounded-full font-druk font-bold text-center text-[24px] leading-none pt-0.5">
            {{ $index }}
        </div> --}}
        <span class="font-druk text-oss-purple">{{ $index }}</span>
        <span class="font-druk uppercase text-white leading-tight">{{ $title }}</span>
    </h3>
    <p class="text-[14px] md:text-lg/snug">{{ $slot }}</p>
</div>
