@extends('layouts.app')
@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h1 style="font-size:1.4rem;font-weight:800;margin-bottom:.2rem;">
            <i class="bi bi-people text-primary me-2"></i>Manajemen User
        </h1>
        <p style="font-size:.85rem;color:var(--text-muted);">{{ $users->total() }} user terdaftar</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn-primary-custom">
        <i class="bi bi-person-plus"></i> Tambah User
    </a>
</div>

{{-- Search / Filter --}}
<form method="GET" action="{{ route('admin.users.index') }}" class="card-dark mb-4" style="padding:1rem 1.25rem;">
    <div class="row g-2 align-items-end">
        <div class="col-md-7">
            <label class="form-label">Cari User</label>
            <div style="position:relative;">
                <i class="bi bi-search" style="position:absolute;left:.9rem;top:50%;transform:translateY(-50%);color:var(--text-muted);"></i>
                <input type="text" name="search" class="form-control" style="padding-left:2.4rem!important;"
                       placeholder="Nama atau email..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select">
                <option value="">Semua Role</option>
                <option value="user"  {{ request('role')==='user'  ? 'selected':'' }}>User</option>
                <option value="admin" {{ request('role')==='admin' ? 'selected':'' }}>Admin</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn-primary-custom w-100" style="justify-content:center;">
                <i class="bi bi-funnel"></i> Filter
            </button>
        </div>
    </div>
</form>

{{-- Table --}}
@if($users->isEmpty())
    <div class="card-dark" style="text-align:center;padding:4rem 2rem;">
        <div style="font-size:3.5rem;margin-bottom:1rem;">
            <i class="bi bi-people text-muted"></i>
        </div>
        <div style="font-size:1rem;font-weight:600;margin-bottom:.5rem;">Tidak ada user ditemukan</div>
        <div style="font-size:.85rem;color:var(--text-muted);margin-bottom:1.5rem;">Belum ada user yang terdaftar di sistem</div>
        <a href="{{ route('admin.users.create') }}" class="btn-primary-custom" style="display:inline-flex;">
            <i class="bi bi-person-plus"></i> Tambah User Pertama
        </a>
    </div>
@else
    {{-- User Cards Grid --}}
    <div class="row g-3">
        @foreach($users as $user)
        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="card-dark h-100" style="transition: transform .2s, box-shadow .2s;"
                 onmouseenter="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,.2)';"
                 onmouseleave="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow)';">
                <div class="card-body" style="padding:1.5rem;">
                    {{-- User Header --}}
                    <div style="display:flex;align-items:start;gap:1rem;margin-bottom:1rem;">
                        <div style="width:50px;height:50px;border-radius:50%;
                                    background:linear-gradient(135deg,var(--primary),var(--accent));
                                    display:flex;align-items:center;justify-content:center;
                                    font-weight:700;font-size:1.1rem;color:#fff;flex-shrink:0;">
                            {{ strtoupper(substr($user->name,0,1)) }}
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:1rem;font-weight:700;margin-bottom:.2rem;
                                        white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $user->name }}
                            </div>
                            <div style="font-size:.8rem;color:var(--text-muted);
                                        white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $user->email }}
                            </div>
                        </div>
                        <div style="flex-shrink:0;">
                            @if($user->role === 'admin')
                                <span style="background:linear-gradient(135deg,var(--primary),var(--primary-d));
                                             color:#fff;padding:4px 12px;border-radius:20px;
                                             font-size:.7rem;font-weight:700;display:inline-flex;
                                             align-items:center;gap:.3rem;">
                                    <i class="bi bi-shield-check"></i> Admin
                                </span>
                            @else
                                <span style="background:linear-gradient(135deg,var(--accent),#059669);
                                             color:#fff;padding:4px 12px;border-radius:20px;
                                             font-size:.7rem;font-weight:700;display:inline-flex;
                                             align-items:center;gap:.3rem;">
                                    <i class="bi bi-person"></i> User
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- User Stats --}}
                    <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:.75rem;margin-bottom:1.25rem;">
                        <div style="background:rgba(79,70,229,.1);border:1px solid rgba(79,70,229,.2);
                                    border-radius:10px;padding:.75rem;text-align:center;">
                            <div style="font-size:1.2rem;font-weight:800;color:var(--primary);line-height:1;">
                                {{ $user->photos_count }}
                            </div>
                            <div style="font-size:.7rem;color:var(--text-muted);font-weight:600;">
                                Foto
                            </div>
                        </div>
                        <div style="background:rgba(245,158,11,.1);border:1px solid rgba(245,158,11,.2);
                                    border-radius:10px;padding:.75rem;text-align:center;">
                            <div style="font-size:.9rem;font-weight:700;color:#f59e0b;line-height:1;">
                                {{ $user->created_at->format('M Y') }}
                            </div>
                            <div style="font-size:.7rem;color:var(--text-muted);font-weight:600;">
                                Bergabung
                            </div>
                        </div>
                    </div>

                    {{-- User Actions --}}
                    <div style="display:flex;gap:.5rem;">
                        <a href="{{ route('admin.users.edit', $user) }}"
                           class="btn-secondary-custom flex-fill" style="justify-content:center;padding:.6rem;">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                              onsubmit="return confirm('Hapus user {{ addslashes($user->name) }} dan semua fotonya?')"
                              style="flex:1;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger-custom w-100" style="padding:.6rem;">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

{{-- Pagination --}}
@if($users->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $users->links('pagination::bootstrap-5') }}
</div>
@endif

@endsection
