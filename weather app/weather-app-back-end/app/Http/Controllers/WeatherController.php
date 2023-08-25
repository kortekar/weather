<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function getWeather(Request $request)
    {
        $location = $request->query('location');
        $apiKey = '0442c803d2c3dccb1c8b3a171baddf20';
        $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q=$location&appid=$apiKey&units=metric";

        try {
            $response = Http::get($apiUrl);
            $data = $response->json();

            $weatherData = [
                'name' => $data['name'],
                'main' => [
                    'temp' => $data['main']['temp'],
                    'humidity' => $data['main']['humidity'],
                ],
            ];
            \Log::info('Weather Data:', $weatherData); // Log the weather data
            return response()->json($weatherData);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching weather data.'], 500);
        }
    }
}
