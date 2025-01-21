<div
    {{ $attributes->merge([
        'class' => 'flex flex-col md:flex-row gap-16 mx-auto w-full max-w-[1080px]' . ' ' . ($alignItems ?? 'md:items-end')
    ]) }}
>
    <aside class="order-2 md:order-1 text-[14px] w-full max-w-[275px] lg:max-w-[325px] xl:max-w-[400px] shrink-0 flex flex-col">
        @isset ($aside)
            <div class="mt-10 md:mt-0 {{ $asideWidth ?? 'md:max-w-[200px]' }} md:ml-auto">
                {{ $aside }}
            </div>
       @endisset
    </aside>
    <div class="order-1 md:order-2 markup text-lg w-full max-w-[640px] lg:shrink-0 @unless(isset($aside)) ml-auto @endunless">
        <div class="{{ $contentWidth ?? 'max-w-[480px]' }}">
            {{ $slot }}
        </div>
    </div>
</div>
