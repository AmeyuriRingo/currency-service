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
        <div class="currencies-form">
            <h2>Latest rate:</h2>
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
        <div class="currencies-form">
            <h2>Rate by date:</h2>
            <form method="get" action="/currencies/rate-by-date" class="form">
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
        <br><br>
        <div class="currencies-form">
            <h2>Recommendation:</h2>
            <form method="get" action="/currencies/recommendations" class="form">
                <div class="row">
                    <label for="strategy" class="label">Choose strategy:</label>
                    <select name="strategy" id="strategy" class="select" onchange="change(this.value)" required>
                        @foreach($strategies as $strategy)
                            <option value="{{$strategy}}" class="option">{{$strategy}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <label for="base" class="label">Base currency: </label>
                    <input type="text" id="base" name="base" class="input" required>
                </div>
                <div class="row" id="dateRow">
                    <label for="date" class="label">Date:</label>
                    <input type="date" id="date" name="date" class="input">
                </div>
                <div class="row">
                    <label for="symbol" class="label">Symbol: </label>
                    <input type="text" id="symbol" name="symbol" class="input" required>
                </div>
                <button type="submit" class="btn">Submit</button>
            </form>
        </div>
    </div>
    <script>
        function change(str) {
            if (str === "Latest") {
                document.getElementById("dateRow").style.display = "none";
            } else if(str === 'By date') {
                document.getElementById("dateRow").style.display = "flex";
            }
        }
    </script>
@endsection
