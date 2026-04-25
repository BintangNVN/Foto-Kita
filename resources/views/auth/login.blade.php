@extends('layouts.auth')
@section('title', 'Masuk')

@section('content')
<div class="auth-title">Selamat datang kembali 👋</div>
<div class="auth-subtitle">Masuk ke akun FotoKita Anda</div>

<form action="{{ route('login.post') }}" method="POST" novalidate>
    @csrf

    <div class="form-group">
        <label class="form-label" for="email">Email</label>
        <div class="input-icon-wrap">
            <i class="bi bi-envelope input-icon"></i>
            <input
                type="email"
                id="email"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                placeholder="nama@email.com"
                value="{{ old('email') }}"
                autocomplete="email"
                required
            >
        </div>
        @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <div class="input-icon-wrap">
            <i class="bi bi-lock input-icon"></i>
            <input
                type="password"
                id="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="••••••••"
                autocomplete="current-password"
                required
            >
        </div>
        @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="remember-row">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember">Ingat saya</label>
        </div>
    </div>

    <button type="submit" class="btn-auth">
        <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
    </button>
</form>

<div class="auth-divider">
    Belum punya akun? <a href="{{ route('register') }}" class="auth-link">Daftar sekarang</a>
</div>
@endsection
