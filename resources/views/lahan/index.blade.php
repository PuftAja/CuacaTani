<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            📋 Data Lahan Saya
        </h2>
    </x-slot>

    <style>
        /* Dynamic variant classes */
        .accent-padi { background: linear-gradient(90deg, #22c55e, #15803d); }
        .accent-jagung { background: linear-gradient(90deg, #f59e0b, #d97706); }
        .badge-padi { background: #dcfce7; color: #166534; }
        .badge-jagung { background: #fef3c7; color: #92400e; }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Pesan sukses --}}
                @if (session('success'))
                    <div style="margin-bottom:1rem; padding:0.75rem 1rem; background:#dcfce7; color:#166534; border-radius:10px; font-size:0.875rem; display:flex; align-items:center; gap:0.5rem;">
                        ✅ {{ session('success') }}
                    </div>
                @endif

                {{-- Header --}}
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; flex-wrap:wrap; gap:0.75rem;">
                    <div>
                        <h3 style="font-size:1.1rem; font-weight:700; color:#1e293b;">Daftar Lahan</h3>
                        <p style="font-size:0.82rem; color:#94a3b8; margin-top:0.15rem;">Kelola data lahan pertanian Anda</p>
                    </div>
                    <a href="{{ route('lahan.create') }}" style="display:inline-flex; align-items:center; gap:0.4rem; background:linear-gradient(135deg,#22c55e,#16a34a); color:white; padding:0.6rem 1.25rem; border-radius:10px; font-size:0.85rem; font-weight:600; text-decoration:none; box-shadow:0 4px 14px rgba(22,163,74,0.25); transition:all 0.2s;">
                        ➕ Tambah Lahan
                    </a>
                </div>

                @if ($lahans->isEmpty())
                    {{-- Empty state --}}
                    <div style="text-align:center; padding:3rem 1rem;">
                        <div style="font-size:3.5rem; margin-bottom:1rem;">🌱</div>
                        <h3 style="font-size:1.1rem; font-weight:600; color:#334155; margin-bottom:0.5rem;">Belum Ada Lahan</h3>
                        <p style="color:#94a3b8; font-size:0.875rem; margin-bottom:1.5rem; max-width:320px; margin-left:auto; margin-right:auto;">
                            Mulai dengan mendaftarkan lahan pertama Anda untuk mendapatkan rekomendasi tanam.
                        </p>
                        <a href="{{ route('lahan.create') }}" style="display:inline-flex; align-items:center; gap:0.4rem; background:linear-gradient(135deg,#22c55e,#16a34a); color:white; padding:0.6rem 1.5rem; border-radius:10px; font-size:0.85rem; font-weight:600; text-decoration:none; box-shadow:0 4px 14px rgba(22,163,74,0.25);">
                            ➕ Tambah Lahan Pertama
                        </a>
                    </div>
                @else
                    {{-- Cards grid --}}
                    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(300px, 1fr)); gap:1rem;">
                        @foreach ($lahans as $lahan)
                        <div style="background:white; border:1px solid #e2e8f0; border-radius:12px; padding:1.25rem; transition:all 0.2s; position:relative; overflow:hidden;"
                             onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.08)'"
                             onmouseout="this.style.transform=''; this.style.boxShadow=''">
                            {{-- Accent bar --}}
                            <div style="position:absolute; top:0; left:0; right:0; height:3px;" class="accent-{{ $lahan->komoditas }}"></div>

                            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                                <div>
                                    <div style="font-size:2rem; margin-bottom:0.5rem;">{{ $lahan->komoditas === 'padi' ? '🌾' : '🌽' }}</div>
                                    <div style="font-size:1.05rem; font-weight:700; color:#1e293b;">{{ ucfirst($lahan->komoditas) }}</div>
                                    <div style="font-size:0.82rem; color:#64748b; margin-top:0.2rem;">📍 {{ $lahan->kota }}</div>
                                </div>
                                <span style="font-size:0.75rem; padding:0.2rem 0.6rem; border-radius:9999px; font-weight:600;" class="badge-{{ $lahan->komoditas }}">
                                    {{ $lahan->komoditas === 'padi' ? 'Padi' : 'Jagung' }}
                                </span>
                            </div>

                            <div style="margin-top:1rem; padding-top:0.75rem; border-top:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center;">
                                <div>
                                    <div style="font-size:0.72rem; color:#94a3b8; text-transform:uppercase; letter-spacing:0.05em;">Luas Lahan</div>
                                    <div style="font-size:1.1rem; font-weight:700; color:#1e293b;">{{ $lahan->luas_lahan }} <span style="font-size:0.75rem; font-weight:400; color:#94a3b8;">Ha</span></div>
                                </div>
                                <div style="display:flex; gap:0.4rem;">
                                    <a href="{{ route('lahan.edit', $lahan->id) }}" style="padding:0.4rem 0.8rem; font-size:0.78rem; font-weight:500; color:#0ea5e9; background:#f0f9ff; border:1px solid #bae6fd; border-radius:8px; text-decoration:none; transition:all 0.15s;">
                                        ✏️ Edit
                                    </a>
                                    <form action="{{ route('lahan.destroy', $lahan->id) }}" method="POST" style="display:inline;"
                                          onsubmit="return confirm('Yakin hapus lahan ini? Data tidak dapat dikembalikan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="padding:0.4rem 0.8rem; font-size:0.78rem; font-weight:500; color:#ef4444; background:#fef2f2; border:1px solid #fecaca; border-radius:8px; cursor:pointer; transition:all 0.15s;">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
