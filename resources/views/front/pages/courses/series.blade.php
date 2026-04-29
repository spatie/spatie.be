<x-page
    :title="$title"
    :description="$description"
    body-class="bg-oss-black text-oss-gray font-medium font-pt antialiased mb-0"
    dark
>

    @include('layout.partials.bg-color')

    @include("front.pages.courses.content.{$series->type->value}.index")

</x-page>
