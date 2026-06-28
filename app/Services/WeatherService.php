<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config("services.openweather.key") ?? "";
        $this->baseUrl =
            config("services.openweather.url") ??
            "https://api.openweathermap.org/data/2.5";
    }

    /**
     * Ambil data cuaca terkini untuk suatu kota.
     *
     * Format yang dikembalikan (selalu konsisten, baik dummy maupun real):
     * [
     *     'suhu'         => 27.3,
     *     'kondisi'      => 'Berawan Sebagian',
     *     'ikon'         => '⛅',
     *     'kelembaban'   => 72,
     *     'angin'        => 14.5,
     *     'curah_hujan'  => 0,
     *     'terasa_seperti' => 29.1,
     *     'kota'         => 'Bandung',
     * ]
     */
    public function getCurrentWeather(string $kota): array
    {
        if (empty($this->apiKey)) {
            return $this->getDummyCurrentWeather($kota);
        }

        try {
            $response = Http::timeout(5)->get("{$this->baseUrl}/weather", [
                "q" => $kota,
                "appid" => $this->apiKey,
                "units" => "metric",
                "lang" => "id",
            ]);

            if ($response->failed()) {
                Log::warning("Weather API gagal: {$response->status()}");
                return $this->getDummyCurrentWeather($kota);
            }

            $data = $response->json();

            return [
                "suhu" => round($data["main"]["temp"] ?? 0),
                "kondisi" =>
                    $data["weather"][0]["description"] ?? "Tidak Diketahui",
                "ikon" => $this->mapWeatherIcon(
                    $data["weather"][0]["main"] ?? "Clear",
                    $data["weather"][0]["icon"] ?? "",
                ),
                "kelembaban" => $data["main"]["humidity"] ?? 0,
                "angin" => round(($data["wind"]["speed"] ?? 0) * 3.6), // m/s → km/jam
                "curah_hujan" => $this->rainFromCurrent($data),
                "terasa_seperti" => round($data["main"]["feels_like"] ?? 0),
                "kota" => $data["name"] ?? $kota,
            ];
        } catch (\Throwable $e) {
            Log::error("Weather API error: {$e->getMessage()}");
            return $this->getDummyCurrentWeather($kota);
        }
    }

    /**
     * Ambil prakiraan 5 hari ke depan (per hari, ambil min/max suhu).
     *
     * Format dikembalikan:
     * [
     *     ['hari' => 'Hari Ini', 'ikon' => '⛅', 'suhu_max' => 28, 'suhu_min' => 22, 'kondisi' => 'Berawan'],
     *     ...
     * ]
     */
    public function getForecast(string $kota): array
    {
        if (empty($this->apiKey)) {
            return $this->getDummyForecast($kota);
        }

        try {
            $response = Http::timeout(5)->get("{$this->baseUrl}/forecast", [
                "q" => $kota,
                "appid" => $this->apiKey,
                "units" => "metric",
                "lang" => "id",
                "cnt" => 40, // 8 data/hari × 5 hari = 40
            ]);

            if ($response->failed()) {
                Log::warning("Forecast API gagal: {$response->status()}");
                return $this->getDummyForecast($kota);
            }

            $data = $response->json();
            $list = $data["list"] ?? [];
            $grouped = $this->groupByDate($list);
            $hasil = [];

            $hariJudul = [
                "Hari Ini",
                "Besok",
                "Lusa",
                "Hari ke-4",
                "Hari ke-5",
            ];
            $i = 0;

            foreach ($grouped as $tanggal => $items) {
                $minSuhu = min(array_column($items, "min"));
                $maxSuhu = max(array_column($items, "max"));
                // Ambil kondisi dominan dari data paling banyak muncul
                $kondisi = $this->dominantCondition($items);
                $iconCode = $this->dominantIcon($items);

                $hasil[] = [
                    "hari" => $hariJudul[$i] ?? "Hari ke-{$i}",
                    "ikon" => $this->mapWeatherIcon($kondisi, $iconCode),
                    "suhu_max" => round($maxSuhu),
                    "suhu_min" => round($minSuhu),
                    "kondisi" => $this->mapConditionLabel($kondisi),
                ];

                $i++;
                if ($i >= 5) {
                    break;
                }
            }

            return $hasil;
        } catch (\Throwable $e) {
            Log::error("Forecast API error: {$e->getMessage()}");
            return $this->getDummyForecast($kota);
        }
    }

    // ─── Dummy ───

    protected function getDummyCurrentWeather(string $kota): array
    {
        return [
            "suhu" => 27,
            "kondisi" => "Berawan Sebagian",
            "ikon" => "⛅",
            "kelembaban" => 72,
            "angin" => 14,
            "curah_hujan" => 0,
            "terasa_seperti" => 29,
            "kota" => $kota,
        ];
    }

    protected function getDummyForecast(string $kota): array
    {
        return [
            [
                "hari" => "Hari Ini",
                "ikon" => "⛅",
                "suhu_max" => 28,
                "suhu_min" => 22,
                "kondisi" => "Berawan",
            ],
            [
                "hari" => "Besok",
                "ikon" => "🌧️",
                "suhu_max" => 25,
                "suhu_min" => 20,
                "kondisi" => "Hujan Ringan",
            ],
            [
                "hari" => "Lusa",
                "ikon" => "⛈️",
                "suhu_max" => 23,
                "suhu_min" => 19,
                "kondisi" => "Hujan Lebat",
            ],
            [
                "hari" => "Hari ke-4",
                "ikon" => "🌤️",
                "suhu_max" => 29,
                "suhu_min" => 22,
                "kondisi" => "Cerah Berawan",
            ],
            [
                "hari" => "Hari ke-5",
                "ikon" => "☀️",
                "suhu_max" => 31,
                "suhu_min" => 23,
                "kondisi" => "Cerah",
            ],
        ];
    }

    // ─── Helper ───

    protected function mapWeatherIcon(
        string $main,
        string $iconCode = "",
    ): string {
        $isNight = str_ends_with($iconCode, "n");
        return match (strtolower($main)) {
            "clear" => $isNight ? "🌙" : "☀️",
            "clouds" => $isNight ? "☁️" : "⛅",
            "rain" => "🌧️",
            "drizzle" => "🌦️",
            "thunderstorm" => "⛈️",
            "snow" => "❄️",
            "mist", "fog", "haze" => "🌫️",
            default => $isNight ? "🌙" : "🌤️",
        };
    }

    protected function mapConditionLabel(string $main): string
    {
        return match (strtolower($main)) {
            "clear" => "Cerah",
            "clouds" => "Berawan",
            "rain" => "Hujan",
            "drizzle" => "Gerimis",
            "thunderstorm" => "Hujan Petir",
            "snow" => "Salju",
            "mist", "fog", "haze" => "Berkabut",
            default => "Berawan",
        };
    }

    protected function rainFromCurrent(array $data): float
    {
        // OWM v2: data.rain.1h atau data.rain.3h (milimeter)
        return $data["rain"]["1h"] ?? ($data["rain"]["3h"] ?? 0);
    }

    /**
     * Kelompokkan data forecast per tanggal.
     * Setiap item punya: min (suhu_min), max (suhu_max), main (kondisi cuaca).
     */
    protected function groupByDate(array $list): array
    {
        $grouped = [];

        foreach ($list as $item) {
            // dt_txt: "2026-06-21 12:00:00"
            $date = substr($item["dt_txt"] ?? "", 0, 10);

            if (empty($date)) {
                continue;
            }

            $grouped[$date][] = [
                "min" => $item["main"]["temp_min"] ?? 0,
                "max" => $item["main"]["temp_max"] ?? 0,
                "main" => $item["weather"][0]["main"] ?? "Clouds",
                "icon" => $item["weather"][0]["icon"] ?? "",
            ];
        }

        return $grouped;
    }

    /**
     * Cari kondisi cuaca yang paling sering muncul dalam satu hari.
     */
    protected function dominantCondition(array $items): string
    {
        $counts = [];

        foreach ($items as $item) {
            $cond = strtolower($item["main"]);
            $counts[$cond] = ($counts[$cond] ?? 0) + 1;
        }

        arsort($counts);

        return array_key_first($counts);
    }

    /**
     * Ambil icon code yang paling sering muncul (untuk day/night detection).
     */
    protected function dominantIcon(array $items): string
    {
        $counts = [];
        foreach ($items as $item) {
            $icon = $item["icon"] ?? "";
            if ($icon) {
                $counts[$icon] = ($counts[$icon] ?? 0) + 1;
            }
        }
        arsort($counts);
        return array_key_first($counts) ?? "";
    }
}
