# Agent Guide — Project CuacaTani

> File ini adalah konteks utama untuk AI coding assistant (Claude/ChatGPT/dll) yang membantu pengerjaan project ini. Baca file ini dulu sebelum baca `mahasiswa1.md`, `mahasiswa2.md`, atau `mahasiswa3.md`.

## 1. Tentang Project

**CuacaTani** adalah sistem rekomendasi pertanian berbasis cuaca, dibangun dengan **Laravel** (Blade views). Tujuannya: bantu petani melihat prakiraan cuaca 5 hari ke depan dan dapat rekomendasi aktivitas bertani (pemupukan/penyiraman) berdasarkan kondisi cuaca tersebut.

**Fokus API:** OpenWeatherMap API (Current & Forecast Data — free tier).

## 2. Filosofi Coding (PENTING — berlaku untuk SEMUA bagian)

Project ini dikerjakan mahasiswa semester awal. Prioritas kode:

1. **Sederhana di atas optimal.** Jangan pakai design pattern rumit, jangan over-engineer. Kalau bisa diselesaikan dengan if-else biasa, jangan dipaksa pakai Strategy Pattern atau sejenisnya.
2. **Mudah dibaca orang yang belum jago.** Penamaan variabel/fungsi harus jelas dan deskriptif (`$suhuMaksimal`, bukan `$tmax`). Hindari one-liner yang padat tapi susah dibaca.
3. **Mudah di-refactor.** Pisahkan logic dari Controller — taruh di **Service class**. Controller cuma manggil service, ngatur response. Ini bikin tiap bagian gampang diganti/ditest tanpa bongkar bagian lain.
4. **Komentar di bagian yang nggak jelas-jelas aja.** Nggak perlu komentar di tiap baris, tapi kasih komentar singkat di bagian logic yang butuh penjelasan (misal: kenapa threshold suhu segini).
5. **Konsisten antar mahasiswa.** Pakai format data yang sudah disepakati antar bagian (lihat kontrak data di tiap file mahasiswa) supaya nggak ada masalah integrasi di akhir.

## 3. Struktur Folder yang Disarankan

```
app/
  Http/Controllers/
    LahanController.php       (Mhs 1)
    AuthController.php        (Mhs 1, atau pakai Laravel Breeze)
  Services/
    WeatherService.php        (Mhs 2)
    RecommendationService.php (Mhs 3)
  Models/
    User.php                  (Mhs 1)
    Lahan.php                 (Mhs 1)
database/migrations/
  ..._create_lahans_table.php (Mhs 1)
resources/views/
  lahan/...                   (Mhs 1)
  cuaca/...                   (Mhs 2)
  rekomendasi/...             (Mhs 3)
```

## 4. Pembagian Tugas (3 Mahasiswa)

| Siapa | Tugas | File detail |
|---|---|---|
| Mhs 1 | Auth + Manajemen Lahan Petani (luas lahan, komoditas padi/jagung) | `mahasiswa1.md` |
| Mhs 2 | Integrasi OpenWeatherMap API berdasarkan kota input petani | `mahasiswa2.md` |
| Mhs 3 | Logika rekomendasi sederhana (hujan → tunda pemupukan, panas → siram) | `mahasiswa3.md` |

## 5. Kontrak Data Antar Bagian (WAJIB DISEPAKATI BARENG)

Supaya integrasi di akhir nggak ribet, semua sepakat pakai format ini:

**Dari Mhs 1 → dipakai Mhs 2 & Mhs 3:**
```php
// Data lahan petani
[
    'kota' => 'Purwakarta',
    'komoditas' => 'padi', // atau 'jagung'
    'luas_lahan' => 2.5,   // dalam hektar
]
```

**Dari Mhs 2 → dipakai Mhs 3:**
```php
// Array forecast 5 hari, sudah dikelompokkan per hari
[
    [
        'tanggal' => '2026-06-21',
        'suhu_min' => 24,
        'suhu_max' => 31,
        'kondisi' => 'hujan',      // 'hujan' | 'cerah' | 'berawan' | 'panas'
        'curah_hujan_mm' => 5.2,
    ],
    // ... 4 hari berikutnya
]
```

**Dari Mhs 3 → ditampilkan ke petani:**
```php
[
    'tanggal' => '2026-06-21',
    'rekomendasi' => 'Tunda pemupukan, kondisi hujan',
    'aksi' => 'tunda_pemupukan', // 'tunda_pemupukan' | 'siram' | 'pemupukan_normal' | 'tidak_ada'
]
```

## 6. Catatan Git

Tiap mahasiswa kerja di branch sendiri (`feat/auth-lahan`, `feat/weather-api`, `feat/rekomendasi`), merge ke `main`/`develop` setelah ditest. Hindari edit file yang sama bersamaan biar nggak conflict.
