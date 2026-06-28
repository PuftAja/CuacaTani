<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CuacaTani — {{ request()->route()->getName() === 'register' ? 'Daftar' : 'Masuk' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --green-50: #f0fdf4; --green-100: #dcfce7; --green-200: #bbf7d0;
            --green-300: #86efac; --green-400: #4ade80; --green-500: #22c55e;
            --green-600: #16a34a; --green-700: #15803d; --green-800: #166534; --green-900: #14532d;
            --sky-400: #38bdf8; --sky-500: #0ea5e9; --sky-600: #0284c7;
            --amber-400: #fbbf24; --amber-500: #f59e0b;
            --slate-50: #f8fafc; --slate-100: #f1f5f9; --slate-200: #e2e8f0;
            --slate-300: #cbd5e1; --slate-400: #94a3b8; --slate-500: #64748b;
            --slate-600: #475569; --slate-700: #334155; --slate-800: #1e293b; --slate-900: #0f172a;
        }
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: var(--slate-800);
            background: var(--slate-50);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* ====== NAVBAR (sama persis seperti landing page) ====== */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            background: rgba(255,255,255,0.85); backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--slate-200);
            transition: box-shadow 0.3s ease;
        }
        .navbar.scrolled { box-shadow: 0 4px 30px rgba(0,0,0,0.08); }
        .navbar-inner {
            max-width: 1200px; margin: 0 auto; padding: 0 24px;
            display: flex; align-items: center; justify-content: space-between; height: 72px;
        }
        .logo {
            display: flex; align-items: center; gap: 10px; text-decoration: none;
            font-weight: 800; font-size: 1.35rem; color: var(--green-700);
        }
        .logo-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--green-500), var(--green-700));
            border-radius: 12px; display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; color: white; box-shadow: 0 4px 12px rgba(22,163,74,0.3);
        }
        .nav-links { display: flex; align-items: center; gap: 8px; }
        .nav-link {
            text-decoration: none; padding: 10px 20px; border-radius: 10px;
            font-size: 0.9rem; font-weight: 500; color: var(--slate-600);
            transition: all 0.2s ease;
        }
        .nav-link:hover { color: var(--green-700); background: var(--green-50); }
        .nav-link.primary {
            background: linear-gradient(135deg, var(--green-500), var(--green-600));
            color: white; font-weight: 600;
            box-shadow: 0 4px 14px rgba(22,163,74,0.25);
        }
        .nav-link.primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(22,163,74,0.35);
        }

        /* ====== HERO (sama persis seperti landing page) ====== */
        .hero {
            min-height: 100vh; display: flex; align-items: center;
            position: relative; overflow: hidden;
            background: linear-gradient(160deg, #f0fdf4 0%, #ecfdf5 30%, #e0f2fe 70%, #f0f9ff 100%);
        }
        .hero::before {
            content: ''; position: absolute; top: -50%; right: -20%;
            width: 800px; height: 800px; border-radius: 50%;
            background: radial-gradient(circle, rgba(34,197,94,0.08) 0%, transparent 70%);
            animation: float 20s ease-in-out infinite;
        }
        .hero::after {
            content: ''; position: absolute; bottom: -30%; left: -10%;
            width: 600px; height: 600px; border-radius: 50%;
            background: radial-gradient(circle, rgba(14,165,233,0.06) 0%, transparent 70%);
            animation: float 25s ease-in-out infinite reverse;
        }
        @keyframes float { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(30px, -40px); } }
        .hero-inner {
            max-width: 1200px; margin: 0 auto; padding: 120px 24px 80px;
            display: grid; grid-template-columns: 1fr 1fr; gap: 60px;
            align-items: center; position: relative; z-index: 1;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: white; border: 1px solid var(--green-200);
            border-radius: 100px; padding: 6px 16px 6px 8px;
            font-size: 0.82rem; font-weight: 500; color: var(--green-700);
            margin-bottom: 24px; box-shadow: 0 2px 8px rgba(22,163,74,0.08);
        }
        .hero-badge-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: var(--green-500);
            animation: pulse-dot 2s ease-in-out infinite;
        }
        @keyframes pulse-dot { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(1.3); } }
        .hero h1 {
            font-size: 3.5rem; font-weight: 800; line-height: 1.1;
            color: var(--slate-900); margin-bottom: 20px; letter-spacing: -0.03em;
        }
        .hero h1 span {
            background: linear-gradient(135deg, var(--green-600), var(--sky-500));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .hero-desc {
            font-size: 1.15rem; color: var(--slate-500);
            margin-bottom: 36px; max-width: 500px; line-height: 1.7;
        }

        /* ====== AUTH FORM CARD (di kolom kanan hero) ====== */
        .auth-card {
            background: white; border-radius: 24px; padding: 2rem 2.25rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08), 0 0 0 1px rgba(0,0,0,0.04);
            width: 100%; max-width: 420px; position: relative;
        }
        .auth-card::before {
            content: ''; position: absolute; top: -1px; left: 20%; right: 20%;
            height: 3px; background: linear-gradient(90deg, var(--green-400), var(--sky-400), var(--amber-400));
            border-radius: 0 0 4px 4px;
        }
        .auth-card-header { margin-bottom: 1.5rem; }
        .auth-card-header h2 {
            font-size: 1.3rem; font-weight: 700; color: var(--slate-900);
            margin-bottom: 0.3rem;
        }
        .auth-card-header p { font-size: 0.85rem; color: var(--slate-500); }

        /* Form fields */
        .field { margin-bottom: 1.15rem; }
        .field label { display: block; font-size: 0.82rem; font-weight: 600; color: var(--slate-700); margin-bottom: 0.4rem; }
        .field input {
            width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid var(--slate-200);
            border-radius: 10px; font-size: 0.9rem; color: var(--slate-800);
            background: var(--slate-50); transition: all 0.2s; outline: none; font-family: inherit;
        }
        .field input:focus { border-color: var(--green-500); background: white; box-shadow: 0 0 0 3px rgba(34,197,94,0.12); }
        .field input::placeholder { color: var(--slate-400); }
        .field-error { font-size: 0.78rem; color: #dc2626; margin-top: 0.35rem; }

        /* Remember row */
        .remember-row { display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; }
        .remember-row input[type="checkbox"] { width: 16px; height: 16px; accent-color: var(--green-600); border-radius: 4px; }
        .remember-row label { font-size: 0.82rem; color: var(--slate-500); }

        /* Buttons (sama seperti landing page) */
        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 14px 28px; border-radius: 12px;
            font-size: 0.95rem; font-weight: 600; text-decoration: none;
            border: none; cursor: pointer; transition: all 0.25s ease; font-family: inherit;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--green-500), var(--green-600));
            color: white; box-shadow: 0 6px 20px rgba(22,163,74,0.3); width: 100%; justify-content: center;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(22,163,74,0.4); }
        .btn-primary:active { transform: translateY(0); }

        /* Footer link */
        .auth-footer { margin-top: 1.25rem; text-align: center; font-size: 0.85rem; color: var(--slate-500); }
        .auth-footer a { color: var(--green-600); text-decoration: none; font-weight: 600; }
        .auth-footer a:hover { color: var(--green-700); text-decoration: underline; }

        /* Error / status boxes */
        .error-box {
            background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px;
            padding: 0.75rem 1rem; margin-bottom: 1.25rem; font-size: 0.82rem; color: #dc2626;
        }
        .error-box ul { list-style: none; }
        .error-box li { padding: 0.15rem 0; }
        .status-box {
            padding: 0.75rem 1rem; margin-bottom: 1.25rem; font-size: 0.82rem;
            background: var(--green-50); border: 1px solid var(--green-200);
            color: var(--green-700); border-radius: 10px;
        }

        /* ====== RESPONSIVE ====== */
        @media (max-width: 960px) {
            .hero-inner { grid-template-columns: 1fr; text-align: center; gap: 40px; }
            .hero h1 { font-size: 2.5rem; }
            .hero-desc { margin: 0 auto 36px; }
            .auth-card { margin: 0 auto; }
        }
        @media (max-width: 640px) {
            .hero h1 { font-size: 2rem; }
            .navbar-inner { height: 60px; }
            .nav-link { padding: 8px 14px; font-size: 0.82rem; }
            .hero-inner { padding: 100px 16px 60px; }
            .auth-card { padding: 1.5rem; }
        }
    </style>
