@isset($background)
    <div class="wallpaper">
        {{-- wallpaper is always 100vw, so we don't need pragmatic srcset sizes --}}
        <img srcset="{{ image($background)->getSrcset() }}" src="{{ image($background)->getUrl() }}" width="2400" sizes="100vw">
    </div>
@endisset
