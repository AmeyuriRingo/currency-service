@extends('main')
@section('content')
    <div class="main">
        <p>Hello list</p>
        <a href="/">Back</a>
    </div>
    <p>Base: {{ $data->base }}</p>
    @foreach($data->rates as $currency => $rate)
        <p>{{ $currency }}: {{ round($rate, 6) }}</p>
    @endforeach
@endsection
