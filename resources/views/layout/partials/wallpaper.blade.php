@if($background && $image = image($background))
    <div class="wallpaper opacity-50 | md:opacity-100">
        {{-- wallpaper is always 100vw, so we don't need pragmatic srcset sizes --}}
        <img srcset="{{ $image->getSrcset() }}" src="{{ $image->getUrl() }}" width="2400" sizes="100vw" alt="">
    </div>
@endif

@isset($backgroundOffline)
    <div class="wallpaper">
        <img src="/images/offline.jpg" width="2400" alt="">
    </div>
@endisset
