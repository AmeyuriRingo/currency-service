@extends('main')
@section('content')
    <div class="main">
        <div class="info">
            <h1>List of latest currencies</h1>
            <a href="/">Back</a>
            <p>Base: {{ $data->base }}</p>
        </div>
    </div>
    <div class="currencies">
        <div class="d-flex">
            @foreach($data->rates as $currency => $rate)
                <p>{{ $currency }}: {{ round($rate, 2) }}</p>
            @endforeach
        </div>
    </div>
@endsection
