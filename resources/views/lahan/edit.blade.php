<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            ✏️ Edit Lahan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div style="background:white; border-radius:14px; box-shadow:0 2px 12px rgba(0,0,0,0.06); padding:2rem;">

                {{-- Error --}}
                @if ($errors->any())
                    <div style="margin-bottom:1.25rem; padding:0.75rem 1rem; background:#fef2f2; border:1px solid #fecaca; border-radius:10px; font-size:0.82rem; color:#dc2626;">
                        <ul style="list-style:none; margin:0; padding:0;">
                            @foreach ($errors->all() as $error)
                                <li style="padding:0.15rem 0;">⚠️ {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div style="text-align:center; margin-bottom:1.75rem;">
                    <div style="width:56px; height:56px; background:linear-gradient(135deg,#dbeafe,#bfdbfe); border-radius:16px; display:inline-flex; align-items:center; justify-content:center; font-size:1.75rem; margin-bottom:0.75rem;">{{ $lahan->komoditas === 'padi' ? '🌾' : '🌽' }}</div>
                    <h3 style="font-size:1.15rem; font-weight:700; color:#1e293b;">Edit {{ ucfirst($lahan->komoditas) }} — {{ $lahan->kota }}</h3>
                    <p style="font-size:0.82rem; color:#94a3b8; margin-top:0.2rem;">Perbarui data lahan Anda</p>
                </div>

                <form method="POST" action="{{ route('lahan.update', $lahan->id) }}">
                    @csrf
                    @method('PUT')

                    <div style="margin-bottom:1.25rem;">
                        <label style="display:block; font-size:0.82rem; font-weight:600; color:#334155; margin-bottom:0.4rem;">📍 Lokasi Kota</label>
                        <input type="text" name="kota" value="{{ old('kota', $lahan->kota) }}" required
                               placeholder="Contoh: Bandung, Purwakarta"
                               style="width:100%; padding:0.65rem 0.9rem; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.9rem; background:#f8fafc; outline:none; transition:all 0.2s; font-family:inherit;"
                               onfocus="this.style.borderColor='#22c55e'; this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(34,197,94,0.12)'"
                               onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'; this.style.boxShadow=''">
                    </div>

                    <div style="margin-bottom:1.25rem;">
                        <label style="display:block; font-size:0.82rem; font-weight:600; color:#334155; margin-bottom:0.4rem;">🌱 Jenis Komoditas</label>
                        <select name="komoditas" required
                                style="width:100%; padding:0.65rem 0.9rem; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.9rem; background:#f8fafc; outline:none; cursor:pointer; font-family:inherit; color:#334155;">
                            <option value="padi"   {{ old('komoditas', $lahan->komoditas) === 'padi'   ? 'selected' : '' }}>🌾 Padi</option>
                            <option value="jagung" {{ old('komoditas', $lahan->komoditas) === 'jagung' ? 'selected' : '' }}>🌽 Jagung</option>
                        </select>
                    </div>

                    <div style="margin-bottom:1.75rem;">
                        <label style="display:block; font-size:0.82rem; font-weight:600; color:#334155; margin-bottom:0.4rem;">📐 Luas Lahan (Hektar)</label>
                        <input type="number" name="luas_lahan" value="{{ old('luas_lahan', $lahan->luas_lahan) }}"
                               step="0.01" min="0.1" required
                               placeholder="Contoh: 2.50"
                               style="width:100%; padding:0.65rem 0.9rem; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.9rem; background:#f8fafc; outline:none; transition:all 0.2s; font-family:inherit;"
                               onfocus="this.style.borderColor='#22c55e'; this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(34,197,94,0.12)'"
                               onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'; this.style.boxShadow=''">
                    </div>

                    <div style="display:flex; gap:0.75rem;">
                        <button type="submit" style="flex:1; padding:0.7rem; border:none; border-radius:10px; background:linear-gradient(135deg,#22c55e,#16a34a); color:white; font-size:0.875rem; font-weight:600; cursor:pointer; box-shadow:0 4px 14px rgba(22,163,74,0.25); transition:all 0.2s; font-family:inherit;">
                            ✅ Update
                        </button>
                        <a href="{{ route('lahan.index') }}" style="padding:0.7rem 1.25rem; border:1.5px solid #e2e8f0; border-radius:10px; color:#64748b; font-size:0.875rem; font-weight:500; text-decoration:none; background:white; transition:all 0.2s; text-align:center;">
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
