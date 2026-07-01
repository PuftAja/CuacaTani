<nav class="navbar" id="navbar">
    <div class="navbar-inner">
        <a href="{{ route('dashboard') }}" class="logo">
            <div class="logo-icon">🌾</div>
            <span>CuacaTani</span>
        </a>
        <div class="nav-links">
            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                Beranda
            </a>
            <a href="{{ route('lahan.index') }}"
               class="nav-link {{ request()->routeIs('lahan.*') ? 'active' : '' }}">
                Data Lahan
            </a>

            {{-- User dropdown --}}
            <div class="user-menu" x-data="{ open: false }" @click.away="open = false">
                <button @click="open = !open" class="user-trigger">
                    <span class="user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <svg class="chevron" :class="{ 'rotate': open }" width="12" height="12" viewBox="0 0 12 12" fill="none">
                        <path d="M3 5L6 8L9 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <div x-show="open" class="dropdown-menu"
                     x-transition:enter="drop-enter"
                     x-transition:enter-start="drop-enter-start"
                     x-transition:enter-end="drop-enter-end"
                     style="display: none;">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item" style="width:100%; text-align:left;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
