# Mhs 3 — Sistem Logika Rekomendasi Sederhana (If-Else)

## Tugas

Membangun sistem rekomendasi aktivitas bertani berbasis if-else berdasarkan:
- **Suhu maksimum** & **suhu minimum** dari prakiraan cuaca
- **Kondisi cuaca** (hujan, cerah, berawan, dll)
- **Jenis komoditas** (padi / jagung — masing-masing punya threshold suhu berbeda)

---

## Logika If-Else (4 Kondisi)

```
                      ┌─────────────────────────┐
                      │  Input: suhu_max,       │
                      │  suhu_min, kondisi,     │
                      │  komoditas              │
                      └────────┬────────────────┘
                               │
                    ┌──────────▼──────────┐
                    │  Kondisi "hujan"    │
                    │  atau "petir"?      │──── Ya ──> Tunda Pemupukan
                    └──────────┬──────────┘
                               │ Tidak
                               │
                    ┌──────────▼──────────┐
                    │  suhu_max >=         │
                    │  threshold.panas?    │──── Ya ──> Siram (tingkatkan frekuensi)
                    └──────────┬──────────┘
                               │ Tidak
                               │
                    ┌──────────▼──────────┐
                    │  suhu_min <=         │
                    │  threshold.dingin?   │──── Ya ──> Lindungi Tanaman
                    └──────────┬──────────┘
                               │ Tidak
                               │
                    ┌──────────▼──────────┐
                    │  Kondisi "cerah"    │
                    │  atau "berawan"?    │──── Ya ──> Pemupukan Normal
                    └──────────┬──────────┘
                               │ Tidak
                               │
                    ┌──────────▼──────────┐
                    │  Default:           │
                    │  Tidak Ada Aksi     │
                    └─────────────────────┘
```

---

## File & Path

### Service

| File | Fungsi |
|---|---|
| `app/Services/RecommendationService.php` | **Service utama** — semua logika rekomendasi di sini |

### Controller (Consumer)

| File | Fungsi |
|---|---|
| `app/Http/Controllers/DashboardController.php` | Inject `RecommendationService`, panggil `getRekomendasi($prakiraan, $komoditas)` |

### View

| File | Fungsi |
|---|---|
| `resources/views/dashboard.blade.php` | Tampilkan daftar rekomendasi per hari dengan ikon + warna per aksi |

---

## Threshold Suhu per Komoditas

```php
protected array $threshold = [
    "padi"   => ["panas" => 32, "dingin" => 18],
    "jagung" => ["panas" => 35, "dingin" => 15],
];
```

| Komoditas | Panas (> threshold) | Dingin (< threshold) |
|---|---|---|
| Padi | ≥ 32°C → siram | ≤ 18°C → lindungi |
| Jagung | ≥ 35°C → siram | ≤ 15°C → lindungi |

---

## Output 4 Jenis Aksi

| Aksi | Kondisi | Ikon | Warna Border |
|---|---|---|---|
| `siram` | Suhu ≥ threshold panas | 💧 | Biru (`#0ea5e9`) |
| `tunda_pemupukan` | Hujan / Petir | ⛔ | Merah (`#ef4444`) |
| `pemupukan_normal` | Cerah / Berawan | ✅ | Hijau (`#16a34a`) |
| `lindungi_tanaman` | Suhu ≤ threshold dingin | 🛡️ | Ungu (`#8b5cf6`) |
| `tidak_ada` | Default | 📋 | Abu (`#9ca3af`) |

---

## Method Penting

### `getRekomendasi(array $prakiraan, string $komoditas): array`

Iterasi setiap hari dari prakiraan, panggil `tentukanRekomendasi()` untuk masing-masing hari.

**Output:**
```php
[
    [
        'tanggal'      => '2026-07-08',
        'rekomendasi'  => 'Hujan diprediksi hari ini. Tunda pemupukan agar pupuk tidak larut...',
        'aksi'         => 'tunda_pemupukan',
        'ikon'         => '⛔',
    ],
    ...
]
```

### `tentukanRekomendasi(float $suhuMax, float $suhuMin, string $kondisi, string $komoditas): array`

Logika if-else utama (4 kondisi + default). Detail di diagram di atas.

---

## Integrasi dengan Dashboard

`DashboardController@index`:

```php
// 1. Ambil lahan milik petani
$lahans = auth()->user()->lahans;

// 2. Tentukan kota & komoditas dari lahan (atau default)
$kota = $lahanAktif->kota;
$komoditas = $lahanAktif->komoditas;

// 3. Ambil cuaca (Mhs 2)
$prakiraan = $this->weather->getForecast($kota);

// 4. Generate rekomendasi (Mhs 3)
$rekomendasi = $this->recommendation->getRekomendasi($prakiraan, $komoditas);

// 5. Kirim ke view
return view('dashboard', compact('rekomendasi', ...));
```

---

## Implementasi Class CSS per Aksi

Di view `dashboard.blade.php`, setiap kartu rekomendasi dikasih class dinamis:

```blade
<div class="rec-card step-{{ $rec['aksi'] }}">
    <div class="rec-number step-number-{{ $rec['aksi'] }}">
        {{ $rec['ikon'] }}
    </div>
    ...
</div>
```

CSS:

```css
.step-siram            { border-left: 4px solid #0ea5e9; }
.step-tunda_pemupukan  { border-left: 4px solid #ef4444; }
.step-pemupukan_normal { border-left: 4px solid #16a34a; }
.step-lindungi_tanaman { border-left: 4px solid #8b5cf6; }
```
