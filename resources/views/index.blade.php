<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Погода</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: #f0f8ff;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .weather-box {
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .weather-box h2 {
            margin-bottom: 20px;
        }
        .weather-box .temp {
            font-size: 3em;
            font-weight: bold;
        }
        .weather-box .details {
            margin-top: 20px;
        }
        .forecast {
            display: flex;
            justify-content: space-between;
            flex-wrap: nowrap;
            overflow: hidden;
            position: relative;
        }
        .forecast .hourly {
            width: 30%;
            background: #e0f7fa;
            margin: 10px 0;
            padding: 10px;
            border-radius: 10px;
            text-align: center;
        }
        .forecast .arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.3);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        .forecast .arrow.left {
            left: 0;
        }
        .forecast .arrow.right {
            right: 0;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="weather-box text-center">
                <h2>Погода у {{ $weatherData['name'] }}</h2>
                <form action="{{ route('weather.store') }}" method="POST" class="mb-4">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="city" class="form-control" placeholder="Введіть місто" required>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">Пошук</button>
                        </div>
                    </div>
                </form>

                <div class="temp">{{ $weatherData['main']['temp'] }}°C</div>
                <div class="details">
                    @foreach ($weatherData['weather'] as $weather)
                        <p>{{ $weather['description'] }}</p>
                    @endforeach
                    <p>Вологість: {{ $weatherData['main']['humidity'] }}%</p>
                    <p>Швидкість вітру: {{ $weatherData['wind']['speed'] }} м/с</p>
                </div>
                <div class="forecast">
                    <button class="arrow left" onclick="move(-1)">&#9664;</button>

                    @foreach($forecast['list'] as $index => $forecastEntry)
                        <div class="hourly" data-index="{{ $index }}">
                            <p><strong>{{ \Carbon\Carbon::createFromTimestamp($forecastEntry['dt'])->format('Y-m-d H:i:s') }}</strong></p>
                            <p>{{ $forecastEntry['main']['temp'] }}°C</p>
                            <p>{{ $forecastEntry['weather'][0]['description'] }}</p>
                        </div>
                    @endforeach

                    <button class="arrow right" onclick="move(1)">&#9654;</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const items = document.querySelectorAll('.hourly');
    let currentIndex = 0;
    const visibleCount = 3;  // Кількість видимих полів

    function updateDisplay() {
        items.forEach((item, index) => {
            item.style.display = (index >= currentIndex && index < currentIndex + visibleCount) ? 'block' : 'none';
        });
    }

    function move(direction) {
        currentIndex += direction;
        if (currentIndex < 0) currentIndex = 0;
        if (currentIndex > items.length - visibleCount) currentIndex = items.length - visibleCount;
        updateDisplay();
    }

    // Ініціалізація відображення
    updateDisplay();
</script>
</body>
</html>
