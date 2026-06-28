<x-guest-layout>

<div class="auth-card-header">
    <h2>Buat Akun Baru 🌾</h2>
    <p>Daftar gratis dan mulai dapatkan rekomendasi bertani berbasis cuaca</p>
</div>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="field">
        <label for="name">Nama Lengkap</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}"
               placeholder="Nama Anda" required autofocus autocomplete="name">
        @error('name') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}"
               placeholder="petani@email.com" required autocomplete="username">
        @error('email') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input id="password" type="password" name="password"
               placeholder="Minimal 8 karakter" required autocomplete="new-password">
        @error('password') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="password_confirmation">Konfirmasi Password</label>
        <input id="password_confirmation" type="password" name="password_confirmation"
               placeholder="Ulangi password" required autocomplete="new-password">
    </div>

    <button type="submit" class="btn btn-primary">
        Daftar Gratis
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </button>
</form>

<div class="auth-footer">
    Sudah punya akun?
    <a href="{{ route('login') }}">Masuk</a>
</div>

</x-guest-layout>
