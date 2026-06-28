<x-guest-layout>

<div class="auth-card-header">
    <h2>Selamat Datang Kembali 👋</h2>
    <p>Masuk ke akun CuacaTani untuk mulai bertani lebih cerdas</p>
</div>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="field">
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}"
               placeholder="petani@email.com" required autofocus autocomplete="username">
        @error('email') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input id="password" type="password" name="password"
               placeholder="Masukkan password" required autocomplete="current-password">
        @error('password') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="remember-row">
        <input id="remember_me" type="checkbox" name="remember">
        <label for="remember_me">Ingat saya</label>
    </div>

    <button type="submit" class="btn btn-primary">
        Masuk
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </button>
</form>

<div class="auth-footer">
    Belum punya akun?
    <a href="{{ route('register') }}">Daftar sekarang</a>
</div>

</x-guest-layout>
