<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class MountainWeatherService
{
    private const CACHE_TTL_SECONDS = 900;

    public function getAll(): array
    {
        return Cache::remember('mountain_weather', self::CACHE_TTL_SECONDS, function () {
            $slides = config('mountains.slides', []);
            $weather = [];

            foreach ($slides as $index => $slide) {
                $weather[$index] = $this->fetchForMountain($index, $slide);
            }

            return $weather;
        });
    }

    private function fetchForMountain(int $index, array $slide): array
    {
        $fallback = $this->fallback($index, $slide);

        try {
            $response = Http::timeout(8)->get('https://api.open-meteo.com/v1/forecast', [
                'latitude' => $slide['latitude'],
                'longitude' => $slide['longitude'],
                'elevation' => $slide['elevation_m'],
                'current' => 'temperature_2m,weather_code',
                'timezone' => 'Asia/Jakarta',
            ]);

            if (! $response->successful()) {
                return $fallback;
            }

            $current = $response->json('current');

            if (! is_array($current)) {
                return $fallback;
            }

            $temperature = round($current['temperature_2m'] ?? 0);
            $weatherCode = (int) ($current['weather_code'] ?? 3);
            $condition = $this->mapWeatherCode($weatherCode);

            return [
                'index' => $index,
                'name' => $slide['name'],
                'temperature' => $temperature,
                'temperature_formatted' => $temperature.'°C',
                'weather_code' => $weatherCode,
                'weather' => $condition['key'],
                'weather_label' => $condition['label'],
                'updated_at' => $current['time'] ?? now()->toIso8601String(),
                'live' => true,
            ];
        } catch (\Throwable) {
            return $fallback;
        }
    }

    private function mapWeatherCode(int $code): array
    {
        return match (true) {
            in_array($code, [0, 1], true) => ['key' => 'sunny', 'label' => 'Cerah'],
            in_array($code, [2, 3], true) => ['key' => 'cloudy', 'label' => 'Berawan'],
            in_array($code, [45, 48], true) => ['key' => 'foggy', 'label' => 'Berkabut'],
            in_array($code, [51, 53, 55, 61, 63, 65, 80, 81, 82, 95, 96, 99], true) => ['key' => 'rainy', 'label' => 'Hujan'],
            in_array($code, [71, 73, 75, 77, 85, 86], true) => ['key' => 'snowy', 'label' => 'Salju'],
            default => ['key' => 'cloudy', 'label' => 'Berawan'],
        };
    }

    private function fallback(int $index, array $slide): array
    {
        $defaults = [
            ['temp' => 8, 'weather' => 'cloudy', 'label' => 'Berawan'],
            ['temp' => 7, 'weather' => 'foggy', 'label' => 'Berkabut'],
            ['temp' => 5, 'weather' => 'cloudy', 'label' => 'Berawan'],
        ];

        $default = $defaults[$index] ?? $defaults[0];

        return [
            'index' => $index,
            'name' => $slide['name'],
            'temperature' => $default['temp'],
            'temperature_formatted' => $default['temp'].'°C',
            'weather_code' => null,
            'weather' => $default['weather'],
            'weather_label' => $default['label'],
            'updated_at' => null,
            'live' => false,
        ];
    }
}
