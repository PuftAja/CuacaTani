# Arsitektur CuacaTani

## 1. Ringkasan

**CuacaTani** adalah sistem rekomendasi pertanian berbasis cuaca. Petani mengelola data lahannya, melihat prakiraan cuaca 5 hari, dan mendapat rekomendasi aktivitas (pemupukan/penyiraman) berdasarkan kondisi cuaca.

Dibangun dengan **Laravel 13 + Blade + Tailwind CSS**. Tiga mahasiswa mengerjakan secara paralel di branch terpisah.

---

## 2. Tech Stack

| Layer          | Teknologi                    |
|----------------|------------------------------|
| Backend        | PHP 8.3+, Laravel 13        |
| Frontend       | Blade, Tailwind CSS, Alpine.js |
| Database       | SQLite (dev) / MySQL (prod)  |
| Build tool     | Vite + Laravel Vite Plugin   |
| Auth           | Laravel Breeze               |
| CSS            | Tailwind CSS 3, `@tailwindcss/forms` |
| Weather API    | OpenWeatherMap (free tier)   |
| Testing        | Pest PHP                     |

---

## 3. Struktur Direktori

```
CuacaTani/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                  # 9 Breeze auth controllers
│   │   │   ├── Controller.php
│   │   │   ├── LahanController.php    # Mhs 1 — CRUD lahan
│   │   │   └── ProfileController.php  # Breeze profile
│   │   └── Requests/
│   │       ├── Auth/                  # Auth form requests
│   │       └── ProfileUpdateRequest.php
│   ├── Models/
│   │   ├── User.php                   # Authenticatable, hasMany lahans
│   │   └── Lahan.php                  # BelongsTo user
│   ├── Providers/
│   │   └── AppServiceProvider.php     # (kosong — siap diisi binding service)
│   └── View/Components/
│       ├── AppLayout.php              # Layout logged-in
│       └── GuestLayout.php            # Layout guest
├── bootstrap/
├── config/
│   ├── app.php, auth.php, cache.php
│   ├── database.php                   # SQLite default, MySQL/MariaDB/PgSQL siap
│   ├── filesystems.php, logging.php
│   ├── mail.php, queue.php, services.php
│   └── session.php
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   └── 2026_06_20_135101_create_lahans_table.php
│   ├── factories/
│   └── seeders/
├── public/
├── resources/
│   ├── css/app.css                    # Tailwind directives
│   ├── js/app.js                      # Alpine.js bootstrap
│   └── views/
│       ├── auth/                      # Login, register, reset password
│       ├── components/                # Blade components
│       ├── layouts/
│       │   ├── app.blade.php          # Master layout logged-in
│       │   └── navigation.blade.php   # Navbar
│       ├── profile/                   # Edit profile
│       ├── lahan/                     # Mhs 1 — index, create, edit
│       ├── dashboard.blade.php        # Landing setelah login (cuaca + rekomendasi)
│       └── welcome.blade.php          # Halaman depan
├── routes/
│   ├── web.php                        # Route utama (lahan, profile, dashboard)
│   └── auth.php                       # Route auth (login, register, verifikasi)
├── tests/
├── agent.md                           # Konteks untuk AI coding assistant
├── mahasiswa1.md                      # Tugas Mhs 1
├── composer.json                      # Laravel 13, Breeze, Pest
├── package.json                       # Vite, Tailwind, Alpine
└── tailwind.config.js                 # Content paths + forms plugin
```

---

## 4. Arsitektur MVC

```
HTTP Request → routes/web.php
                  │
                  ▼
         Middleware (auth, verified, guest)
                  │
                  ▼
         Controller (LahanController, ProfileController, Auth*)
                  │
                  ▼
         Service Layer (WeatherService, RecommendationService) — belum dibuat
                  │
                  ▼
         Model (Eloquent: User, Lahan)
                  │
                  ▼
         Database (SQLite/MySQL)
                  │
                  ▼
         View (Blade: layouts, lahan/*, dashboard, auth/*)
                  │
                  ▼
         Response (HTML)
```

