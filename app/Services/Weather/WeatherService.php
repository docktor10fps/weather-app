<?php

namespace App\Services\Weather;
use Illuminate\Support\Facades\Http;
class WeatherService
{
    protected $apiKey;

    public function __construct()
    {

        $this->apiKey = config('services.weather.api_key');
    }
    public function getCurrentWeather($city)
    {
        $response = Http::get("http://api.openweathermap.org/data/2.5/weather", [
            'q' => $city,
            'appid' => $this->apiKey,
            'units' => 'metric',
        ]);

        return $response->json();
    }
    public function getForecast($city)
    {
        $response = Http::get("http://api.openweathermap.org/data/2.5/forecast", [
            'q' => $city,
            'appid' => $this->apiKey,
            'units' => 'metric',
        ]);

        return $response->json();
    }
}