</head>
<body>
    {{-- ===== NAVBAR (sama persis landing page) ===== --}}
    <nav class="navbar" id="navbar">
        <div class="navbar-inner">
            <a href="/" class="logo">
                <div class="logo-icon">🌾</div>
                CuacaTani
            </a>
            <div class="nav-links">
                @if (request()->route()->getName() === 'register')
                    <a href="{{ route('login') }}" class="nav-link">Masuk</a>
                    <a href="{{ route('register') }}" class="nav-link primary">Daftar Gratis</a>
                @else
                    <a href="{{ route('login') }}" class="nav-link primary">Masuk</a>
                    <a href="{{ route('register') }}" class="nav-link">Daftar Gratis</a>
                @endif
            </div>
        </div>
    </nav>

    {{-- ===== HERO (sama persis landing page) dengan form card ===== --}}
    <section class="hero">
        <div class="hero-inner">
            {{-- Left: brand message (sama seperti landing page) --}}
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
            </div>

            {{-- Right: form card --}}
            <div style="display:flex; justify-content:center;">
                <div class="auth-card">

                    {{-- Error --}}
                    @if ($errors->any())
                        <div class="error-box">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Session status --}}
                    @if (session('status'))
                        <div class="status-box">✅ {{ session('status') }}</div>
                    @endif

                    {{ $slot }}

                </div>
            </div>
        </div>
    </section>

    <script>
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 10) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