### Alur Khusus per Modul

**Auth** (`routes/auth.php`) → Breeze `RegisteredUserController`, `AuthenticatedSessionController`, dll → View Blade `auth/*`.

**Lahan CRUD** (Mhs 1) → `LahanController` → validasi langsung di controller → `Lahan::create/update/delete` → redirect dengan session flash.

**Cuaca** (Mhs 2, belum diimplementasi) → `WeatherService` → panggil OpenWeatherMap API → kembalikan array forecast (format kontrak data).

**Rekomendasi** (Mhs 3, belum diimplementasi) → `RecommendationService` → terima data forecast + komoditas → logic if-else threshold → kembalikan array rekomendasi.

---

## 5. Database Schema

### Tabel `users`
| Kolom              | Tipe          | Keterangan                |
|--------------------|---------------|---------------------------|
| id                 | bigint (PK)   | Auto-increment            |
| name               | string        | Nama petani               |
| email              | string (unik) | Email login               |
| email_verified_at  | timestamp?    | Verifikasi email          |
| password           | string        | Hashed                    |
| remember_token     | string?       | Session persistent        |
| timestamps         | —             | created_at, updated_at    |

### Tabel `lahans`
| Kolom       | Tipe            | Keterangan                          |
|-------------|-----------------|-------------------------------------|
| id          | bigint (PK)     | Auto-increment                      |
| user_id     | bigint (FK)     | → users.id (pemilik)                |
| kota        | string(255)     | Nama kota (parameter API cuaca)     |
| komoditas   | enum('padi','jagung') | Jenis tanaman               |
| luas_lahan  | decimal(8,2)    | Hektar                              |
| timestamps  | —               | created_at, updated_at              |

### Relasi
```
User (1) ──→ Lahan (N)   (hasMany / belongsTo)
```

---

## 6. Route Design

### Auth (`/routes/auth.php`) — middleware `guest` atau `auth`
| Method   | URI                          | Controller Action               | Nama               |
|----------|------------------------------|----------------------------------|--------------------|
| GET      | /register                    | RegisteredUserController@create  | register           |
| POST     | /register                    | RegisteredUserController@store   | —                  |
| GET      | /login                       | AuthenticatedSessionController@create | login          |
| POST     | /login                       | AuthenticatedSessionController@store | —              |
| POST     | /logout                      | AuthenticatedSessionController@destroy | logout         |
| GET/POST | /forgot-password             | PasswordResetLinkController      | password.request   |
| GET/POST | /reset-password/{token}      | NewPasswordController            | password.reset     |
| GET      | /verify-email                | EmailVerificationPromptController | verification.notice |
| GET      | /verify-email/{id}/{hash}    | VerifyEmailController            | verification.verify |
| POST     | /email/verification-notification | EmailVerificationNotificationController@store | — |
| GET/POST | /confirm-password            | ConfirmablePasswordController    | password.confirm   |
| PUT      | /password                    | PasswordController@update        | password.update    |

### Web (`/routes/web.php`) — middleware `auth`
| Method   | URI            | Controller Action             | Nama             |
|----------|----------------|-------------------------------|------------------|
| GET      | /              | Closure → welcome.blade       | —                |
| GET      | /dashboard     | Closure → dashboard.blade     | dashboard        |
| GET      | /profile       | ProfileController@edit        | profile.edit     |
| PATCH    | /profile       | ProfileController@update      | profile.update   |
| DELETE   | /profile       | ProfileController@destroy     | profile.destroy  |
| GET      | /lahan         | LahanController@index         | lahan.index      |
| GET      | /lahan/create  | LahanController@create        | lahan.create     |
| POST     | /lahan         | LahanController@store         | lahan.store      |
| GET      | /lahan/{lahan} | LahanController@show          | lahan.show       |
| GET      | /lahan/{lahan}/edit | LahanController@edit      | lahan.edit       |
| PUT/PATCH| /lahan/{lahan} | LahanController@update        | lahan.update     |
| DELETE   | /lahan/{lahan} | LahanController@destroy       | lahan.destroy    |

