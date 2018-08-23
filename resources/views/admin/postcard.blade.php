@extends('layout.default', [
   'title' => 'Postcards',
])

@section('content')

    <section class=section>
        <div class="wrap-6">
            <div class="spanx-6">

                @if(session('message'))
                    <div class="bg-green-lightest text-green-dark px-4 py-3 mb-8">{{ session('message') }}</div>
                @endif

                <h3 class="title">Add a post card</h3>

                <form action="{{ action('Admin\PostcardController@store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    {{ csrf_field() }}

                    <fieldset class="mt-8">
                        <div>
                            <div class="overflow-hidden inline-block">
                                <button id=image-button class="font-bold py-3 px-6 rounded bg-grey-lightest text-grey hover:text-grey-dark w-full">Upload image</button>
                                <input id=image class="absolute pin-l pin-t opacity-0 cursor-pointer" style="font-size:100px;" type="file" required accept="image/*" name="image">
                            </div>

                            <script>
                                const input = document.querySelector('#image');
                                const button = document.querySelector('#image-button');
                                const buttonVal = button.innerHTML;

                                input.addEventListener('change', e => {
                                    const fileName = e.target.value.split( '\\' ).pop();
                                    button.innerHTML = fileName ? fileName : buttonVal;
                                });
                            </script>
                        </div>

                        <div class="mt-4">
                            <label class="text-grey" for="sender">Senders</label><br/>
                            <input class="border-2 border-grey-lighter bg-white rounded p-4 outline-0 w-full focus:border-pink" type="text" name="sender" placeholder="John Doe, @twitterhandle">
                        </div>

                        <div class="mt-4 grid grid-cols gap-4" style="--cols: 1fr 1fr">
                            <div class="">
                                <label class="text-grey" for="city">City</label><br/>
                                <input class="border-2 border-grey-lighter bg-white rounded p-4 outline-0 w-full focus:border-pink" type="text" name="city" placeholder="Antwerp">
                            </div>

                            <div>
                                <label class="text-grey" for="country">Country</label><br/>
                                <input class="border-2 border-grey-lighter bg-white rounded p-4 outline-0 w-full focus:border-pink" type="text" name="country" placeholder="Belgium">
                            </div>
                        </div>
                    </fieldset>

                    <div class="mt-8">
                        <input class="font-bold py-3 px-6 rounded bg-blue text-white hover:bg-blue-dark" type="submit" value="Create postcard">
                    </div>
                </form>

                <div class="mt-32">
                    <h3 class="title">Current postcards</h3>

                   <div class="md:grid md:grid-cols" style="--cols: 1fr 1fr 1fr auto">
                        @foreach($postcards as $postcard)

                            <div class="cell-l">
                                <div class="illustration is-postcard-without-caption">
                                    {{ $postcard->getFirstMedia() }}
                                </div>
                            </div>
                            <div class="cell">
                                {!! $postcard->sender !!}
                            </div>
                            <div class="cell">
                                <div class="text-sm text-grey">
                                    <span class="icon ml-1 flex-none fill-grey-lighter">{{ svg('icons/fas-map-marker-alt') }}</span> {{ $postcard->location }}
                                </div>
                            </div>
                            <div class="cell-r">
                                <form method="POST" action="{{ action('Admin\PostcardController@delete', ['postcard' => $postcard->id]) }}">
                                    @csrf

                                    <input name="_method" type="hidden" value="DELETE">
                                    <input class="link-red link-underline bg-transparent" type="submit" value="Delete">
                                </form>
                            </div>

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop
