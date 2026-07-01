<x-app-layout>
    {{-- Style khusus dashboard --}}
    <style>
        /* ===== PREMIUM HERO — Double-Bezel ===== */
        .dash-hero-shell {
            background: rgba(255,255,255,0.3);
            border-radius: 2rem;
            padding: 1.5px;
            box-shadow: 0 1px 0 1px rgba(255,255,255,0.5);
        }
        .dash-hero-core {
            background: linear-gradient(160deg, #16a34a 0%, #15803d 35%, #166534 70%, #14532d 100%);
            border-radius: calc(2rem - 1.5px);
            padding: 3rem 3.5rem;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: inset 0 1px 1px rgba(255,255,255,0.2);
        }
        .dash-hero-core::before {
            content: '';
            position: absolute;
            top: -40%;
            right: -10%;
            width: 500px; height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: dashFloat 18s ease-in-out infinite;
        }
        .dash-hero-core::after {
            content: '';
            position: absolute;
            bottom: -60%;
            left: -5%;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(56,189,248,0.08) 0%, transparent 70%);
            animation: dashFloat 22s ease-in-out infinite reverse;
        }
        @keyframes dashFloat {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(20px, -30px); }
        }
        .dash-hero-grid {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 3rem;
            align-items: center;
            position: relative;
            z-index: 1;
        }
        .dash-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 100px;
            padding: 5px 14px 5px 7px;
            font-size: 0.78rem;
            font-weight: 500;
            color: rgba(255,255,255,0.9);
            margin-bottom: 1rem;
            backdrop-filter: blur(4px);
        }
        .dash-hero-badge-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: #4ade80;
            animation: dashPulse 2s ease-in-out infinite;
        }
        @keyframes dashPulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.3); }
        }
        .dash-hero h1 {
            font-size: 2.2rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            line-height: 1.15;
            margin-bottom: 0.75rem;
        }
        .dash-hero h1 span {
            background: linear-gradient(135deg, rgba(255,255,255,1), rgba(255,255,255,0.65));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .dash-hero-desc {
            font-size: 0.95rem;
            opacity: 0.85;
            max-width: 440px;
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }
        .dash-hero-actions {
            display: flex; gap: 0.75rem; flex-wrap: wrap;
        }

        /* Button-in-Button (Double-Bezel CTA) */
        .dash-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 14px 12px 24px;
            border-radius: 100px;
            background: white;
            color: var(--green-700);
            font-size: 0.88rem;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
            transition: all 0.3s cubic-bezier(0.32,0.72,0,1);
            box-shadow: 0 4px 14px rgba(0,0,0,0.1);
        }
        .dash-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(0,0,0,0.15);
        }
        .dash-btn-primary:active {
            transform: scale(0.98);
        }
        .dash-btn-icon {
            width: 30px; height: 30px;
            border-radius: 50%;
            background: var(--green-100);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            transition: all 0.3s cubic-bezier(0.32,0.72,0,1);
        }
        .dash-btn-primary:hover .dash-btn-icon {
            transform: translateX(2px) scale(1.05);
        }
        .dash-btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 22px;
            border-radius: 100px;
            background: rgba(255,255,255,0.12);
            border: 1.5px solid rgba(255,255,255,0.35);
            color: white;
            font-size: 0.88rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.32,0.72,0,1);
            font-family: inherit;
            cursor: pointer;
        }
        .dash-btn-outline:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }
        .dash-btn-outline:active {
            transform: scale(0.98);
        }

        /* Hero weather preview pill (right side) */
        .hero-weather-preview {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 1.5rem;
            padding: 1.25rem 1.75rem;
            backdrop-filter: blur(8px);
            transition: all 0.3s cubic-bezier(0.32,0.72,0,1);
        }
        .hero-weather-preview:hover {
            background: rgba(255,255,255,0.18);
            transform: translateY(-2px);
        }
        .hero-wi { font-size: 3rem; line-height: 1; }
        .hero-wt {
            font-size: 2.2rem;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -0.02em;
        }
        .hero-wt sup {
            font-size: 1rem;
            font-weight: 500;
            opacity: 0.8;
        }
        .hero-wd {
            font-size: 0.8rem;
            opacity: 0.8;
            margin-top: 2px;
        }
        .hero-wl {
            font-size: 0.7rem;
            opacity: 0.6;
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ===== DOUBLE-BEZEL STAT CARDS ===== */
        .stat-shell {
            background: rgba(0,0,0,0.03);
            border-radius: 1.25rem;
            padding: 1px;
            transition: all 0.3s cubic-bezier(0.32,0.72,0,1);
        }
        .stat-shell:hover {
            background: rgba(0,0,0,0.06);
        }
        .stat-core {
            background: white;
            border-radius: calc(1.25rem - 1px);
            padding: 1.25rem 1.5rem;
            transition: all 0.3s cubic-bezier(0.32,0.72,0,1);
            box-shadow: inset 0 1px 1px rgba(255,255,255,0.5);
        }
        .stat-shell:hover .stat-core {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(0,0,0,0.06), inset 0 1px 1px rgba(255,255,255,0.5);
        }
        .stat-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; margin-bottom: 0.75rem;
        }
        .stat-value {
            font-size: 1.6rem; font-weight: 800; letter-spacing: -0.02em;
            line-height: 1.1;
        }
        .stat-label {
            font-size: 0.8rem; color: var(--slate-500);
            margin-top: 0.2rem; font-weight: 500;
        }

        /* ===== SECTION HEADERS ===== */
        .section-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 1.25rem; flex-wrap: wrap; gap: 0.5rem;
        }
        .section-title {
            font-size: 1.1rem; font-weight: 700; color: var(--slate-800);
            letter-spacing: -0.01em;
        }
        .section-title .emoji { margin-right: 0.4rem; }

        /* ===== WEATHER CARD — Double-Bezel ===== */
        .weather-shell {
            background: rgba(0,0,0,0.03);
            border-radius: 1.75rem;
            padding: 1.5px;
            transition: all 0.3s cubic-bezier(0.32,0.72,0,1);
        }
        .weather-shell:hover {
            background: rgba(0,0,0,0.06);
        }
        .weather-card {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 50%, #0369a1 100%);
            border-radius: calc(1.75rem - 1.5px);
            padding: 1.75rem;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: inset 0 1px 1px rgba(255,255,255,0.15);
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
        .weather-icon-big { font-size: 4rem; line-height: 1; }
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
            border-radius: 0.75rem;
            padding: 0.75rem 0.5rem;
            text-align: center;
            backdrop-filter: blur(4px);
            transition: background 0.3s cubic-bezier(0.32,0.72,0,1);
        }
        .forecast-item:hover { background: rgba(255,255,255,0.25); }
        .forecast-item.today {
            background: rgba(255,255,255,0.25);
            border: 1px solid rgba(255,255,255,0.4);
        }
        .forecast-day {
            font-size: 0.75rem; font-weight: 600; opacity: 0.8;
            text-transform: uppercase; letter-spacing: 0.05em;
        }
        .forecast-icon { font-size: 1.5rem; margin: 0.35rem 0; }
        .forecast-temp-high { font-size: 0.9rem; font-weight: 700; }
        .forecast-temp-low { font-size: 0.78rem; opacity: 0.7; }
        .forecast-label { font-size: 0.7rem; opacity: 0.8; margin-top: 0.2rem; }
        .weather-source-badge {
            display: inline-flex; align-items: center; gap: 0.35rem;
            font-size: 0.72rem; background: rgba(255,255,255,0.18);
            border-radius: 9999px; padding: 0.2rem 0.6rem;
            margin-top: 0.6rem; opacity: 0.85;
        }

        /* ===== REKOMENDASI CARDS ===== */
        .rec-card {
            background: white; border-radius: 1rem; padding: 1.25rem 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.03);
            display: flex; align-items: flex-start; gap: 1rem;
            transition: all 0.3s cubic-bezier(0.32,0.72,0,1);
        }
        .rec-card:hover {
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            transform: translateY(-2px);
        }
        .rec-number {
            width: 32px; height: 32px; border-radius: 50%;
            color: white; display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.875rem; flex-shrink: 0;
        }
        .rec-day {
            font-weight: 600; color: #111827;
        }
        .rec-date {
            font-size: 0.75rem; background: #f0fdf4; color: #16a34a;
            padding: 2px 8px; border-radius: 9999px; font-weight: 500;
        }
        .rec-text {
            font-size: 0.875rem; color: #4b5563;
            margin-top: 0.25rem; line-height: 1.5;
        }
        .step-siram { border-left: 4px solid #0ea5e9; }
        .step-tunda_pemupukan { border-left: 4px solid #ef4444; }
        .step-pemupukan_normal { border-left: 4px solid #16a34a; }
        .step-lindungi_tanaman { border-left: 4px solid #8b5cf6; }
        .step-tidak_ada { border-left: 4px solid #9ca3af; }
        .step-default { border-left: 4px solid #9ca3af; }
        .step-number-siram { background: #0ea5e9; }
        .step-number-tunda_pemupukan { background: #ef4444; }
        .step-number-pemupukan_normal { background: #16a34a; }
        .step-number-lindungi_tanaman { background: #8b5cf6; }
        .step-number-tidak_ada { background: #6b7280; }
        .step-number-default { background: #6b7280; }

        /* ===== LAHAN MINI CARDS ===== */
        .lahan-padi { border-left: 4px solid #16a34a; }
        .lahan-jagung { border-left: 4px solid #f59e0b; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 640px) {
            .dash-hero-core { padding: 1.5rem; }
            .dash-hero-grid { grid-template-columns: 1fr; gap: 1.25rem; }
            .dash-hero h1 { font-size: 1.5rem; }
            .dash-hero-actions { flex-direction: column; }
            .dash-btn-primary, .dash-btn-outline { justify-content: center; width: 100%; }
            .hero-weather-preview { justify-content: center; }
        }
        @media (min-width: 641px) and (max-width: 900px) {
            .dash-hero-grid { grid-template-columns: 1fr; gap: 1.5rem; }
            .hero-weather-preview { justify-content: flex-start; max-width: 400px; }
        }
    </style>

    <div class="space-y-10">

        {{-- ===== HERO — Double-Bezel Shell ===== --}}
        <div class="dash-hero-shell">
            <div class="dash-hero-core">
                <div class="dash-hero-grid">
                    <div class="dash-hero">
                        <div class="dash-hero-badge">
                            <span class="dash-hero-badge-dot"></span>
                            {{ __('Dashboard Petani') }}
                        </div>
                        <h1>{{ Auth::user()->name }} <span>👋</span></h1>
                        <p class="dash-hero-desc">
                            Kelola lahan pertanian Anda dengan mudah. Pantau data lahan dan dapatkan rekomendasi
                            tanam terbaik berdasarkan cuaca terkini.
                        </p>
                        <div class="dash-hero-actions">
                            <a href="{{ route('lahan.index') }}" class="dash-btn-primary">
                                📋 Lihat Data Lahan
                                <span class="dash-btn-icon">→</span>
                            </a>
                            <a href="{{ route('lahan.create') }}" class="dash-btn-outline">
                                ➕ Tambah Lahan
                            </a>
                        </div>
                    </div>

                    {{-- Weather preview pill (hero accent) --}}
                    <div class="hero-weather-preview">
                        <span class="hero-wi">{{ $cuacaSekarang['ikon'] }}</span>
                        <div>
                            <div class="hero-wt">{{ $cuacaSekarang['suhu'] }}<sup>°C</sup></div>
                            <div class="hero-wd">{{ $cuacaSekarang['kondisi'] }}</div>
                            <div class="hero-wl">📍 {{ $kota }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== STATISTIK CEPAT ===== --}}
        <div>
            <div class="section-header">
                <h2 class="section-title"><span class="emoji">📊</span>Ringkasan Lahan Anda</h2>
            </div>
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap:1rem;">

                @php
                    $lahans       = auth()->user()->lahans;
                    $totalLahan   = $lahans->count();
                    $totalHektar  = $lahans->sum('luas_lahan');
                    $jumlahPadi   = $lahans->where('komoditas','padi')->count();
                    $jumlahJagung = $lahans->where('komoditas','jagung')->count();
                @endphp

                <div class="stat-shell">
                    <div class="stat-core">
                        <div class="stat-icon" style="background:#dcfce7;">🌾</div>
                        <div class="stat-value" style="color:#166534;">{{ $totalLahan }}</div>
                        <div class="stat-label">Total Lahan Terdaftar</div>
                    </div>
                </div>

                <div class="stat-shell">
                    <div class="stat-core">
                        <div class="stat-icon" style="background:#dbeafe;">📐</div>
                        <div class="stat-value" style="color:#1d4ed8;">{{ number_format($totalHektar, 2) }}</div>
                        <div class="stat-label">Total Luas (Hektar)</div>
                    </div>
                </div>

                <div class="stat-shell">
                    <div class="stat-core">
                        <div class="stat-icon" style="background:#fef9c3;">🌾</div>
                        <div class="stat-value" style="color:#854d0e;">{{ $jumlahPadi }}</div>
                        <div class="stat-label">Lahan Padi</div>
                    </div>
                </div>

                <div class="stat-shell">
                    <div class="stat-core">
                        <div class="stat-icon" style="background:#fef3c7;">🌽</div>
                        <div class="stat-value" style="color:#92400e;">{{ $jumlahJagung }}</div>
                        <div class="stat-label">Lahan Jagung</div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ===== CUACA TERKINI — Double-Bezel ===== --}}
        <div>
            <div class="section-header">
                <h2 class="section-title"><span class="emoji">🌤️</span>Cuaca Terkini</h2>
            </div>

            <div class="weather-shell">
                <div class="weather-card">
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
                            @if ($isDummy)
                            <span class="weather-source-badge">🔄 Data Dummy (belum terhubung API)</span>
                            @else
                            <span class="weather-source-badge">✅ OpenWeatherMap · {{ $kota }}</span>
                            @endif
                        </div>
                    </div>

                    <hr class="weather-divider">

                    <div style="font-size:0.78rem; opacity:0.75; margin-bottom:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.05em; position:relative; z-index:1;">Prakiraan 5 Hari</div>
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
        </div>

        {{-- ===== REKOMENDASI TANAM ===== --}}
        @if (!empty($rekomendasi))
        <div>
            <div class="section-header">
                <h2 class="section-title"><span class="emoji">🌱</span>Rekomendasi Aktivitas Bertani</h2>
                @if ($totalLahan > 1)
                <form method="GET" action="{{ route('dashboard') }}" style="display:flex; align-items:center; gap:0.5rem;">
                    <label style="font-size:0.8rem; color:var(--slate-500);">Pilih Lahan:</label>
                    <select name="lahan_id" onchange="this.form.submit()"
                            style="font-size:0.8rem; padding:0.3rem 0.6rem; border:1.5px solid var(--slate-200); border-radius:0.5rem; background:white; color:var(--slate-700); cursor:pointer; font-family:inherit;">
                        @foreach ($lahans as $lahan)
                        <option value="{{ $lahan->id }}" {{ $lahanAktif && $lahanAktif->id === $lahan->id ? 'selected' : '' }}>
                            {{ ucfirst($lahan->komoditas) }} — {{ $lahan->kota }} ({{ $lahan->luas_lahan }} Ha)
                        </option>
                        @endforeach
                    </select>
                </form>
                @else
                <span style="font-size:0.8rem; color:var(--slate-400);">Untuk {{ ucfirst($komoditas) }} di {{ $kota }}</span>
                @endif
            </div>
            <div style="display:grid; gap:0.75rem;">
                @foreach ($rekomendasi as $rec)
                <div class="rec-card step-{{ $rec['aksi'] }}">
                    <div class="rec-number step-number-{{ $rec['aksi'] }}">
                        {{ $rec['ikon'] }}
                    </div>
                    <div style="flex:1;">
                        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:0.25rem;">
                            <div class="rec-day">{{ $prakiraan[$loop->index]['hari'] ?? $rec['tanggal'] }}</div>
                            <span class="rec-date">{{ $rec['tanggal'] }}</span>
                        </div>
                        <div class="rec-text">{{ $rec['rekomendasi'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ===== CARA KERJA APLIKASI ===== --}}
        <div>
            <div class="section-header">
                <h2 class="section-title"><span class="emoji">🚀</span>Cara Kerja CuacaTani</h2>
            </div>
            <div style="display:grid; gap:0.75rem;">
                <div class="rec-card">
                    <div class="rec-number" style="background: linear-gradient(135deg, var(--green-400), var(--green-600));">1</div>
                    <div>
                        <div style="font-weight:600; color:var(--slate-800);">Daftarkan Lahan Anda</div>
                        <div style="font-size:0.875rem; color:var(--slate-500); margin-top:0.2rem;">
                            Masukkan kota lokasi lahan, jenis komoditas (padi/jagung), dan luas lahan dalam hektar.
                        </div>
                    </div>
                </div>
                <div class="rec-card">
                    <div class="rec-number" style="background: linear-gradient(135deg, var(--sky-400), var(--sky-600));">2</div>
                    <div>
                        <div style="font-weight:600; color:var(--slate-800);">Data Cuaca Diambil Otomatis</div>
                        <div style="font-size:0.875rem; color:var(--slate-500); margin-top:0.2rem;">
                            Sistem akan mengambil data cuaca terkini (suhu, hujan, kelembaban) untuk kota lahan Anda secara real-time.
                        </div>
                    </div>
                </div>
                <div class="rec-card">
                    <div class="rec-number" style="background: linear-gradient(135deg, var(--amber-400), var(--amber-500));">3</div>
                    <div>
                        <div style="font-weight:600; color:var(--slate-800);">Dapatkan Rekomendasi Tanam</div>
                        <div style="font-size:0.875rem; color:var(--slate-500); margin-top:0.2rem;">
                            Berdasarkan cuaca dan jenis tanaman, sistem memberikan saran apakah kondisi saat ini <strong>cocok untuk tanam</strong> atau perlu menunggu.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== DAFTAR LAHAN (RINGKAS) ===== --}}
        @if ($totalLahan > 0)
        <div>
            <div class="section-header">
                <h2 class="section-title"><span class="emoji">🗺️</span>Lahan Terakhir Anda</h2>
                <a href="{{ route('lahan.index') }}" style="font-size:0.875rem; color:var(--green-600); text-decoration:none; font-weight:600;">
                    Lihat semua →
                </a>
            </div>
            <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap:1rem;">
                @foreach ($lahans->take(3) as $lahan)
                <div class="stat-shell">
                    <div class="stat-core lahan-{{ $lahan->komoditas }}">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                            <div>
                                <div style="font-size:1.25rem; margin-bottom:0.25rem;">
                                    {{ $lahan->komoditas === 'padi' ? '🌾' : '🌽' }}
                                </div>
                                <div style="font-weight:600; color:var(--slate-800);">{{ $lahan->kota }}</div>
                                <div style="font-size:0.8rem; color:var(--slate-500); margin-top:0.2rem;">
                                    {{ ucfirst($lahan->komoditas) }} · {{ $lahan->luas_lahan }} Ha
                                </div>
                            </div>
                            <a href="{{ route('lahan.edit', $lahan->id) }}"
                               style="font-size:0.75rem; color:var(--green-600); text-decoration:none; background:var(--green-50); padding:4px 10px; border-radius:9999px; font-weight:500;">
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        {{-- Jika belum ada lahan --}}
        <div class="stat-shell" style="padding:0; background:transparent;">
            <div class="stat-core" style="text-align:center; padding:2.5rem;">
                <div style="font-size:3rem; margin-bottom:1rem;">🌱</div>
                <h3 style="font-size:1.1rem; font-weight:600; color:var(--slate-700); margin-bottom:0.5rem;">Belum Ada Lahan Terdaftar</h3>
                <p style="color:var(--slate-500); font-size:0.875rem; margin-bottom:1.5rem;">
                    Mulai dengan mendaftarkan lahan pertama Anda untuk mendapatkan rekomendasi tanam.
                </p>
                <a href="{{ route('lahan.create') }}"
                   class="dash-btn-primary" style="display:inline-flex;">
                    ➕ Tambah Lahan Pertama Saya
                    <span class="dash-btn-icon">→</span>
                </a>
            </div>
        </div>
        @endif

    </div>
</x-app-layout>
