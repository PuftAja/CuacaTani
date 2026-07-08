# Mhs 2 — Integrasi OpenWeatherMap API

## Tugas

1. **Mengambil data cuaca terkini** (suhu, kelembaban, angin, curah hujan) dari OpenWeatherMap berdasarkan nama kota.
2. **Mengambil prakiraan 5 hari ke depan** (suhu min/max, kondisi cuaca) dari OpenWeatherMap.
3. **Fallback dummy data** ketika API key tidak tersedia atau koneksi gagal, sehingga aplikasi tetap bisa dijalankan.

---

## Alur Data

```
Input kota (dari Lahan petani)
         ↓
  WeatherService
         ↓
  ┌── API Key ada? ──> Http::get("api.openweathermap.org/...") ──> Parse JSON
  └── Tidak ada ──> getDummyCurrentWeather() / getDummyForecast()
         ↓
  Format array konsisten ([suhu, kondisi, ikon, kelembaban, ...])
         ↓
  DashboardController → view dashboard.blade.php
```

---

## File & Path

### Service

| File | Fungsi |
|---|---|
| `app/Services/WeatherService.php` | **Service utama** — semua logika API cuaca di sini |

### Controller (Consumer)

| File | Fungsi |
|---|---|
| `app/Http/Controllers/DashboardController.php` | Inject `WeatherService`, panggil `getCurrentWeather()` + `getForecast()` per kota |

### View

| File | Fungsi |
|---|---|
| `resources/views/dashboard.blade.php` | Tampilkan cuaca terkini + prakiraan 5 hari |
| `resources/views/welcome.blade.php` | Tampilkan preview cuaca di landing page (dummy) |

### Config

| File | Fungsi |
|---|---|
| `config/services.php` | Definisikan `services.openweather.key` dan `services.openweather.url` |
| `.env` | Simpan API key: `OPENWEATHER_API_KEY=...` |

### Route

| File | Fungsi |
|---|---|
| `routes/web.php` | Route `/dashboard` → `DashboardController@index` |

---

## Method Penting di WeatherService

### `getCurrentWeather(string $kota): array`

```php
Http::timeout(5)->get("{$this->baseUrl}/weather", [
    "q"     => $kota,
    "appid" => $this->apiKey,
    "units" => "metric",
    "lang"  => "id",
]);
```

**Output:**
```
['suhu' => 27, 'kondisi' => 'Berawan Sebagian', 'ikon' => '⛅',
 'kelembaban' => 72, 'angin' => 14, 'curah_hujan' => 0,
 'terasa_seperti' => 29, 'kota' => 'Bandung']
```

### `getForecast(string $kota): array`

```php
Http::timeout(5)->get("{$this->baseUrl}/forecast", [
    "q"     => $kota,
    "appid" => $this->apiKey,
    "units" => "metric",
    "lang"  => "id",
    "cnt"   => 40,
]);
```

Data 40 titik (8 per hari × 5 hari) dikelompokkan per tanggal via `groupByDate()`, lalu diambil suhu min/max.

**Output:**
```
[['hari' => 'Hari Ini', 'ikon' => '⛅', 'suhu_max' => 28, 'suhu_min' => 22, 'kondisi' => 'Berawan'], ...]
```

### Helper Methods

| Method | Fungsi |
|---|---|
| `groupByDate(array $list)` | Kelompokkan 40 data forecast per tanggal |
| `dominantCondition(array $items)` | Cari kondisi cuaca paling sering muncul dalam satu hari |
| `dominantIcon(array $items)` | Ambil icon code paling sering (untuk day/night detection) |
| `mapWeatherIcon(string $main, string $iconCode)` | Peta `main` OWM ke emoji; cek suffix `n` untuk malam 🌙 |
| `mapConditionLabel(string $main)` | Peta `main` OWM ke label Bahasa Indonesia |
| `rainFromCurrent(array $data)` | Ambil curah hujan dari field `rain.1h` atau `rain.3h` |

### Day/Night Detection

```php
$isNight = str_ends_with($iconCode, "n");
return match (strtolower($main)) {
    "clear" => $isNight ? "🌙" : "☀️",
    "clouds" => $isNight ? "☁️" : "⛅",
    ...
};
```

---

## Dummy Data (Fallback)

Ketika `API key kosong` atau `HTTP request gagal`:

- `getDummyCurrentWeather()` → suhu 27°C, kondisi "Berawan Sebagian"
- `getDummyForecast()` → 5 hari dengan variasi cuaca (cerah, hujan ringan, hujan lebat)

Sehingga aplikasi tetap bisa dijalankan dan dikembangkan tanpa API key.

---

## Error Handling

```php
try {
    $response = Http::timeout(5)->get(...);
    if ($response->failed()) {
        Log::warning("Weather API gagal: {$response->status()}");
        return $this->getDummyCurrentWeather($kota);
    }
    // parse sukses...
} catch (\Throwable $e) {
    Log::error("Weather API error: {$e->getMessage()}");
    return $this->getDummyCurrentWeather($kota);
}
```

Semua error di-log via `Log::warning` / `Log::error` dan tetap mengembalikan array dengan format yang sama.
