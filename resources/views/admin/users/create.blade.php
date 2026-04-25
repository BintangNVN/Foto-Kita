@extends('layouts.app')
@section('title', 'Tambah User')
@section('page-title', 'Tambah User')

@section('content')

<div class="mb-3">
    <a href="{{ route('admin.users.index') }}" style="color:var(--text-muted);text-decoration:none;font-size:.88rem;font-weight:500;">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar User
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card-dark">
            <div class="card-header">
                <i class="bi bi-person-plus me-2" style="color:var(--primary)"></i>Tambah User Baru
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST" novalidate>
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" placeholder="Nama lengkap user" required>
                        @error('name')
                            <div class="invalid-feedback d-block" style="color:var(--secondary);font-size:.8rem;margin-top:.3rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" placeholder="email@contoh.com" required>
                        @error('email')
                            <div class="invalid-feedback d-block" style="color:var(--secondary);font-size:.8rem;margin-top:.3rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="role">Role</label>
                        <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="user"  {{ old('role','user')==='user'  ? 'selected':'' }}>
                                <i class="bi bi-person"></i> User
                            </option>
                            <option value="admin" {{ old('role')==='admin' ? 'selected':'' }}>
                                <i class="bi bi-shield-check"></i> Admin
                            </option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback d-block" style="color:var(--secondary);font-size:.8rem;margin-top:.3rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" id="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Minimal 6 karakter" required>
                        @error('password')
                            <div class="invalid-feedback d-block" style="color:var(--secondary);font-size:.8rem;margin-top:.3rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control" placeholder="Ulangi password" required>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-primary-custom">
                            <i class="bi bi-person-plus"></i> Simpan User
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn-secondary-custom">
                            <i class="bi bi-x-lg"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
