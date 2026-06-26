<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WeatherService;
use Illuminate\Http\JsonResponse;

class CuacaController extends Controller
{
    public function __construct(
        private WeatherService $weatherService,
    ) {}

    /**
     * GET /api/cuaca/{kota}
     *
     * Mengembalikan prakiraan cuaca 5 hari untuk kota tertentu.
     * Saat ini menggunakan data dummy.
     */
    public function index(string $kota): JsonResponse
    {
        $forecast = $this->weatherService->getForecast($kota);

        return response()->json([
            'success'  => true,
            'kota'     => $kota,
            'forecast' => $forecast,
        ]);
    }
}
