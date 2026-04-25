@extends('layouts.auth')
@section('title', 'Daftar Akun')

@section('content')
<div class="auth-title">Buat akun baru ✨</div>
<div class="auth-subtitle">Bergabung dengan FotoKita dan mulai simpan momen Anda</div>

<form action="{{ route('register.post') }}" method="POST" novalidate>
    @csrf

    <div class="form-group">
        <label class="form-label" for="name">Nama Lengkap</label>
        <div class="input-icon-wrap">
            <i class="bi bi-person input-icon"></i>
            <input
                type="text"
                id="name"
                name="name"
                class="form-control @error('name') is-invalid @enderror"
                placeholder="Nama Anda"
                value="{{ old('name') }}"
                autocomplete="name"
                required
            >
        </div>
        @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

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
                placeholder="Minimal 6 karakter"
                autocomplete="new-password"
                required
            >
        </div>
        @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group" style="margin-bottom:1.5rem">
        <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
        <div class="input-icon-wrap">
            <i class="bi bi-lock-fill input-icon"></i>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                class="form-control"
                placeholder="Ulangi password"
                autocomplete="new-password"
                required
            >
        </div>
    </div>

    <button type="submit" class="btn-auth">
        <i class="bi bi-person-plus me-1"></i> Buat Akun
    </button>
</form>

<div class="auth-divider">
    Sudah punya akun? <a href="{{ route('login') }}" class="auth-link">Masuk di sini</a>
</div>
@endsection
