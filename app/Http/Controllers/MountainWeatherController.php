<?php

namespace App\Http\Controllers;

use App\Services\MountainWeatherService;
use App\Traits\ApiResponse;

class MountainWeatherController extends Controller
{
    use ApiResponse;

    public function __invoke(MountainWeatherService $weatherService)
    {
        return $this->success(
            array_values($weatherService->getAll()),
            'Data cuaca gunung berhasil diambil'
        );
    }
}
