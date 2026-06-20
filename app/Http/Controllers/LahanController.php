<?php

namespace App\Http\Controllers;

use App\Models\Lahan;
use Illuminate\Http\Request;

class LahanController extends Controller
{
    /**
     * Tampilkan daftar lahan milik petani yang sedang login.
     */
    public function index()
    {
        $lahans = auth()->user()->lahans;
        return view('lahan.index', compact('lahans'));
    }

    /**
     * Redirect ke halaman edit (halaman detail terpisah tidak diperlukan).
     */
    public function show(Lahan $lahan)
    {
        if ($lahan->user_id !== auth()->id()) {
            abort(403);
        }

        return redirect()->route('lahan.edit', $lahan->id);
    }

    /**
     * Tampilkan form tambah lahan baru.
     */
    public function create()
    {
        return view('lahan.create');
    }

    /**
     * Simpan lahan baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input:
        // - kota: string bebas, karena dipakai langsung sebagai parameter API cuaca oleh Mhs 2
        // - komoditas: hanya boleh 'padi' atau 'jagung', sesuai kontrak dengan Mhs 3
        // - luas_lahan: angka positif dalam satuan hektar
        $validated = $request->validate([
            'kota'       => 'required|string|max:100',
            'komoditas'  => 'required|in:padi,jagung',
            'luas_lahan' => 'required|numeric|min:0.1',
        ]);

        $validated['user_id'] = auth()->id();

        Lahan::create($validated);

        return redirect()->route('lahan.index')->with('success', 'Lahan berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit lahan.
     * Pastikan hanya pemilik lahan yang bisa mengaksesnya.
     */
    public function edit(Lahan $lahan)
    {
        // Cegah petani lain mengakses lahan yang bukan miliknya
        if ($lahan->user_id !== auth()->id()) {
            abort(403);
        }

        return view('lahan.edit', compact('lahan'));
    }

    /**
     * Simpan perubahan data lahan.
     */
    public function update(Request $request, Lahan $lahan)
    {
        if ($lahan->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'kota'       => 'required|string|max:100',
            'komoditas'  => 'required|in:padi,jagung',
            'luas_lahan' => 'required|numeric|min:0.1',
        ]);

        $lahan->update($validated);

        return redirect()->route('lahan.index')->with('success', 'Lahan berhasil diperbarui.');
    }

    /**
     * Hapus data lahan.
     */
    public function destroy(Lahan $lahan)
    {
        if ($lahan->user_id !== auth()->id()) {
            abort(403);
        }

        $lahan->delete();

        return redirect()->route('lahan.index')->with('success', 'Lahan berhasil dihapus.');
    }
}
