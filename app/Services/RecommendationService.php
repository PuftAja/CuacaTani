<?php

namespace App\Services;

/** Logika rekomendasi sederhana if-else untuk petani. */
class RecommendationService
{
    /** Threshold suhu Celcius per komoditas. */
    protected array $threshold = [
        "padi" => ["panas" => 32, "dingin" => 18],
        "jagung" => ["panas" => 35, "dingin" => 15],
    ];

    /** Curah hujan minimum mm/hari. */
    protected float $hujanThreshold = 0.5;

    /**
     * Generate rekomendasi berdasarkan data prakiraan cuaca.
     *
     * @param  array  $prakiraan  dari WeatherService::getForecast()
     * @param  string $komoditas  padi|jagung
     * @return array  of ['tanggal', 'rekomendasi', 'aksi']
     */
    public function getRekomendasi(array $prakiraan, string $komoditas): array
    {
        $hasil = [];
        $t = now();

        foreach ($prakiraan as $idx => $hari) {
            $tanggal = $t->copy()->addDays($idx)->format("Y-m-d");
            $suhuMax = $hari["suhu_max"];
            $suhuMin = $hari["suhu_min"];
            $kondisi = strtolower($hari["kondisi"]);

            $rekomendasi = $this->tentukanRekomendasi(
                $suhuMax,
                $suhuMin,
                $kondisi,
                $komoditas,
            );

            $hasil[] = [
                "tanggal" => $tanggal,
                "rekomendasi" => $rekomendasi["pesan"],
                "aksi" => $rekomendasi["aksi"],
                "ikon" => $this->ikonAksi($rekomendasi["aksi"]),
            ];
        }

        return $hasil;
    }

    /**
     * Logika if-else utama.
     */
    protected function tentukanRekomendasi(
        float $suhuMax,
        float $suhuMin,
        string $kondisi,
        string $komoditas,
    ): array {
        $th = $this->threshold[$komoditas] ?? $this->threshold["padi"];

        // ── 1. Hujan lebat → tunda pemupukan ──
        if (
            str_contains($kondisi, "hujan") ||
            str_contains($kondisi, "petir")
        ) {
            return [
                "pesan" =>
                    "Hujan diprediksi hari ini. Tunda pemupukan agar pupuk tidak larut dan terbawa air hujan.",
                "aksi" => "tunda_pemupukan",
            ];
        }

        // ── 2. Suhu terlalu panas → siram lebih banyak ──
        if ($suhuMax >= $th["panas"]) {
            return [
                "pesan" => "Suhu panas {$suhuMax}°C. Siram lahan lebih awal (pagi hari) dan tingkatkan frekuensi penyiraman.",
                "aksi" => "siram",
            ];
        }

        // ── 3. Suhu terlalu dingin → lindungi tanaman ──
        if ($suhuMin <= $th["dingin"]) {
            return [
                "pesan" => "Suhu dingin {$suhuMin}°C. Tutupi tanaman atau gunakan mulsa untuk menjaga kehangatan.",
                "aksi" => "lindungi_tanaman",
            ];
        }

        // ── 4. Kondisi cerah / ideal → pemupukan normal ──
        if (
            str_contains($kondisi, "cerah") ||
            str_contains($kondisi, "berawan")
        ) {
            return [
                "pesan" =>
                    "Kondisi cuaca ideal. Waktu yang tepat untuk pemupukan dan perawatan rutin.",
                "aksi" => "pemupukan_normal",
            ];
        }

        // ── Default: tidak ada aksi khusus ──
        return [
            "pesan" =>
                "Tidak ada aksi khusus yang diperlukan. Pantau kondisi lahan secara berkala.",
            "aksi" => "tidak_ada",
        ];
    }

    /**
     * Ikon berdasarkan jenis aksi.
     */
    protected function ikonAksi(string $aksi): string
    {
        return match ($aksi) {
            "siram" => "💧",
            "tunda_pemupukan" => "⛔",
            "pemupukan_normal" => "✅",
            "lindungi_tanaman" => "🛡️",
            default => "📋",
        };
    }
}
