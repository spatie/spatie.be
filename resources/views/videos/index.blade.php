@extends('layout.default')

@section('content')
    <h1>Videos</h1>
    <ul>
        @foreach($allSeries as $series)
            <li><a href="{{ $series->url }}">{{ $series->title }}</a></li>
        @endforeach
    </ul>
@endsection