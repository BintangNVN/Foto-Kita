@extends('layouts.app')
@section('title', 'Galeri Saya')
@section('page-title', 'Galeri Saya')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h1 style="font-size:1.4rem;font-weight:800;margin-bottom:.2rem;">
            <i class="bi bi-grid-3x3-gap text-primary me-2"></i>Galeri Foto
        </h1>
        <p style="font-size:.85rem;color:var(--text-muted);margin:0;">
            {{ $photos->total() }} foto tersimpan
        </p>
    </div>
    <a href="{{ route('upload') }}" class="btn-primary-custom">
        <i class="bi bi-cloud-upload"></i> Upload Foto
    </a>
</div>

@if($photos->isEmpty())
    <div class="card-dark" style="text-align:center;padding:4rem 2rem;">
        <div style="font-size:3.5rem;margin-bottom:1rem;">
            <i class="bi bi-images text-muted"></i>
        </div>
        <div style="font-size:1rem;font-weight:600;margin-bottom:.5rem;">Galeri masih kosong</div>
        <div style="font-size:.85rem;color:var(--text-muted);margin-bottom:1.5rem;">Mulai unggah foto pertamamu sekarang!</div>
        <a href="{{ route('upload') }}" class="btn-primary-custom" style="display:inline-flex;">
            <i class="bi bi-plus-lg"></i> Upload Foto Sekarang
        </a>
    </div>
@else
    {{-- Bulk Delete Form --}}
    <form id="bulkForm" action="{{ route('photo.destroy', 0) }}" method="POST">
        @csrf @method('DELETE')
    </form>

    {{-- Grid --}}
    <div class="photo-grid mb-4">
        @foreach($photos as $photo)
        <div class="photo-card" id="photo-{{ $photo->id }}">
            <div style="position:relative; overflow:hidden;">
                <img
                    src="{{ asset('storage/'.$photo->path) }}"
                    alt="{{ $photo->title }}"
                    loading="lazy"
                    onclick="window.location='{{ route('photo.preview', $photo) }}'"
                    style="cursor:pointer;"
                >
                {{-- Hover overlay --}}
                <div class="photo-overlay"
                     style="position:absolute;inset:0;background:rgba(13,13,26,.75);
                            opacity:0;transition:opacity .2s;display:flex;align-items:center;
                            justify-content:center;gap:.5rem;"
                     onmouseenter="this.style.opacity='1'"
                     onmouseleave="this.style.opacity='0'">
                    <a href="{{ route('photo.preview', $photo) }}" class="btn-secondary-custom" style="padding:.4rem .7rem">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('download', $photo) }}" class="btn-secondary-custom" style="padding:.4rem .7rem">
                        <i class="bi bi-download"></i>
                    </a>
                    <button type="button" class="btn-danger-custom" style="padding:.4rem .7rem"
                            onclick="confirmDelete({{ $photo->id }}, '{{ addslashes($photo->title) }}')">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
            <div class="photo-card-info">
                <div class="photo-card-title">{{ $photo->title }}</div>
                <div class="photo-card-meta">
                    {{ $photo->formatted_size }} &middot; {{ $photo->created_at->format('d M Y') }}
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $photos->links('pagination::bootstrap-5') }}
    </div>
@endif

{{-- Delete Confirm Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background:var(--dark-3);border:1px solid var(--border);border-radius:16px;">
            <div class="modal-body" style="padding:2rem;text-align:center;">
                <div style="font-size:2.5rem;margin-bottom:1rem;">🗑️</div>
                <div style="font-size:1rem;font-weight:700;margin-bottom:.5rem;">Hapus Foto?</div>
                <div style="font-size:.88rem;color:var(--text-muted);margin-bottom:1.5rem;">
                    Foto "<span id="deletePhotoName" style="color:var(--text);font-weight:600;"></span>" akan dihapus permanen.
                </div>
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn-danger-custom" id="confirmDeleteBtn" onclick="doDelete()">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let deleteId = null;
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

    function confirmDelete(id, name) {
        deleteId = id;
        document.getElementById('deletePhotoName').textContent = name;
        deleteModal.show();
    }

    function doDelete() {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/photo/${deleteId}`;
        form.innerHTML = `@csrf @method('DELETE')`;
        // Re-build the CSRF & METHOD tokens
        form.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}">'
                       + '<input type="hidden" name="_method" value="DELETE">';
        document.body.appendChild(form);
        form.submit();
    }
</script>
@endpush
