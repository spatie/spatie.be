<section id="search" class="section">
    <div class="wrap flex justify-center">
        <input class="border-2 border-grey-lighter bg-white rounded-full p-4 outline-0 focus:border-pink" type=search placeholder="Search for a package…">
    </div>
    <div class="wrap mt-8">
        <div class="flex items-baseline">
            <h3 class="title-sm text-grey mb-4">
                All results
            </h3>
            <div class="sort">
                <select class="sort-select outline-0">
                    <option selected>by name</option>
                    <option>by popularity</option>
                    <option>by date</option>
                </select>
                <i class="sort-arrow far fa-angle-down"></i>
            </div>
        </div>
        <div class="cells" style="--cols: 1fr 1fr auto">
            @foreach($repositories as $repository)
                @include('pages.open-source.partials.repository')
            @endforeach
        </div>
    </div>
</section>
