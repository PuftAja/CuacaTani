<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CuacaTani') }}</title>

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

        /* ====== NAVBAR GLASS ====== */
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
        .logo span { display: inline-block; }

        .nav-links { display: flex; align-items: center; gap: 6px; }
        .nav-link {
            text-decoration: none; padding: 10px 20px; border-radius: 10px;
            font-size: 0.9rem; font-weight: 500; color: var(--slate-600);
            transition: all 0.2s ease;
        }
        .nav-link:hover { color: var(--green-700); background: var(--green-50); }
        .nav-link.active {
            color: var(--green-700); background: var(--green-50); font-weight: 600;
        }

        /* User dropdown */
        .user-menu { position: relative; margin-left: 12px; }
        .user-trigger {
            display: flex; align-items: center; gap: 8px;
            padding: 6px 12px 6px 6px; border-radius: 100px;
            border: 1px solid var(--slate-200); background: white;
            cursor: pointer; transition: all 0.2s; font-family: inherit;
        }
        .user-trigger:hover { border-color: var(--green-300); box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
        .user-avatar {
            width: 30px; height: 30px; border-radius: 50%;
            background: linear-gradient(135deg, var(--green-500), var(--green-600));
            color: white; display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem; font-weight: 700;
        }
        .user-name { font-size: 0.85rem; font-weight: 500; color: var(--slate-700); }
        .chevron { transition: transform 0.2s; color: var(--slate-400); }
        .chevron.rotate { transform: rotate(180deg); }

        .dropdown-menu {
            position: absolute; right: 0; top: calc(100% + 8px);
            background: white; border-radius: 14px; min-width: 180px;
            box-shadow: 0 12px 40px rgba(0,0,0,0.1), 0 0 0 1px rgba(0,0,0,0.03);
            padding: 6px; z-index: 200;
        }
        .drop-enter { transition: all 0.15s ease; }
        .drop-enter-start { opacity: 0; transform: translateY(-6px) scale(0.96); }
        .drop-enter-end { opacity: 1; transform: translateY(0) scale(1); }
        .dropdown-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 14px; border-radius: 10px;
            font-size: 0.85rem; font-weight: 500; color: var(--slate-700);
            text-decoration: none; border: none; background: none; cursor: pointer;
            font-family: inherit; transition: background 0.15s;
        }
        .dropdown-item:hover { background: var(--green-50); color: var(--green-700); }
        .dropdown-item svg { flex-shrink: 0; }

        /* ====== PAGE WRAPPER ====== */
        .app-shell {
            min-height: 100vh;
            background: linear-gradient(160deg, #f0fdf4 0%, #ecfdf5 30%, #e0f2fe 70%, #f0f9ff 100%);
        }
        .app-content {
            max-width: 1200px; margin: 0 auto; padding: 100px 24px 60px;
        }

        @media (max-width: 640px) {
            .navbar-inner { height: 60px; }
            .nav-link { padding: 8px 14px; font-size: 0.82rem; }
            .user-name { display: none; }
            .user-trigger { padding: 4px; }
            .app-content { padding: 80px 16px 40px; }
        }
    </style>
</head>
<body>
    <div class="app-shell">
        @include('layouts.navigation')

        <!-- Page Content -->
        <main class="app-content">
            {{ $slot }}
        </main>
    </div>

    <script>
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (navbar && window.scrollY > 10) {
                navbar.classList.add('scrolled');
            } else if (navbar) {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
