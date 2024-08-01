<?php

namespace App\Http\Controllers\Weather;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use App\Services\Weather\WeatherService;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    protected $weatherService;

    public function __invoke(StoreRequest $request, WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
        $data = $this->weatherService->getCurrentWeather($request->city);
        $forecast = $this->weatherService->getForecast($request->city);

        if (isset($data['cod'])&&$data['cod']==404) {
            $errorMessage = isset($data['message']) ? $data['message'] : 'Sorry, this city was not found';
            return redirect()->route('index')->with('error', $errorMessage);
        }
        return view('index', ['weatherData' => $data, 'forecast'=>$forecast]);

    }
}
