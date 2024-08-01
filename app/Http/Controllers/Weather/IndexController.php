<?php

namespace App\Http\Controllers\Weather;

use App\Http\Controllers\Controller;
use App\Services\Weather\WeatherService;
use Illuminate\Http\Request;

class IndexController extends Controller
{  protected $weatherService;

    public function __invoke(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
        $city = 'London';
        $data = $this->weatherService->getCurrentWeather($city);
        $forecast = $this->weatherService->getForecast($city);

        return view('index', ['weatherData' => $data, 'forecast' => $forecast]);
    }
}
