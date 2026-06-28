<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use App\Services\RecommendationService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected WeatherService $weather,
        protected RecommendationService $recommendation,
    ) {}

    /**
     * Dashboard utama: tampilkan cuaca terkini + rekomendasi
     * berdasarkan lahan pertama milik petani.
     */
    public function index(): View
    {
        $lahans = auth()->user()->lahans;
        $totalLahan = $lahans->count();
        $totalHektar = $lahans->sum("luas_lahan");
        $jumlahPadi = $lahans->where("komoditas", "padi")->count();
        $jumlahJagung = $lahans->where("komoditas", "jagung")->count();

        // Default kota jika belum ada lahan
        $kota = "Bandung";
        $komoditas = "padi";

        if ($totalLahan > 0) {
            $lahanPertama = $lahans->first();
            $kota = $lahanPertama->kota;
            $komoditas = $lahanPertama->komoditas;
        }

        // WeatherService sudah handle dummy jika API key kosong
        $cuacaSekarang = $this->weather->getCurrentWeather($kota);
        $prakiraan = $this->weather->getForecast($kota);
        $rekomendasi =
            $totalLahan > 0
                ? $this->recommendation->getRekomendasi($prakiraan, $komoditas)
                : [];

        $isDummy = empty(config("services.openweather.key"));

        return view(
            "dashboard",
            compact(
                "lahans",
                "totalLahan",
                "totalHektar",
                "jumlahPadi",
                "jumlahJagung",
                "cuacaSekarang",
                "prakiraan",
                "rekomendasi",
                "kota",
                "komoditas",
                "isDummy",
            ),
        );
    }
}
