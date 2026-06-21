<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CuacaTani — Rekomendasi Pertanian Berbasis Cuaca</title>
    <meta name="description" content="CuacaTani membantu petani mendapatkan rekomendasi aktivitas bertani berdasarkan prakiraan cuaca 5 hari ke depan.">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green-50: #f0fdf4;
            --green-100: #dcfce7;
            --green-200: #bbf7d0;
            --green-300: #86efac;
            --green-400: #4ade80;
            --green-500: #22c55e;
            --green-600: #16a34a;
            --green-700: #15803d;
            --green-800: #166534;
            --green-900: #14532d;
            --sky-400: #38bdf8;
            --sky-500: #0ea5e9;
            --sky-600: #0284c7;
            --amber-400: #fbbf24;
            --amber-500: #f59e0b;
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-300: #cbd5e1;
            --slate-400: #94a3b8;
            --slate-500: #64748b;
            --slate-600: #475569;
            --slate-700: #334155;
            --slate-800: #1e293b;
            --slate-900: #0f172a;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: var(--slate-800);
            background: var(--slate-50);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--slate-200);
            transition: box-shadow 0.3s ease;
        }
        .navbar.scrolled {
            box-shadow: 0 4px 30px rgba(0,0,0,0.08);
        }
        .navbar-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 72px;
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            font-weight: 800;
            font-size: 1.35rem;
            color: var(--green-700);
        }
        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--green-500), var(--green-700));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: white;
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
        }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .nav-link {
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--slate-600);
            transition: all 0.2s ease;
        }
        .nav-link:hover {
            color: var(--green-700);
            background: var(--green-50);
        }
        .nav-link.primary {
            background: linear-gradient(135deg, var(--green-500), var(--green-600));
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 14px rgba(22, 163, 74, 0.25);
        }
        .nav-link.primary:hover {
            background: linear-gradient(135deg, var(--green-600), var(--green-700));
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(22, 163, 74, 0.35);
        }

        /* ===== HERO ===== */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            background: linear-gradient(160deg, #f0fdf4 0%, #ecfdf5 30%, #e0f2fe 70%, #f0f9ff 100%);
        }
        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 800px;
            height: 800px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(34,197,94,0.08) 0%, transparent 70%);
            animation: float 20s ease-in-out infinite;
        }
        .hero::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(14,165,233,0.06) 0%, transparent 70%);
            animation: float 25s ease-in-out infinite reverse;
        }
        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(30px, -40px); }
        }
        .hero-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 120px 24px 80px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            position: relative;
            z-index: 1;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            border: 1px solid var(--green-200);
            border-radius: 100px;
            padding: 6px 16px 6px 8px;
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--green-700);
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(22, 163, 74, 0.08);
        }
        .hero-badge-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--green-500);
            animation: pulse-dot 2s ease-in-out infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.3); }
        }
        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.1;
            color: var(--slate-900);
            margin-bottom: 20px;
            letter-spacing: -0.03em;
        }
        .hero h1 span {
            background: linear-gradient(135deg, var(--green-600), var(--sky-500));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-desc {
            font-size: 1.15rem;
            color: var(--slate-500);
            margin-bottom: 36px;
            max-width: 500px;
            line-height: 1.7;
        }
        .hero-actions {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.25s ease;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--green-500), var(--green-600));
            color: white;
            box-shadow: 0 6px 20px rgba(22, 163, 74, 0.3);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(22, 163, 74, 0.4);
        }
        .btn-secondary {
            background: white;
            color: var(--slate-700);
            border: 1.5px solid var(--slate-200);
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .btn-secondary:hover {
            border-color: var(--green-300);
            color: var(--green-700);
            transform: translateY(-2px);
        }

        /* Hero illustration */
        .hero-visual {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .weather-card-hero {
            background: white;
            border-radius: 24px;
            padding: 32px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08), 0 0 0 1px rgba(0,0,0,0.04);
            width: 100%;
            max-width: 420px;
            position: relative;
        }
        .weather-card-hero::before {
            content: '';
            position: absolute;
            top: -1px;
            left: 20%;
            right: 20%;
            height: 3px;
            background: linear-gradient(90deg, var(--green-400), var(--sky-400), var(--amber-400));
            border-radius: 0 0 4px 4px;
        }
        .wc-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 24px;
        }
        .wc-location {
            font-size: 0.85rem;
            color: var(--slate-400);
            font-weight: 500;
        }
        .wc-city {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--slate-800);
            margin-top: 2px;
        }
        .wc-temp-big {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--slate-900);
            line-height: 1;
        }
        .wc-temp-big sup {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--slate-400);
        }
        .wc-weather-icon {
            font-size: 3.5rem;
            line-height: 1;
        }
        .wc-status {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            color: var(--slate-500);
            margin-top: 6px;
        }
        .wc-divider {
            height: 1px;
            background: var(--slate-100);
            margin: 20px 0;
        }
        .wc-forecast {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
        }
        .wc-day {
            text-align: center;
            padding: 10px 4px;
            border-radius: 12px;
            transition: background 0.2s;
        }
        .wc-day:hover {
            background: var(--green-50);
        }
        .wc-day-label {
            font-size: 0.72rem;
            color: var(--slate-400);
            font-weight: 500;
            text-transform: uppercase;
        }
        .wc-day-icon {
            font-size: 1.4rem;
            margin: 6px 0;
        }
        .wc-day-temp {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--slate-700);
        }
        /* Floating recommendation tag */
        .float-tag {
            position: absolute;
            background: white;
            border-radius: 14px;
            padding: 12px 18px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.82rem;
            font-weight: 600;
            animation: float-tag 4s ease-in-out infinite;
            z-index: 2;
        }
        .float-tag.tag1 {
            top: 10%;
            right: -20px;
            color: var(--green-700);
            border: 1px solid var(--green-200);
        }
        .float-tag.tag2 {
            bottom: 15%;
            left: -30px;
            color: var(--sky-600);
            border: 1px solid rgba(14,165,233,0.2);
            animation-delay: 2s;
        }
        @keyframes float-tag {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        /* ===== FEATURES ===== */
        .section {
            padding: 100px 24px;
        }
        .section-inner {
            max-width: 1200px;
            margin: 0 auto;
        }
        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }
        .section-label {
            display: inline-block;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--green-600);
            background: var(--green-50);
            padding: 6px 16px;
            border-radius: 100px;
            margin-bottom: 16px;
        }
        .section-title {
            font-size: 2.3rem;
            font-weight: 800;
            color: var(--slate-900);
            margin-bottom: 14px;
            letter-spacing: -0.02em;
        }
        .section-subtitle {
            font-size: 1.05rem;
            color: var(--slate-500);
            max-width: 550px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 36px 30px;
            border: 1px solid var(--slate-100);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--green-400), var(--sky-400));
            transform: scaleX(0);
            transition: transform 0.3s ease;
            transform-origin: left;
        }
        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(0,0,0,0.08);
            border-color: transparent;
        }
        .feature-card:hover::before {
            transform: scaleX(1);
        }
        .feature-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            margin-bottom: 20px;
        }
        .feature-icon.green {
            background: var(--green-100);
        }
        .feature-icon.sky {
            background: #e0f2fe;
        }
        .feature-icon.amber {
            background: #fef3c7;
        }
        .feature-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--slate-800);
            margin-bottom: 10px;
        }
        .feature-desc {
            font-size: 0.9rem;
            color: var(--slate-500);
            line-height: 1.6;
        }

        /* ===== HOW IT WORKS ===== */
        .how-section {
            background: linear-gradient(180deg, white 0%, var(--green-50) 100%);
        }
        .steps-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            position: relative;
        }
        .steps-grid::before {
            content: '';
            position: absolute;
            top: 40px;
            left: 15%;
            right: 15%;
            height: 2px;
            background: linear-gradient(90deg, var(--green-200), var(--sky-200), var(--amber-200), var(--green-200));
            z-index: 0;
        }
        .step-card {
            text-align: center;
            position: relative;
            z-index: 1;
        }
        .step-number {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            font-weight: 800;
            margin: 0 auto 18px;
            color: white;
            box-shadow: 0 6px 20px rgba(22, 163, 74, 0.25);
        }
        .step-card:nth-child(1) .step-number { background: linear-gradient(135deg, var(--green-400), var(--green-600)); }
        .step-card:nth-child(2) .step-number { background: linear-gradient(135deg, var(--sky-400), var(--sky-600)); }
        .step-card:nth-child(3) .step-number { background: linear-gradient(135deg, var(--amber-400), var(--amber-500)); }
        .step-card:nth-child(4) .step-number { background: linear-gradient(135deg, var(--green-500), var(--green-700)); }

        .step-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--slate-800);
            margin-bottom: 8px;
        }
        .step-desc {
            font-size: 0.85rem;
            color: var(--slate-500);
            line-height: 1.5;
        }

        /* ===== CTA ===== */
        .cta-section {
            background: linear-gradient(135deg, var(--green-600) 0%, var(--green-800) 50%, var(--slate-900) 100%);
            color: white;
            text-align: center;
            padding: 100px 24px;
            position: relative;
            overflow: hidden;
        }
        .cta-section::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }
        .cta-section::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,0.03);
        }
        .cta-inner {
            position: relative;
            z-index: 1;
        }
        .cta-section h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 16px;
            letter-spacing: -0.02em;
        }
        .cta-section p {
            font-size: 1.1rem;
            color: rgba(255,255,255,0.75);
            margin-bottom: 36px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }
        .btn-white {
            background: white;
            color: var(--green-700);
            padding: 16px 36px;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.25s ease;
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }
        .btn-white:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        /* ===== FOOTER ===== */
        .footer {
            background: var(--slate-900);
            color: var(--slate-400);
            padding: 40px 24px;
            text-align: center;
            font-size: 0.85rem;
        }
        .footer a {
            color: var(--green-400);
            text-decoration: none;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .hero-inner {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 40px;
            }
            .hero-desc { margin: 0 auto 36px; }
            .hero-actions { justify-content: center; }
            .hero h1 { font-size: 2.8rem; }
            .features-grid { grid-template-columns: 1fr 1fr; }
            .steps-grid { grid-template-columns: 1fr 1fr; gap: 30px; }
            .steps-grid::before { display: none; }
            .float-tag { display: none; }
        }
        @media (max-width: 640px) {
            .hero h1 { font-size: 2.2rem; }
            .hero-desc { font-size: 1rem; }
            .features-grid { grid-template-columns: 1fr; }
            .steps-grid { grid-template-columns: 1fr; }
            .section-title { font-size: 1.8rem; }
            .cta-section h2 { font-size: 1.8rem; }
            .nav-links { gap: 4px; }
            .nav-link { padding: 8px 14px; font-size: 0.82rem; }
            .navbar-inner { height: 60px; }
        }
    </style>
