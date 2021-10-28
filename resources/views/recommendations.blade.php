@extends('main')
@section('content')
    <div class="main">
        <div class="info">
            <h1>Recommendations for {{ $data['end']->date }}</h1>
            <a href="/">Back</a>
            <p>Base: {{ $data['start']->base }}</p>
        </div>
        <div class="currencies">
            <div class="d-flex">
                @foreach($data['start']->rates as $currency => $rate)
                    <p>{{ $currency }}: {{ round($rate, 6) }}</p>
                @endforeach
            </div>
            <div class="d-flex">
                @foreach($data['end']->rates as $currency => $rate)
                    <p class="@if($rate['difference'] < 0) green @else red @endif">{{ $currency }}:
                        {{ round($rate['rate'], 6) }}, difference: {{ $rate['difference'] < 0 ? $rate['difference'] : '+' . $rate['difference']}}</p>
                @endforeach
            </div>
        </div>
    </div>
@endsection
