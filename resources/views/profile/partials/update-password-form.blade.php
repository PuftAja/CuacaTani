<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" style="display:block; font-size:0.82rem; font-weight:600; color:#334155; margin-bottom:0.4rem;">Password Saat Ini</label>
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="mt-1 block w-full" style="width:100%; padding:0.65rem 0.9rem; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.9rem; background:#f8fafc; font-family:inherit;"
                autocomplete="current-password" placeholder="Masukkan password saat ini" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password" style="display:block; font-size:0.82rem; font-weight:600; color:#334155; margin-bottom:0.4rem;">Password Baru</label>
            <x-text-input id="update_password_password" name="password" type="password"
                class="mt-1 block w-full" style="width:100%; padding:0.65rem 0.9rem; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.9rem; background:#f8fafc; font-family:inherit;"
                autocomplete="new-password" placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password_confirmation" style="display:block; font-size:0.82rem; font-weight:600; color:#334155; margin-bottom:0.4rem;">Konfirmasi Password</label>
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full" style="width:100%; padding:0.65rem 0.9rem; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.9rem; background:#f8fafc; font-family:inherit;"
                autocomplete="new-password" placeholder="Ulangi password baru" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" style="padding:0.65rem 1.5rem; border:none; border-radius:10px; background:linear-gradient(135deg,#f59e0b,#d97706); color:white; font-size:0.85rem; font-weight:600; cursor:pointer; box-shadow:0 4px 14px rgba(245,158,11,0.25); transition:all 0.2s; font-family:inherit;">
                🔐 Ubah Password
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                   style="font-size:0.82rem; color:#166534;">✅ Tersimpan</p>
            @endif
        </div>
    </form>
</section>
