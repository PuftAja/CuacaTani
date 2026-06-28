<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            👤 Profil Saya
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Profile card header --}}
            <div style="background:linear-gradient(135deg,#f0fdf4,#ecfdf5); border:1px solid #dcfce7; border-radius:14px; padding:1.75rem; display:flex; align-items:center; gap:1.25rem; flex-wrap:wrap;">
                <div style="width:64px; height:64px; background:linear-gradient(135deg,#22c55e,#15803d); border-radius:16px; display:flex; align-items:center; justify-content:center; font-size:2rem; color:white; box-shadow:0 4px 14px rgba(22,163,74,0.3); flex-shrink:0;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div style="font-size:1.15rem; font-weight:700; color:#1e293b;">{{ Auth::user()->name }}</div>
                    <div style="font-size:0.85rem; color:#64748b; margin-top:0.15rem;">{{ Auth::user()->email }}</div>
                </div>
                <div style="margin-left:auto; display:flex; gap:0.5rem;">
                    <span style="font-size:0.75rem; padding:0.3rem 0.75rem; border-radius:9999px; font-weight:500; background:#dcfce7; color:#166534;">
                        🌾 {{ Auth::user()->lahans_count ?? Auth::user()->lahans->count() }} Lahan
                    </span>
                </div>
            </div>

            {{-- Profile Information --}}
            <div style="background:white; border-radius:14px; box-shadow:0 2px 12px rgba(0,0,0,0.06); overflow:hidden;">
                <div style="padding:1.5rem 2rem; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:0.75rem;">
                    <div style="width:36px; height:36px; background:#f0f9ff; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1rem;">📋</div>
                    <div>
                        <div style="font-size:0.95rem; font-weight:700; color:#1e293b;">Informasi Profil</div>
                        <div style="font-size:0.78rem; color:#94a3b8;">Perbarui data akun Anda</div>
                    </div>
                </div>
                <div style="padding:1.5rem 2rem;">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Update Password --}}
            <div style="background:white; border-radius:14px; box-shadow:0 2px 12px rgba(0,0,0,0.06); overflow:hidden;">
                <div style="padding:1.5rem 2rem; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:0.75rem;">
                    <div style="width:36px; height:36px; background:#fef3c7; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1rem;">🔐</div>
                    <div>
                        <div style="font-size:0.95rem; font-weight:700; color:#1e293b;">Ubah Password</div>
                        <div style="font-size:0.78rem; color:#94a3b8;">Pastikan akun tetap aman</div>
                    </div>
                </div>
                <div style="padding:1.5rem 2rem;">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete Account --}}
            <div style="background:white; border-radius:14px; box-shadow:0 2px 12px rgba(0,0,0,0.06); overflow:hidden; border:1px solid #fecaca;">
                <div style="padding:1.5rem 2rem; border-bottom:1px solid #fef2f2; display:flex; align-items:center; gap:0.75rem;">
                    <div style="width:36px; height:36px; background:#fef2f2; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1rem;">⚠️</div>
                    <div>
                        <div style="font-size:0.95rem; font-weight:700; color:#dc2626;">Hapus Akun</div>
                        <div style="font-size:0.78rem; color:#94a3b8;">Tindakan ini tidak dapat dibatalkan</div>
                    </div>
                </div>
                <div style="padding:1.5rem 2rem;">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
