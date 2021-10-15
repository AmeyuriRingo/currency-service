@extends('main')
@section('content')
    <div class="main">
        <div class="info">
            <p class="title">Functions:</p>
        </div>

        <div class="currencies-list">
            <form method="get" action="/list" class="form">
                <div class="row">
                    <label for="symbols" class="label">List of currencies: </label>
                    <input type="text" id="symbols" name="symbols" class="input" required>
                </div>
                <button type="submit" class="btn">Submit</button>
            </form>
            <a href="/list" class="link">List of latest exchange rates</a>
        </div>
        <br><br>
        <div class="recommendations-list">
            <form method="get" action="/recommendations" class="form">
                <div class="row">
                    <label for="start_date" class="label">Start date:</label>
                <input type="date" id="start_date" name="start_date" class="input" required>
                </div>
                <div class="row">
                    <label for="end_date" class="label">End date:</label>
                <input type="date" id="end_date" name="end_date" class="input" required>
                </div>
                <div class="row">
                    <label for="symbols" class="label">List of currencies: </label>
                <input type="text" id="symbols" name="symbols" class="input">
                </div>
                <button type="submit" class="btn">Submit</button>
            </form>
        </div>
    </div>
@endsection
