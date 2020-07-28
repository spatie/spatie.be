<x-page
        title="{{ $page->title }}"
        background="/backgrounds/about.jpg">
    <x-slot name="description">
        This is a placeholder
    </x-slot>

{{--    @include('front.pages.about.partials.banner')--}}

    {{ $page->alias }}

    {{ $page->repository }}

    <div class="section section-group wrap md:grid md:grid-cols" style="--cols: 1fr 2fr">
        <div>
            @include('front.pages.docs.partials.navigation')
        </div>


        <div>
            <article class="article">
                {!! $page->contents !!}
            </article>

            <div class="toolbar">


                <a class="toolbar_item" target="_external"
                   href="https://github.com/spatie/enum/edit/master/docs/introduction.md">Edit on <span><svg
                                class="github" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1024 1024"
                                style="enable-background:new 0 0 1024 1024;" xml:space="preserve">
<style type="text/css">
    .github_back {
        fill: #000000;
    }
</style>
    <path class="github_back" d="M512,0C229.2,0,0,229.2,0,512c0,226.2,146.7,418.1,350.2,485.8c25.6,4.7,34.9-11.1,34.9-24.6
	c0-12.2-0.5-52.6-0.7-95.3c-142.4,30.9-172.5-60.4-172.5-60.4c-23.3-59.1-56.8-74.9-56.8-74.9c-46.5-31.8,3.5-31.1,3.5-31.1
	c51.4,3.6,78.5,52.8,78.5,52.8c45.7,78.2,119.9,55.6,149,42.5c4.7-33,17.9-55.6,32.5-68.4c-113.7-12.9-233.2-56.9-233.2-253.1
	c0-55.9,20-101.6,52.7-137.4c-5.2-13-22.8-65.1,5.1-135.6c0,0,42.9-13.8,140.8,52.5c40.8-11.4,84.6-17,128.1-17.2
	c43.5,0.2,87.3,5.9,128.2,17.3c97.7-66.3,140.7-52.5,140.7-52.5c28,70.5,10.4,122.6,5.1,135.5c32.8,35.8,52.6,81.5,52.6,137.4
	c0,196.7-119.8,240-233.8,252.7c18.4,15.9,34.8,47,34.8,94.8c0,68.4-0.7,123.6-0.7,140.5c0,13.6,9.3,29.6,35.2,24.6
	C877.4,930,1024,738.1,1024,512C1024,229.2,794.8,0,512,0z"></path>
</svg>
</span></a>
            </div>

        </div>
    </div>
</x-page>
