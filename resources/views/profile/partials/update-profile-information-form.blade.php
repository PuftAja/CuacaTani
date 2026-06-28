<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div>
            <label for="name" style="display:block; font-size:0.82rem; font-weight:600; color:#334155; margin-bottom:0.4rem;">Nama</label>
            <x-text-input id="name" name="name" type="text"
                class="mt-1 block w-full" style="width:100%; padding:0.65rem 0.9rem; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.9rem; background:#f8fafc; font-family:inherit;"
                :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" style="display:block; font-size:0.82rem; font-weight:600; color:#334155; margin-bottom:0.4rem;">Email</label>
            <x-text-input id="email" name="email" type="email"
                class="mt-1 block w-full" style="width:100%; padding:0.65rem 0.9rem; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.9rem; background:#f8fafc; font-family:inherit;"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div style="margin-top:0.75rem; padding:0.6rem 0.9rem; background:#fef9c3; border:1px solid #fde68a; border-radius:10px; font-size:0.82rem; color:#92400e;">
                    Email belum terverifikasi.
                    <button form="send-verification" style="background:none; border:none; color:#b45309; text-decoration:underline; cursor:pointer; font-size:0.82rem; font-family:inherit;">
                        Kirim ulang email verifikasi.
                    </button>
                    @if (session('status') === 'verification-link-sent')
                        <p style="margin-top:0.35rem; font-weight:600; color:#166534;">✅ Link verifikasi baru telah dikirim.</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" style="padding:0.65rem 1.5rem; border:none; border-radius:10px; background:linear-gradient(135deg,#22c55e,#16a34a); color:white; font-size:0.85rem; font-weight:600; cursor:pointer; box-shadow:0 4px 14px rgba(22,163,74,0.25); transition:all 0.2s; font-family:inherit;">
                💾 Simpan
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                   style="font-size:0.82rem; color:#166534;">✅ Tersimpan</p>
            @endif
        </div>
    </form>
</section>
