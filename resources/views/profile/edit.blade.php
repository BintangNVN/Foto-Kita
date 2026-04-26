@extends('layouts.app')
@section('title', 'Edit Profil')
@section('page-title', 'Edit Profil')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-dark">
            <div class="card-header">
                <i class="bi bi-person-gear me-2" style="color:var(--primary)"></i>Edit Profil
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        {{-- Profile Picture --}}
                        <div class="col-12 text-center">
                            <div class="mb-3">
                                <label for="profile_picture" class="form-label">Foto Profil</label>
                                <div class="d-flex flex-column align-items-center">
                                    <div class="profile-picture-container mb-3">
                                        <img id="profilePreview" src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://via.placeholder.com/120x120/4f46e5/ffffff?text=User' }}" alt="Profile Picture" class="profile-picture">
                                    </div>
                                    <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*" onchange="previewImage(event)">
                                    <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB.</small>
                                </div>
                            </div>
                        </div>

                        {{-- Name --}}
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-dark" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control form-control-dark" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>

                        {{-- Current Password --}}
                        <div class="col-md-6">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <input type="password" class="form-control form-control-dark" id="current_password" name="current_password">
                            <small class="text-muted">Diperlukan untuk mengubah password.</small>
                        </div>

                        {{-- New Password --}}
                        <div class="col-md-6">
                            <label for="new_password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control form-control-dark" id="new_password" name="new_password">
                            <small class="text-muted">Minimal 8 karakter.</small>
                        </div>

                        {{-- Confirm New Password --}}
                        <div class="col-12">
                            <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control form-control-dark" id="new_password_confirmation" name="new_password_confirmation">
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn-primary-custom">
                            <i class="bi bi-check-lg"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .profile-picture-container {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid var(--primary);
        margin: 0 auto;
    }

    .profile-picture {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .form-control-dark {
        background: rgba(30, 41, 59, 0.8);
        border: 1px solid var(--border);
        color: var(--text);
    }

    .form-control-dark:focus {
        background: rgba(30, 41, 59, 0.9);
        border-color: var(--primary);
        color: var(--text);
        box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-d) 100%);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
    }

    .btn-primary-custom:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow);
        color: white;
        text-decoration: none;
    }
</style>
@endpush

@push('scripts')
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profilePreview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush