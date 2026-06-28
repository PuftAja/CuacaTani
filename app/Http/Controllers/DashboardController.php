<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use App\Services\RecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    protected WeatherService $weather;
    /** @var RecommendationService */
    protected RecommendationService $recommendation;

    public function __construct(
        WeatherService $weather,
        RecommendationService $recommendation,
    ) {
        $this->weather = $weather;
        $this->recommendation = $recommendation;
    }

    /**
     * Dashboard utama: tampilkan cuaca terkini + rekomendasi
     * berdasarkan lahan pertama milik petani.
     */
    public function index(Request $request): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $lahans = $user->lahans;
        $totalLahan = $lahans->count();
        $totalHektar = $lahans->sum("luas_lahan");
        $jumlahPadi = $lahans->where("komoditas", "padi")->count();
        $jumlahJagung = $lahans->where("komoditas", "jagung")->count();

        // Default: kota dummy jika belum ada lahan
        $kota = "Bandung";
        $komoditas = "padi";
        $lahanAktif = null;

        if ($totalLahan > 0) {
            // Pilih lahan berdasarkan dropdown atau default ke pertama
            $lahanAktif = $request->filled("lahan_id")
                ? $lahans->firstWhere("id", $request->lahan_id)
                : $lahans->first();

            // Jika lahan_id tidak valid (bukan milik user), fallback ke pertama
            if (!$lahanAktif) {
                $lahanAktif = $lahans->first();
            }

            $kota = $lahanAktif->kota;
            $komoditas = $lahanAktif->komoditas;
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
                "lahanAktif",
                "isDummy",
            ),
        );
    }
}
