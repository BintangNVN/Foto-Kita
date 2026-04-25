@extends('layouts.app')
@section('title', 'Manajemen Foto')
@section('page-title', 'Manajemen Foto')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h1 style="font-size:1.4rem;font-weight:800;margin-bottom:.2rem;">
            <i class="bi bi-images text-primary me-2"></i>Semua Foto
        </h1>
        <p style="font-size:.85rem;color:var(--text-muted);">{{ $photos->total() }} foto dari seluruh user</p>
    </div>
</div>

{{-- ── Search / Filter ── --}}
<form method="GET" action="{{ route('admin.photos.index') }}" class="card-dark mb-4" style="padding:1rem 1.25rem;">
    <div class="row g-2 align-items-end">
        <div class="col-md-7">
            <label class="form-label">Cari Foto / User</label>
            <div style="position:relative;">
                <i class="bi bi-search" style="position:absolute;left:.9rem;top:50%;transform:translateY(-50%);color:var(--text-muted);"></i>
                <input type="text" name="search" class="form-control" style="padding-left:2.4rem!important;"
                       placeholder="Nama file, judul, atau nama user..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label">Filter User ID</label>
            <input type="number" name="user_id" class="form-control" placeholder="User ID..." value="{{ request('user_id') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn-primary-custom w-100" style="justify-content:center;">
                <i class="bi bi-funnel"></i> Filter
            </button>
        </div>
    </div>
</form>

{{-- ── Bulk Delete Form ── --}}
<form id="bulkDeleteForm" action="{{ route('admin.photos.bulk-destroy') }}" method="POST">
    @csrf

    @if($photos->isNotEmpty())
    <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
        <button type="button" class="btn-secondary-custom" onclick="toggleSelectAll()">
            <i class="bi bi-check-all"></i> Pilih Semua
        </button>
        <button type="submit" class="btn-danger-custom" id="bulkDeleteBtn" style="display:none;"
                onclick="return confirm('Hapus semua foto yang dipilih?')">
            <i class="bi bi-trash"></i> Hapus yang Dipilih (<span id="selectedCount">0</span>)
        </button>
    </div>
    @endif

    {{-- ── Photo Grid ── --}}
    @if($photos->isEmpty())
        <div class="card-dark" style="text-align:center;padding:4rem 2rem;">
            <div style="font-size:3rem;margin-bottom:1rem;">📭</div>
            <div style="font-size:.95rem;font-weight:600;">Tidak ada foto ditemukan</div>
        </div>
    @else
        <div class="photo-grid mb-4">
            @foreach($photos as $photo)
            <div class="photo-card" style="position:relative;" id="pcard-{{ $photo->id }}">
                {{-- Checkbox --}}
                <div style="position:absolute;top:8px;left:8px;z-index:10;">
                    <input type="checkbox" name="photo_ids[]" value="{{ $photo->id }}"
                           class="photo-checkbox"
                           style="width:18px;height:18px;accent-color:var(--primary);cursor:pointer;"
                           onchange="updateBulkBtn()">
                </div>

                <img src="{{ asset('storage/'.$photo->path) }}"
                     alt="{{ $photo->title }}" loading="lazy"
                     style="width:100%;height:165px;object-fit:cover;display:block;">

                <div class="photo-card-info">
                    <div class="photo-card-title">{{ $photo->title ?? $photo->filename }}</div>
                    <div class="photo-card-meta" style="margin-bottom:.4rem;">
                        👤 {{ $photo->user->name }}<br>
                        {{ $photo->formatted_size }} &middot; {{ $photo->created_at->format('d M Y') }}
                    </div>
                    <form action="{{ route('admin.photos.destroy', $photo) }}" method="POST"
                          onsubmit="return confirm('Hapus foto ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-danger-custom" style="width:100%;justify-content:center;padding:.35rem;">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {{ $photos->links('pagination::bootstrap-5') }}
        </div>
    @endif
</form>

@endsection

@push('scripts')
<script>
    let allSelected = false;

    function toggleSelectAll() {
        allSelected = !allSelected;
        document.querySelectorAll('.photo-checkbox').forEach(cb => cb.checked = allSelected);
        updateBulkBtn();
    }

    function updateBulkBtn() {
        const checked = document.querySelectorAll('.photo-checkbox:checked').length;
        const btn = document.getElementById('bulkDeleteBtn');
        const cnt = document.getElementById('selectedCount');
        if (btn) {
            btn.style.display = checked > 0 ? 'inline-flex' : 'none';
            if (cnt) cnt.textContent = checked;
        }
    }
</script>
@endpush
