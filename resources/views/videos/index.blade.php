@extends('layout.default')

@section('content')
    <h1>Videos</h1>
    <ul>
        @foreach($allSeries as $series)
            <li>{{ $series->name }}</li>
        @endforeach
    </ul>
@endsection