# Mahasiswa 1 — Auth & Manajemen Lahan Petani

> Baca `agent.md` dulu untuk konteks umum project dan filosofi coding.

## Tugas Kamu

1. Sistem login/register untuk petani (Auth).
2. CRUD data lahan: luas lahan + komoditas (padi/jagung) + kota (buat dipakai Mhs 2 ambil data cuaca).

## Kenapa Ini Penting Buat Bagian Lain

Data **kota** dan **komoditas** yang kamu simpan di sini akan dipakai langsung sama Mhs 2 (buat fetch cuaca) dan Mhs 3 (buat nentuin rekomendasi). Jadi pastikan nama kolom dan format datanya konsisten sama yang ditulis di `agent.md` bagian "Kontrak Data".

## Saran Pengerjaan (Step by Step)

### 1. Auth
Paling gampang: pakai **Laravel Breeze** (`composer require laravel/breeze --dev` lalu `php artisan breeze:install`). Ini udah nyediain login/register/logout siap pakai, kamu nggak perlu nulis dari nol. Lebih simple dan lebih kecil kemungkinan ada bug keamanan.

### 2. Migration untuk tabel `lahans`

```php
Schema::create('lahans', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained(); // pemilik lahan
    $table->string('kota');              // dipakai Mhs 2
    $table->enum('komoditas', ['padi', 'jagung']); // dipakai Mhs 3
    $table->decimal('luas_lahan', 8, 2); // dalam hektar
    $table->timestamps();
});
```

### 3. Model `Lahan.php`

```php
class Lahan extends Model
{
    protected $fillable = ['user_id', 'kota', 'komoditas', 'luas_lahan'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

### 4. Controller `LahanController.php`

Bikin CRUD standar: `index`, `create`, `store`, `edit`, `update`, `destroy`. Karena ini cuma data sederhana, **nggak perlu Service class** di bagian ini — controller langsung manggil Model itu sudah cukup rapi.

```php
public function store(Request $request)
{
    $validated = $request->validate([
        'kota' => 'required|string|max:100',
        'komoditas' => 'required|in:padi,jagung',
        'luas_lahan' => 'required|numeric|min:0.1',
    ]);

    $validated['user_id'] = auth()->id();

    Lahan::create($validated);

    return redirect()->route('lahan.index')->with('success', 'Lahan berhasil ditambahkan');
}
```

### 5. View

Form sederhana pakai Blade: input teks untuk kota, dropdown untuk komoditas (padi/jagung), input angka untuk luas lahan. Nggak perlu styling fancy dulu, fokus fungsi jalan dulu.

## Checklist Selesai

- [ ] Petani bisa register & login
- [ ] Petani bisa tambah/edit/hapus data lahan (kota, komoditas, luas)
- [ ] Validasi input jalan (komoditas cuma padi/jagung, luas lahan harus angka positif)
- [ ] Data lahan bisa diakses lewat `auth()->user()->lahans` (kasih relasi `hasMany` di Model `User`)

## Hal yang JANGAN Dilakukan

- Jangan bikin sistem role/permission yang kompleks — petani cuma satu jenis user.
- Jangan simpan kota sebagai dropdown/relasi tabel kota terpisah — cukup `string` biasa, biar simple buat Mhs 2 langsung pakai sebagai parameter API.
