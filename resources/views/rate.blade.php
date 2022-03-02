@extends('main')
@section('content')
    <div class="main">
        <div class="info">
            <h1>List of currencies</h1>
            <a href="/">Back</a>
            <p>Base: {{ $data['base'] }}</p>
            @if(isset($data['date']))
                <p>Date: {{ $data['date'] }}</p>
            @endif
        </div>
    </div>
    <div class="currencies">
        <div class="d-flex">
            <p>{{ $data['symbol'] }}: {{ round($data['rate'], 2) }}</p>
        </div>
    </div>
@endsection
