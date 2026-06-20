<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Tambah Lahan Baru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Tampilkan pesan error validasi jika ada --}}
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('lahan.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="kota">Kota</label><br>
                        {{-- Nama kota diisi bebas karena dipakai langsung sebagai parameter API cuaca --}}
                        <input id="kota" type="text" name="kota" value="{{ old('kota') }}"
                               placeholder="Contoh: Bandung" style="width:100%; padding:6px; margin-top:4px;">
                    </div>

                    <div class="mb-4">
                        <label for="komoditas">Komoditas</label><br>
                        <select id="komoditas" name="komoditas" style="width:100%; padding:6px; margin-top:4px;">
                            <option value="">-- Pilih Komoditas --</option>
                            <option value="padi"   {{ old('komoditas') === 'padi'   ? 'selected' : '' }}>Padi</option>
                            <option value="jagung" {{ old('komoditas') === 'jagung' ? 'selected' : '' }}>Jagung</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="luas_lahan">Luas Lahan (Hektar)</label><br>
                        <input id="luas_lahan" type="number" name="luas_lahan" value="{{ old('luas_lahan') }}"
                               step="0.01" min="0.1" placeholder="Contoh: 2.50"
                               style="width:100%; padding:6px; margin-top:4px;">
                    </div>

                    <button type="submit" style="padding:8px 16px; background:#2563EB; color:#fff; border:none; border-radius:4px; cursor:pointer;">
                        Simpan
                    </button>
                    <a href="{{ route('lahan.index') }}" style="margin-left:12px;">Batal</a>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>