<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            🌾 Beranda
        </h2>
    </x-slot>

    {{-- Style khusus dashboard --}}
    <style>
        .hero-card {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 40%, #166534 100%);
            border-radius: 1rem;
            padding: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .hero-card::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.07);
            border-radius: 50%;
        }
        .hero-card::after {
            content: '';
            position: absolute;
            bottom: -80px;
            right: 80px;
            width: 280px;
            height: 280px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }
        .stat-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08), 0 4px 16px rgba(0,0,0,0.04);
            border: 1px solid #f0fdf4;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 0.75rem;
        }
        .step-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            border-left: 4px solid #16a34a;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }
        .step-number {
            width: 32px;
            height: 32px;
            background: #16a34a;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
            flex-shrink: 0;
        }
        .cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: white;
            color: #15803d;
            font-weight: 600;
            padding: 0.625rem 1.25rem;
            border-radius: 0.5rem;
            text-decoration: none;
            transition: background 0.2s, transform 0.2s;
            font-size: 0.9rem;
        }
        .cta-btn:hover {
            background: #f0fdf4;
            transform: translateY(-1px);
        }
        .cta-btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255,255,255,0.15);
            border: 2px solid rgba(255,255,255,0.5);
            color: white;
            font-weight: 600;
            padding: 0.625rem 1.25rem;
            border-radius: 0.5rem;
            text-decoration: none;
            transition: background 0.2s;
        }
        .cta-btn-outline:hover {
            background: rgba(255,255,255,0.25);
        }

        /* ── Cuaca ── */
        .weather-card {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 50%, #0369a1 100%);
            border-radius: 1rem;
            padding: 1.75rem;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .weather-card::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 220px; height: 220px;
            background: rgba(255,255,255,0.07);
            border-radius: 50%;
        }
        .weather-card::after {
            content: '';
            position: absolute;
            bottom: -80px; left: 60px;
            width: 200px; height: 200px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }
        .weather-main {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1.5rem;
            position: relative;
            z-index: 1;
        }
        .weather-temp-area {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .weather-icon-big {
            font-size: 4rem;
            line-height: 1;
        }
        .weather-temp {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1;
        }
        .weather-temp sup {
            font-size: 1.5rem;
            font-weight: 600;
            vertical-align: super;
        }
        .weather-desc {
            font-size: 1rem;
            opacity: 0.9;
            margin-top: 0.25rem;
            font-weight: 500;
        }
        .weather-meta {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            text-align: right;
        }
        .weather-meta-item {
            font-size: 0.875rem;
            opacity: 0.9;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            justify-content: flex-end;
        }
        .weather-divider {
            border: none;
            border-top: 1px solid rgba(255,255,255,0.2);
            margin: 1.25rem 0;
            position: relative;
            z-index: 1;
        }
        .forecast-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 0.75rem;
            position: relative;
            z-index: 1;
        }
        @media (max-width: 640px) {
            .forecast-grid { grid-template-columns: repeat(3, 1fr); }
        }
        .forecast-item {
            background: rgba(255,255,255,0.15);
            border-radius: 0.625rem;
            padding: 0.75rem 0.5rem;
            text-align: center;
            backdrop-filter: blur(4px);
            transition: background 0.2s;
        }
        .forecast-item:hover {
            background: rgba(255,255,255,0.25);
        }
        .forecast-item.today {
            background: rgba(255,255,255,0.25);
            border: 1px solid rgba(255,255,255,0.4);
        }
        .forecast-day {
            font-size: 0.75rem;
            font-weight: 600;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .forecast-icon {
            font-size: 1.5rem;
            margin: 0.35rem 0;
        }
        .forecast-temp-high {
            font-size: 0.9rem;
            font-weight: 700;
        }
        .forecast-temp-low {
            font-size: 0.78rem;
            opacity: 0.7;
        }
        .forecast-label {
            font-size: 0.7rem;
            opacity: 0.8;
            margin-top: 0.2rem;
        }
        .weather-source-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.72rem;
            background: rgba(255,255,255,0.18);
            border-radius: 9999px;
            padding: 0.2rem 0.6rem;
            margin-top: 0.6rem;
            opacity: 0.85;
        }
    </style>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ===== HERO / SAMBUTAN ===== --}}
            <div class="hero-card">
                <div style="position: relative; z-index: 1;">
                    <p style="font-size:0.875rem; opacity:0.8; margin-bottom:0.25rem;">Selamat datang,</p>
                    <h1 style="font-size:1.75rem; font-weight:700; margin-bottom:0.5rem;">
                        {{ Auth::user()->name }} 👋
                    </h1>
                    <p style="opacity:0.9; max-width:480px; margin-bottom:1.5rem; line-height:1.6;">
                        Kelola lahan pertanian Anda dengan mudah. Pantau data lahan dan dapatkan rekomendasi
                        tanam terbaik berdasarkan cuaca terkini.
                    </p>
                    <div style="display:flex; gap:0.75rem; flex-wrap:wrap;">
                        <a href="{{ route('lahan.index') }}" class="cta-btn">
                            📋 Lihat Data Lahan
                        </a>
                        <a href="{{ route('lahan.create') }}" class="cta-btn-outline">
                            ➕ Tambah Lahan Baru
                        </a>
                    </div>
                </div>
            </div>

            {{-- ===== STATISTIK CEPAT ===== --}}
            <div>
                <h2 style="font-size:1.1rem; font-weight:600; color:#374151; margin-bottom:1rem;">📊 Ringkasan Lahan Anda</h2>
                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap:1rem;">

                    @php
                        $lahans       = auth()->user()->lahans;
                        $totalLahan   = $lahans->count();
                        $totalHektar  = $lahans->sum('luas_lahan');
                        $jumlahPadi   = $lahans->where('komoditas','padi')->count();
                        $jumlahJagung = $lahans->where('komoditas','jagung')->count();
                    @endphp

                    <div class="stat-card">
                        <div class="stat-icon" style="background:#dcfce7;">🌾</div>
                        <div style="font-size:1.75rem; font-weight:700; color:#166534;">{{ $totalLahan }}</div>
                        <div style="font-size:0.875rem; color:#6b7280; margin-top:0.25rem;">Total Lahan Terdaftar</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon" style="background:#dbeafe;">📐</div>
                        <div style="font-size:1.75rem; font-weight:700; color:#1d4ed8;">{{ number_format($totalHektar, 2) }}</div>
                        <div style="font-size:0.875rem; color:#6b7280; margin-top:0.25rem;">Total Luas (Hektar)</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon" style="background:#fef9c3;">🌾</div>
                        <div style="font-size:1.75rem; font-weight:700; color:#854d0e;">{{ $jumlahPadi }}</div>
                        <div style="font-size:0.875rem; color:#6b7280; margin-top:0.25rem;">Lahan Padi</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon" style="background:#fef3c7;">🌽</div>
                        <div style="font-size:1.75rem; font-weight:700; color:#92400e;">{{ $jumlahJagung }}</div>
                        <div style="font-size:0.875rem; color:#6b7280; margin-top:0.25rem;">Lahan Jagung</div>
                    </div>

                </div>
            </div>

            {{-- ===== CUACA TERKINI ===== --}}
            @php
                /*
                    ⚠️ DATA DUMMY — Nanti diganti dengan data dari API cuaca (misal OpenWeatherMap).
                    Format yang diharapkan dari API:
                    - $cuacaSekarang: array berisi suhu, kondisi cuaca, kelembaban, kecepatan angin, kota
                    - $prakiraan: array 5 item, masing-masing berisi hari, ikon, suhu tertinggi, suhu terendah, label kondisi
                */
                $kota = 'Bandung'; // Nanti diambil dari lahan aktif user

                $cuacaSekarang = [
                    'suhu'         => 27,         // derajat Celsius
                    'kondisi'      => 'Berawan Sebagian',
                    'ikon'         => '⛅',
                    'kelembaban'   => 72,         // persen (%)
                    'angin'        => 14,         // km/jam
                    'curah_hujan'  => 0,          // mm/hari
                    'terasa_seperti' => 29,       // feels like
                ];

                $prakiraan = [
                    ['hari' => 'Hari Ini',  'ikon' => '⛅', 'suhu_max' => 28, 'suhu_min' => 22, 'kondisi' => 'Berawan'],
                    ['hari' => 'Besok',     'ikon' => '🌧️', 'suhu_max' => 25, 'suhu_min' => 20, 'kondisi' => 'Hujan Ringan'],
                    ['hari' => 'Lusa',      'ikon' => '⛈️', 'suhu_max' => 23, 'suhu_min' => 19, 'kondisi' => 'Hujan Lebat'],
                    ['hari' => 'Hari 4',    'ikon' => '🌤️', 'suhu_max' => 29, 'suhu_min' => 22, 'kondisi' => 'Cerah Berawan'],
                    ['hari' => 'Hari 5',    'ikon' => '☀️', 'suhu_max' => 31, 'suhu_min' => 23, 'kondisi' => 'Cerah'],
                ];
            @endphp

            <div>
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem; flex-wrap:wrap; gap:0.5rem;">
                    <h2 style="font-size:1.1rem; font-weight:600; color:#374151; margin:0;">🌤️ Cuaca Terkini</h2>
                    <span style="font-size:0.8rem; color:#9ca3af;">📍 {{ $kota }}</span>
                </div>

                <div class="weather-card">

                    {{-- Cuaca Sekarang --}}
                    <div class="weather-main">
                        <div class="weather-temp-area">
                            <span class="weather-icon-big">{{ $cuacaSekarang['ikon'] }}</span>
                            <div>
                                <div class="weather-temp">
                                    {{ $cuacaSekarang['suhu'] }}<sup>°C</sup>
                                </div>
                                <div class="weather-desc">{{ $cuacaSekarang['kondisi'] }}</div>
                                <div style="font-size:0.8rem; opacity:0.75; margin-top:0.2rem;">
                                    Terasa seperti {{ $cuacaSekarang['terasa_seperti'] }}°C
                                </div>
                            </div>
                        </div>

                        <div class="weather-meta">
                            <div class="weather-meta-item">
                                <span>💧</span>
                                <span>Kelembaban <strong>{{ $cuacaSekarang['kelembaban'] }}%</strong></span>
                            </div>
                            <div class="weather-meta-item">
                                <span>💨</span>
                                <span>Angin <strong>{{ $cuacaSekarang['angin'] }} km/jam</strong></span>
                            </div>
                            <div class="weather-meta-item">
                                <span>🌧️</span>
                                <span>Curah Hujan <strong>{{ $cuacaSekarang['curah_hujan'] }} mm</strong></span>
                            </div>
                            <span class="weather-source-badge">🔄 Data Dummy (belum terhubung API)</span>
                        </div>
                    </div>

                    <hr class="weather-divider">

                    {{-- Prakiraan 5 Hari --}}
                    <div style="font-size:0.78rem; opacity:0.75; margin-bottom:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.05em; position:relative; z-index:1;">Prakiraan 5 Hari ke Depan</div>
                    <div class="forecast-grid">
                        @foreach ($prakiraan as $idx => $hari)
                        <div class="forecast-item {{ $idx === 0 ? 'today' : '' }}">
                            <div class="forecast-day">{{ $hari['hari'] }}</div>
                            <div class="forecast-icon">{{ $hari['ikon'] }}</div>
                            <div class="forecast-temp-high">{{ $hari['suhu_max'] }}°</div>
                            <div class="forecast-temp-low">{{ $hari['suhu_min'] }}°</div>
                            <div class="forecast-label">{{ $hari['kondisi'] }}</div>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>

            {{-- ===== CARA KERJA APLIKASI ===== --}}
            <div>
                <h2 style="font-size:1.1rem; font-weight:600; color:#374151; margin-bottom:1rem;">🚀 Cara Kerja CuacaTani</h2>
                <div style="display:grid; gap:0.75rem;">

                    <div class="step-card">
                        <div class="step-number">1</div>
                        <div>
                            <div style="font-weight:600; color:#111827;">Daftarkan Lahan Anda</div>
                            <div style="font-size:0.875rem; color:#6b7280; margin-top:0.2rem;">
                                Masukkan kota lokasi lahan, jenis komoditas (padi/jagung), dan luas lahan dalam hektar.
                            </div>
                        </div>
                    </div>

                    <div class="step-card">
                        <div class="step-number">2</div>
                        <div>
                            <div style="font-weight:600; color:#111827;">Data Cuaca Diambil Otomatis</div>
                            <div style="font-size:0.875rem; color:#6b7280; margin-top:0.2rem;">
                                Sistem akan mengambil data cuaca terkini (suhu, hujan, kelembaban) untuk kota lahan Anda secara real-time.
                            </div>
                        </div>
                    </div>

                    <div class="step-card">
                        <div class="step-number">3</div>
                        <div>
                            <div style="font-weight:600; color:#111827;">Dapatkan Rekomendasi Tanam</div>
                            <div style="font-size:0.875rem; color:#6b7280; margin-top:0.2rem;">
                                Berdasarkan cuaca dan jenis tanaman, sistem memberikan saran apakah kondisi saat ini <strong>cocok untuk tanam</strong> atau perlu menunggu.
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ===== DAFTAR LAHAN (RINGKAS) ===== --}}
            @if ($totalLahan > 0)
            <div>
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
                    <h2 style="font-size:1.1rem; font-weight:600; color:#374151;">🗺️ Lahan Terakhir Anda</h2>
                    <a href="{{ route('lahan.index') }}" style="font-size:0.875rem; color:#16a34a; text-decoration:none; font-weight:500;">
                        Lihat semua →
                    </a>
                </div>
                <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap:1rem;">
                    @foreach ($lahans->take(3) as $lahan)
                    <div class="stat-card" style="border-left: 4px solid {{ $lahan->komoditas === 'padi' ? '#16a34a' : '#f59e0b' }};">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                            <div>
                                <div style="font-size:1.25rem; margin-bottom:0.25rem;">
                                    {{ $lahan->komoditas === 'padi' ? '🌾' : '🌽' }}
                                </div>
                                <div style="font-weight:600; color:#111827;">{{ $lahan->kota }}</div>
                                <div style="font-size:0.8rem; color:#6b7280; margin-top:0.2rem;">
                                    {{ ucfirst($lahan->komoditas) }} · {{ $lahan->luas_lahan }} Ha
                                </div>
                            </div>
                            <a href="{{ route('lahan.edit', $lahan->id) }}"
                               style="font-size:0.75rem; color:#16a34a; text-decoration:none; background:#f0fdf4; padding:4px 10px; border-radius:9999px; font-weight:500;">
                                Edit
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            {{-- Jika belum ada lahan --}}
            <div style="text-align:center; background:white; border-radius:0.75rem; padding:2.5rem; box-shadow:0 1px 3px rgba(0,0,0,0.06);">
                <div style="font-size:3rem; margin-bottom:1rem;">🌱</div>
                <h3 style="font-size:1.1rem; font-weight:600; color:#374151; margin-bottom:0.5rem;">Belum Ada Lahan Terdaftar</h3>
                <p style="color:#6b7280; font-size:0.875rem; margin-bottom:1.5rem;">
                    Mulai dengan mendaftarkan lahan pertama Anda untuk mendapatkan rekomendasi tanam.
                </p>
                <a href="{{ route('lahan.create') }}"
                   style="display:inline-flex; align-items:center; gap:0.5rem; background:#16a34a; color:white; padding:0.625rem 1.5rem; border-radius:0.5rem; text-decoration:none; font-weight:600; transition:background 0.2s;">
                    ➕ Tambah Lahan Pertama Saya
                </a>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