</head>
<body>

    {{-- ===== NAVBAR ===== --}}
    <nav class="navbar" id="navbar">
        <div class="navbar-inner">
            <a href="/" class="logo">
                <div class="logo-icon">🌾</div>
                CuacaTani
            </a>
            <div class="nav-links">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="nav-link primary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="nav-link">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="nav-link primary">Daftar Gratis</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    {{-- ===== HERO ===== --}}
    <section class="hero" id="hero">
        <div class="hero-inner">
            <div>
                <div class="hero-badge">
                    <span class="hero-badge-dot"></span>
                    Prakiraan Cuaca 5 Hari ke Depan
                </div>
                <h1>Bertani Lebih Cerdas<br>dengan <span>Data Cuaca</span></h1>
                <p class="hero-desc">
                    CuacaTani memberikan rekomendasi aktivitas bertani — kapan harus menyiram, 
                    kapan menunda pemupukan — berdasarkan prakiraan cuaca di lokasi lahan Anda.
                </p>
                <div class="hero-actions">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            Mulai Sekarang
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </a>
                    @endif
                    <a href="#fitur" class="btn btn-secondary">Pelajari Lebih Lanjut</a>
                </div>
            </div>

            {{-- Hero visual: mock weather card --}}
            <div class="hero-visual">
                <div class="float-tag tag1">
                    ✅ Aman untuk pemupukan
                </div>
                <div class="float-tag tag2">
                    🌧️ Tunda penyiraman besok
                </div>
                <div class="weather-card-hero">
                    <div class="wc-header">
                        <div>
                            <div class="wc-location">📍 Lokasi Lahan</div>
                            <div class="wc-city">Purwakarta</div>
                        </div>
                        <div style="text-align:right;">
                            <div class="wc-weather-icon">⛅</div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:baseline;gap:12px;">
                        <div class="wc-temp-big">28<sup>°C</sup></div>
                        <div class="wc-status">
                            <span>Berawan sebagian</span>
                        </div>
                    </div>
                    <div class="wc-divider"></div>
                    <div class="wc-forecast">
                        <div class="wc-day">
                            <div class="wc-day-label">Sen</div>
                            <div class="wc-day-icon">☀️</div>
                            <div class="wc-day-temp">31°</div>
                        </div>
                        <div class="wc-day">
                            <div class="wc-day-label">Sel</div>
                            <div class="wc-day-icon">🌤️</div>
                            <div class="wc-day-temp">29°</div>
                        </div>
                        <div class="wc-day">
                            <div class="wc-day-label">Rab</div>
                            <div class="wc-day-icon">🌧️</div>
                            <div class="wc-day-temp">26°</div>
                        </div>
                        <div class="wc-day">
                            <div class="wc-day-label">Kam</div>
                            <div class="wc-day-icon">🌧️</div>
                            <div class="wc-day-temp">25°</div>
                        </div>
                        <div class="wc-day">
                            <div class="wc-day-label">Jum</div>
                            <div class="wc-day-icon">⛅</div>
                            <div class="wc-day-temp">28°</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== FITUR ===== --}}
    <section class="section" id="fitur">
        <div class="section-inner">
            <div class="section-header">
                <div class="section-label">Fitur Utama</div>
                <h2 class="section-title">Semua yang Petani Butuhkan</h2>
                <p class="section-subtitle">Informasi cuaca dan rekomendasi bertani dalam satu tempat yang mudah dipahami.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon sky">🌦️</div>
                    <div class="feature-title">Prakiraan Cuaca 5 Hari</div>
                    <div class="feature-desc">
                        Lihat prakiraan suhu, kondisi hujan atau cerah, dan curah hujan untuk 5 hari ke depan berdasarkan lokasi lahan Anda.
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon green">🌾</div>
                    <div class="feature-title">Rekomendasi Bertani</div>
                    <div class="feature-desc">
                        Dapatkan saran kapan waktu terbaik untuk menyiram, memupuk, atau menunda aktivitas tertentu berdasarkan kondisi cuaca.
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon amber">📋</div>
                    <div class="feature-title">Kelola Data Lahan</div>
                    <div class="feature-desc">
                        Catat data lahan Anda — kota, komoditas (padi atau jagung), dan luas lahan — untuk mendapat rekomendasi yang lebih tepat.
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== CARA KERJA ===== --}}
    <section class="section how-section" id="cara-kerja">
        <div class="section-inner">
            <div class="section-header">
                <div class="section-label">Cara Kerja</div>
                <h2 class="section-title">Mudah dalam 4 Langkah</h2>
                <p class="section-subtitle">Dari daftar akun sampai dapat rekomendasi, prosesnya sederhana.</p>
            </div>
            <div class="steps-grid">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div class="step-title">Daftar Akun</div>
                    <div class="step-desc">Buat akun gratis sebagai petani. Cukup isi nama, email, dan password.</div>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <div class="step-title">Tambah Data Lahan</div>
                    <div class="step-desc">Masukkan kota, jenis komoditas (padi/jagung), dan luas lahan Anda.</div>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <div class="step-title">Lihat Prakiraan Cuaca</div>
                    <div class="step-desc">Sistem mengambil data cuaca 5 hari ke depan dari OpenWeatherMap untuk kota lahan Anda.</div>
                </div>
                <div class="step-card">
                    <div class="step-number">4</div>
                    <div class="step-title">Dapat Rekomendasi</div>
                    <div class="step-desc">Terima saran aktivitas bertani — seperti "tunda pemupukan" saat hujan, atau "siram" saat panas.</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== CTA ===== --}}
    <section class="cta-section">
        <div class="cta-inner">
            <h2>Siap Bertani Lebih Cerdas?</h2>
            <p>Daftar sekarang dan mulai dapatkan rekomendasi bertani berdasarkan cuaca di lokasi lahan Anda.</p>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn-white">
                    Daftar Gratis Sekarang
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
            @endif
        </div>
    </section>

    {{-- ===== FOOTER ===== --}}
    <footer class="footer">
        <p>&copy; {{ date('Y') }} <a href="/">CuacaTani</a> — Sistem Rekomendasi Pertanian Berbasis Cuaca</p>
    </footer>

    <script>
        // Navbar shadow on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 10) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>
