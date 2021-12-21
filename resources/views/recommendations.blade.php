@extends('main')
@section('content')
    <div class="main">
        <div class="info">
            <h1>Recommendation for {{ $data['date'] }}</h1>
            <a href="/">Back</a>
            <p>Base: {{ $data['base'] }}</p>
        </div>
        <div class="currencies">
            <div class="d-flex">
                <p>{{ $data['symbol'] }}: @if($data['recommendation'] > 0) Don't buy @else Buy @endif</p>
            </div>
        </div>
    </div>
@endsection
