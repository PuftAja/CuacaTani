<?php

namespace App\Services;

class WeatherService
{
    /**
     * Dapatkan prakiraan cuaca 5 hari berdasarkan nama kota.
     *
     * Saat ini masih berupa data dummy.
     * Nanti akan diganti dengan panggilan API OpenWeatherMap yang sesungguhnya.
     *
     * Format output mengikuti kontrak data Mhs 2 → Mhs 3:
     * [
     *   'tanggal'        => '2026-06-21',
     *   'suhu_min'       => 24,
     *   'suhu_max'       => 31,
     *   'kondisi'        => 'hujan',   // 'hujan' | 'cerah' | 'berawan' | 'panas'
     *   'curah_hujan_mm' => 5.2,
     * ]
     *
     * @param string $kota Nama kota (contoh: 'Purwakarta', 'Jakarta')
     * @return array
     */
    public function getForecast(string $kota): array
    {
        // ============================================================
        // DUMMY — data statis untuk pengembangan awal.
        // TODO: Ganti dengan panggilan API OpenWeatherMap yang real.
        // ============================================================

        $forecasts = [];

        // Ambil tanggal hari ini
        $tanggalSekarang = now();

        for ($i = 0; $i < 5; $i++) {
            $tanggal = $tanggalSekarang->copy()->addDays($i)->format('Y-m-d');

            // Simulasi variasi cuaca berdasarkan indeks hari
            $perkiraan = $this->dummyPerHari($i);

            $forecasts[] = [
                'tanggal'        => $tanggal,
                'suhu_min'       => $perkiraan['suhu_min'],
                'suhu_max'       => $perkiraan['suhu_max'],
                'kondisi'        => $perkiraan['kondisi'],
                'curah_hujan_mm' => $perkiraan['curah_hujan_mm'],
            ];
        }

        return $forecasts;
    }

    /**
     * Hasilkan data dummy untuk satu hari berdasarkan indeks.
     * Supaya tidak monoton, dibuat bervariasi.
     *
     * @param int $indeks 0 = hari ini, 1 = besok, dst.
     * @return array
     */
    private function dummyPerHari(int $indeks): array
    {
        // Variasi kondisi cuaca secara bergantian
        $daftarKondisi = ['cerah', 'berawan', 'hujan', 'panas', 'berawan'];

        // Suhu dasar + variasi acak biar realistis
        $suhuMinDasar  = [24, 23, 22, 25, 24];
        $suhuMaxDasar  = [31, 30, 28, 33, 29];

        $suhuMin = $suhuMinDasar[$indeks] ?? 24;
        $suhuMax = $suhuMaxDasar[$indeks] ?? 31;
        $kondisi = $daftarKondisi[$indeks] ?? 'cerah';
        $curahHujan = ($kondisi === 'hujan') ? round(rand(10, 80) / 10, 1) : 0.0;

        return [
            'suhu_min'       => $suhuMin,
            'suhu_max'       => $suhuMax,
            'kondisi'        => $kondisi,
            'curah_hujan_mm' => $curahHujan,
        ];
    }
}
