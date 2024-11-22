<a class="flex-none avatar-sm hover:z-10"
    title="{{ $name }}" href="{{ $href ?? route('about') }}">
    {{ gravatar_img(strtolower($name) . '@spatie.be') }}
</a>
