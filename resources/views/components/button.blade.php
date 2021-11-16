<button class="cursor-pointer
bg-yellow hover:bg-opacity-75 rounded-sm
border-2 border-transparent
justify-center flex items-center
{{ $attributes['large'] ? 'px-4 min-h-12 text-xl shadow-lg' : 'px-6 min-h-10' }}
font-sans-bold text-black
transition-bg duration-300
focus:outline-none focus:border-blue-light whitespace-no-wrap">
    {{ $slot }}
</button>