Semua route `/lahan*` menggunakan `Route::resource()` di dalam grup `auth`.

---

## 7. Kontrak Data (Integrasi)

Disepakati antar anggota tim (dari `agent.md`):

### Mhs 1 → Mhs 2 & Mhs 3
```php
[
    'kota'       => 'Purwakarta',
    'komoditas'  => 'padi',         // 'padi' | 'jagung'
    'luas_lahan' => 2.5,            // hektar
]
```

### Mhs 2 → Mhs 3 (array forecast per hari)
```php
[
    [
        'tanggal'        => '2026-06-21',
        'suhu_min'       => 24,
        'suhu_max'       => 31,
        'kondisi'        => 'hujan',  // 'hujan' | 'cerah' | 'berawan' | 'panas'
        'curah_hujan_mm' => 5.2,
    ],
    // ... 4 hari berikutnya
]
```

### Mhs 3 → View (rekomendasi per hari)
```php
[
    'tanggal'      => '2026-06-21',
    'rekomendasi'  => 'Tunda pemupukan, kondisi hujan',
    'aksi'         => 'tunda_pemupukan', // 'tunda_pemupukan' | 'siram' | 'pemupukan_normal' | 'tidak_ada'
]
```

---

## 8. UI / View Layer

### Layout
- `layouts/app.blade.php` — master layout (Figtree font, Vite assets, nav, header, slot)
- `layouts/navigation.blade.php` — navbar (Breeze default)
- `components/app-layout.php` — View Component untuk `layouts.app`
- `components/guest-layout.php` — View Component untuk halaman guest

### Halaman
| View                            | Keterangan                     |
|---------------------------------|--------------------------------|
| `welcome.blade.php`             | Landing page (sebelum login)   |
| `auth/login.blade.php`          | Form login                     |
| `auth/register.blade.php`       | Form register                  |
| `dashboard.blade.php`           | Beranda (cuaca + rekomendasi)  |
| `lahan/index.blade.php`         | Daftar lahan + tombol aksi     |
| `lahan/create.blade.php`        | Form tambah lahan              |
| `lahan/edit.blade.php`          | Form edit lahan                |
| `profile/edit.blade.php`        | Edit profil + hapus akun       |

### Styling
- Tailwind CSS via CDN directives di `resources/css/app.css`
- Dashboard memiliki CSS blocks `<style>` untuk gradient cards, weather card, forecast grid, stat cards
- Komponen menggunakan Blade `x-*` (AppLayout)

---

## 9. Alur Data End-to-End (Setelah Semua Selesai)

```
Petani login
  → Dashboard: ambil daftar lahan milik petani
    → Untuk setiap lahan:
      → WeatherService::getForecast($kota) — panggil OpenWeatherMap
      → RecommendationService::getRecommendations($forecast, $komoditas)
    → Tampilkan cuaca + rekomendasi di dashboard
```

---

## 10. Keamanan

- Auth: Laravel Breeze (password hashed, CSRF, session-based)
- Authorization di `LahanController`: setiap method mengecek `$lahan->user_id !== auth()->id()`, abort 403 jika bukan pemilik
- Validasi input: `required|in:padi,jagung`, `numeric|min:0.1`, `string|max:100`
- SQL injection: dicegah oleh Eloquent ORM (parameter binding)
- Mass assignment: `$fillable` di Model Lahan

---

## 11. Pengembangan & Branching

| Branch             | Pengerjaan            |
|--------------------|-----------------------|
| `main` / `develop` | Integrasi akhir       |
| `feat/auth-lahan`  | Mhs 1 (auth + lahan)  |
| `feat/weather-api` | Mhs 2 (OpenWeatherMap)|
| `feat/rekomendasi` | Mhs 3 (rekomendasi)   |

### Setup Dev
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
php artisan serve
```
