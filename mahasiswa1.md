# Mhs 1 — Auth & Manajemen Lahan Petani

## Tugas

1. **Sistem Autentikasi** — Register, Login, Logout menggunakan Laravel Breeze
2. **Manajemen Lahan Petani** — CRUD (Create, Read, Update, Delete) data lahan dengan field:
   - `kota` — lokasi lahan (string)
   - `komoditas` — jenis tanaman (padi / jagung)
   - `luas_lahan` — luas dalam hektar (numeric)

---

## Relasi & Alur Data

```
User (petani) ──hasMany──> Lahan
```

- Satu petani bisa punya banyak lahan.
- Setiap lahan hanya dimiliki satu petani (foreign key `user_id`).
- Semua operasi CRUD dicek kepemilikan: petani hanya bisa edit/hapus lahannya sendiri.

---

## File & Path

### Model

| File | Fungsi |
|---|---|
| `app/Models/User.php` | Model User bawaan Laravel — relasi `lahans()` didefinisikan di sini |
| `app/Models/Lahan.php` | Model Lahan — `$fillable = ['user_id','kota','komoditas','luas_lahan']`, relasi `belongsTo User` |

### Controller

| File | Fungsi |
|---|---|
| `app/Http/Controllers/Auth/RegisteredUserController.php` | Proses registrasi akun baru |
| `app/Http/Controllers/Auth/AuthenticatedSessionController.php` | Proses login & logout |
| `app/Http/Controllers/LahanController.php` | CRUD lahan — `index()`, `create()`, `store()`, `edit()`, `update()`, `destroy()` |

### View (Blade)

| File | Fungsi |
|---|---|
| `resources/views/auth/register.blade.php` | Form register (nama, email, password) |
| `resources/views/auth/login.blade.php` | Form login (email, password, remember me) |
| `resources/views/lahan/index.blade.php` | Daftar semua lahan milik petani yang login |
| `resources/views/lahan/create.blade.php` | Form tambah lahan baru |
| `resources/views/lahan/edit.blade.php` | Form edit lahan yang sudah ada |
| `resources/views/layouts/guest.blade.php` | Layout guest (hero + navbar + form card) untuk halaman auth |
| `resources/views/layouts/app.blade.php` | Layout utama setelah login (navbar glass + konten) |

### Route

| File | Fungsi |
|---|---|
| `routes/web.php` | Route `/dashboard`, route resource `lahan` (semua pakai middleware `auth`) |
| `routes/auth.php` | Route auth (login, register, logout, dll) — otomatis dari Breeze |

---

## Detail CRUD Lahan

### Validasi (`store` & `update`)

```php
$request->validate([
    'kota'       => 'required|string|max:100',
    'komoditas'  => 'required|in:padi,jagung',
    'luas_lahan' => 'required|numeric|min:0.1',
]);
```

### Authorization

```php
// Setiap method edit/update/destroy cek:
if ($lahan->user_id !== auth()->id()) {
    abort(403);
}
```

---

## Alur Lengkap

1. User buka `/` → landing page
2. Klik "Daftar" → `register.blade.php` → `RegisteredUserController` → login otomatis
3. Redirect ke `/dashboard` → lihat cuaca & rekomendasi (dari Mhs 2 & Mhs 3)
4. Klik "Data Lahan" → `lahan/index.blade.php` → lihat semua lahan
5. Klik "Tambah Lahan" → `lahan/create.blade.php` → isi kota + komoditas + luas → `store()`
6. Klik Edit → `lahan/edit.blade.php` → ubah data → `update()`
7. Klik Hapus → `destroy()` → redirect ke index
