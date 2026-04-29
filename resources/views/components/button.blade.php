<button class="cursor-pointer
 inline-flex items-center justify-center
 bg-oss-green hover:bg-oss-green-pale text-oss-royal-blue
 font-semibold rounded-lg transition-colors
 {{ $attributes['large'] ? 'px-6 py-3 text-lg' : 'px-4 py-2' }}
 whitespace-nowrap {{ $attributes->get('class') }}">
     {{ $slot }}
</button>
