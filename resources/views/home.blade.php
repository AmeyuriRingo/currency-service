@extends('main')
@section('content')
    <div class="main">
        <div class="info">
            <h1 class="title">Functions:</h1>
        </div>
        <div class="error">
            @if(isset($error))
                {{ $error }}
            @endif
        </div>
        <div class="currencies-list">
            <form method="get" action="/currencies/rate" class="form">
                <div class="row">
                    <label for="base" class="label">Base currency: </label>
                    <input type="text" id="base" name="base" class="input" required>
                </div>
                <div class="row">
                    <label for="symbol" class="label">Symbol: </label>
                    <input type="text" id="symbol" name="symbol" class="input" required>
                </div>
                <button type="submit" class="btn">Submit</button>
            </form>
        </div>
        <br><br>
        <div class="recommendations-list">
            <form method="get" action="/currencies/recommendations" class="form">
                <div class="row">
                    <label for="base" class="label">Base currency: </label>
                    <input type="text" id="base" name="base" class="input" required>
                </div>
                <div class="row">
                    <label for="date" class="label">Date:</label>
                <input type="date" id="date" name="date" class="input" required>
                </div>
                <div class="row">
                    <label for="symbol" class="label">Symbol: </label>
                    <input type="text" id="symbol" name="symbol" class="input" required>
                </div>
                <button type="submit" class="btn">Submit</button>
            </form>
        </div>
    </div>
@endsection
