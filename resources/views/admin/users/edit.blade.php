@extends('layouts.app')
@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')

<div class="mb-3">
    <a href="{{ route('admin.users.index') }}" style="color:var(--text-muted);text-decoration:none;font-size:.88rem;font-weight:500;">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar User
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        {{-- User Stats Mini Card --}}
        <div class="card-dark mb-3" style="padding:1rem 1.25rem;">
            <div style="display:flex;align-items:center;gap:1rem;">
                <div style="width:48px;height:48px;border-radius:50%;
                            background:linear-gradient(135deg,var(--primary),var(--accent));
                            display:flex;align-items:center;justify-content:center;
                            font-size:1.2rem;font-weight:800;color:#fff;flex-shrink:0;">
                    {{ strtoupper(substr($user->name,0,1)) }}
                </div>
                <div>
                    <div style="font-weight:700;font-size:.95rem;">{{ $user->name }}</div>
                    <div style="font-size:.78rem;color:var(--text-muted);">
                        Bergabung sejak {{ $user->created_at->format('d M Y') }}
                        &middot; {{ $user->photos_count ?? $user->photos()->count() }} foto
                    </div>
                </div>
            </div>
        </div>

        <div class="card-dark">
            <div class="card-header">
                <i class="bi bi-pencil me-2" style="color:var(--primary)"></i>Edit Data User
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user) }}" method="POST" novalidate>
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label" for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback d-block" style="color:var(--secondary);font-size:.8rem;margin-top:.3rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback d-block" style="color:var(--secondary);font-size:.8rem;margin-top:.3rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="role">Role</label>
                        <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="user"  {{ old('role',$user->role)==='user'  ? 'selected':'' }}>
                                <i class="bi bi-person"></i> User
                            </option>
                            <option value="admin" {{ old('role',$user->role)==='admin' ? 'selected':'' }}>
                                <i class="bi bi-shield-check"></i> Admin
                            </option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback d-block" style="color:var(--secondary);font-size:.8rem;margin-top:.3rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="background:rgba(108,99,255,.05);border:1px solid var(--border);
                                border-radius:12px;padding:1rem;margin-bottom:1rem;">
                        <div style="font-size:.78rem;color:var(--text-muted);margin-bottom:.75rem;font-weight:600;">
                            <i class="bi bi-lock me-1"></i> Ganti Password (kosongkan jika tidak ingin mengubah)
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Minimal 6 karakter">
                            @error('password')
                                <div class="invalid-feedback d-block" style="color:var(--secondary);font-size:.8rem;margin-top:.3rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation"
                                   class="form-control" placeholder="Ulangi password baru">
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn-primary-custom">
                            <i class="bi bi-check-lg"></i> Simpan Perubahan
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
