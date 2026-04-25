@extends('layouts.app')
@section('title', $photo->title)
@section('page-title', 'Preview Foto')

@section('content')

<div class="mb-3">
    <a href="{{ route('gallery') }}" style="color:var(--text-muted);text-decoration:none;font-size:.88rem;font-weight:500;">
        <i class="bi bi-arrow-left"></i> Kembali ke Galeri
    </a>
</div>

<div class="row g-4 align-items-start">
    {{-- ── Photo Preview ── --}}
    <div class="col-lg-8">
        <div class="card-dark" style="overflow:hidden;">
            <div style="background:var(--dark); display:flex; align-items:center; justify-content:center;
                        min-height:420px; padding:1rem;">
                <img src="{{ asset('storage/'.$photo->path) }}"
                     alt="{{ $photo->title }}"
                     id="previewImg"
                     style="max-width:100%; max-height:70vh; border-radius:12px;
                            box-shadow:0 16px 48px rgba(0,0,0,.5); transition:transform .3s;">
            </div>

            {{-- Zoom controls --}}
            <div style="padding:.75rem 1.25rem; border-top:1px solid var(--border);
                        display:flex; gap:.5rem; align-items:center;">
                <span style="font-size:.8rem;color:var(--text-muted);margin-right:.5rem;">Zoom:</span>
                <button class="btn-secondary-custom" onclick="zoomImg(1.25)"><i class="bi bi-zoom-in"></i></button>
                <button class="btn-secondary-custom" onclick="zoomImg(0.8)"><i class="bi bi-zoom-out"></i></button>
                <button class="btn-secondary-custom" onclick="resetZoom()"><i class="bi bi-arrow-counterclockwise"></i> Reset</button>
            </div>
        </div>
    </div>

    {{-- ── Photo Info & Actions ── --}}
    <div class="col-lg-4">
        {{-- Info Card --}}
        <div class="card-dark mb-3">
            <div class="card-header">
                <i class="bi bi-info-circle me-2" style="color:var(--primary)"></i>Informasi Foto
            </div>
            <div class="card-body" style="padding:1.25rem;">
                <div style="margin-bottom:1rem;">
                    <div style="font-size:1.05rem;font-weight:700;margin-bottom:.25rem;">{{ $photo->title }}</div>
                    <div style="font-size:.8rem;color:var(--text-muted);">{{ $photo->filename }}</div>
                </div>

                @php
                    $details = [
                        ['icon'=>'bi-calendar3',    'label'=>'Tanggal Upload', 'value'=> $photo->created_at->format('d M Y, H:i')],
                        ['icon'=>'bi-hdd',          'label'=>'Ukuran File',    'value'=> $photo->formatted_size],
                        ['icon'=>'bi-file-earmark', 'label'=>'Tipe File',      'value'=> strtoupper($photo->mime_type)],
                    ];
                @endphp

                @foreach($details as $d)
                <div style="display:flex;align-items:center;gap:.75rem;padding:.6rem 0;
                            border-bottom:1px solid rgba(255,255,255,.04);">
                    <div style="width:32px;height:32px;border-radius:8px;
                                background:rgba(108,99,255,.12);display:flex;
                                align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="bi {{ $d['icon'] }}" style="color:var(--primary);font-size:.9rem;"></i>
                    </div>
                    <div>
                        <div style="font-size:.7rem;color:var(--text-muted);font-weight:500;">{{ $d['label'] }}</div>
                        <div style="font-size:.85rem;font-weight:600;">{{ $d['value'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="card-dark">
            <div class="card-body" style="padding:1.25rem;display:flex;flex-direction:column;gap:.6rem;">
                <a href="{{ route('download', $photo) }}" class="btn-primary-custom" style="justify-content:center;">
                    <i class="bi bi-download"></i> Download Foto
                </a>
                <button type="button" class="btn-danger-custom" style="justify-content:center;"
                        onclick="document.getElementById('deleteModal').style.display='flex'">
                    <i class="bi bi-trash"></i> Hapus Foto
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ── Delete Confirm Modal ── --}}
<div id="deleteModal"
     style="display:none;position:fixed;inset:0;z-index:9999;
            background:rgba(0,0,0,.7);backdrop-filter:blur(8px);
            align-items:center;justify-content:center;">
    <div style="background:var(--dark-3);border:1px solid var(--border);border-radius:20px;
                padding:2.5rem;max-width:380px;width:calc(100% - 2rem);text-align:center;">
        <div style="font-size:3rem;margin-bottom:1rem;">🗑️</div>
        <div style="font-size:1.05rem;font-weight:700;margin-bottom:.5rem;">Hapus Foto Ini?</div>
        <div style="font-size:.85rem;color:var(--text-muted);margin-bottom:1.8rem;">
            Foto <strong style="color:var(--text);">{{ $photo->title }}</strong> akan dihapus secara permanen dan tidak bisa dikembalikan.
        </div>
        <div style="display:flex;gap:.75rem;justify-content:center;">
            <button onclick="document.getElementById('deleteModal').style.display='none'"
                    class="btn-secondary-custom">Batal</button>
            <form action="{{ route('photo.destroy', $photo) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger-custom">
                    <i class="bi bi-trash"></i> Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let scale = 1;
    function zoomImg(factor) {
        scale = Math.min(Math.max(scale * factor, 0.5), 3);
        document.getElementById('previewImg').style.transform = `scale(${scale})`;
    }
    function resetZoom() {
        scale = 1;
        document.getElementById('previewImg').style.transform = 'scale(1)';
    }
</script>
@endpush
