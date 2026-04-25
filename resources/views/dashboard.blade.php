@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- ── Greeting ── --}}
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h1 style="font-size:1.5rem; font-weight:800; margin-bottom:.25rem;">
            <i class="bi bi-hand-wave text-warning me-2"></i>Halo, {{ $user->name }}
        </h1>
        <p style="font-size:.88rem; color:var(--text-muted); margin:0;">
            Selamat datang di FotoKita. Yuk abadikan momen hari ini!
        </p>
    </div>
    <a href="{{ route('upload') }}" class="btn-primary-custom">
        <i class="bi bi-cloud-upload"></i> Upload Foto
    </a>
</div>

{{-- ── Stat Cards ── --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(79,70,229,.15);">
                <i class="bi bi-camera text-primary"></i>
            </div>
            <div>
                <div class="stat-value" style="color:#4f46e5;">{{ $total }}</div>
                <div class="stat-label">Total Foto</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(16,185,129,.12);">
                <i class="bi bi-sunrise text-success"></i>
            </div>
            <div>
                <div class="stat-value" style="color:#10b981;">{{ $today }}</div>
                <div class="stat-label">Upload Hari Ini</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(236,72,153,.12);">
                <i class="bi bi-heart text-danger"></i>
            </div>
            <div>
                <div class="stat-value" style="color:#ec4899;">{{ $total > 0 ? 'Aktif' : 'Mulai' }}</div>
                <div class="stat-label">Status Akun</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(255,193,7,.12);">
                <i class="bi bi-clock text-warning"></i>
            </div>
            <div>
                <div class="stat-value" style="color:#f59e0b;" id="clockStat">--:--</div>
                <div class="stat-label">Jam Sekarang</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- ── Recent Photos ── --}}
    <div class="col-lg-7">
        <div class="card-dark">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-images me-2" style="color:var(--primary)"></i>Foto Terbaru</span>
                <a href="{{ route('gallery') }}" style="font-size:.8rem; color:var(--primary); text-decoration:none; font-weight:600;">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="card-body">
                @if($recent->isEmpty())
                    <div style="text-align:center; padding:2rem; color:var(--text-muted);">
                        <div style="font-size:2.5rem; margin-bottom:.75rem;">
                            <i class="bi bi-image text-muted"></i>
                        </div>
                        <div style="font-size:.9rem; font-weight:500;">Belum ada foto. Yuk upload foto pertamamu!</div>
                        <a href="{{ route('upload') }}" class="btn-primary-custom mt-3" style="display:inline-flex">
                            <i class="bi bi-plus-lg"></i> Upload Sekarang
                        </a>
                    </div>
                @else
                    <div class="photo-grid">
                        @foreach($recent as $photo)
                        <a href="{{ route('photo.preview', $photo) }}" class="photo-card" style="text-decoration:none; color:inherit;">
                            <img src="{{ asset('storage/'.$photo->path) }}" alt="{{ $photo->title }}" loading="lazy">
                            <div class="photo-card-info">
                                <div class="photo-card-title">{{ $photo->title }}</div>
                                <div class="photo-card-meta">{{ $photo->created_at->diffForHumans() }}</div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── News Feed ── --}}
    <div class="col-lg-5">
        <div class="card-dark h-100">
            <div class="card-header">
                <i class="bi bi-newspaper me-2" style="color:var(--secondary)"></i>Berita Fotografi
            </div>
            <div class="card-body" style="padding:1rem;">
                @foreach($news as $item)
                <div style="padding:.9rem; border-radius:12px; margin-bottom:.6rem;
                            background:rgba(255,255,255,.03); border:1px solid rgba(255,255,255,.05);
                            transition:background .2s; cursor:default;"
                     onmouseenter="this.style.background='rgba(108,99,255,.08)'"
                     onmouseleave="this.style.background='rgba(255,255,255,.03)'">
                    <div style="display:flex; align-items:flex-start; gap:.75rem;">
                        <div style="font-size:1.4rem; flex-shrink:0; line-height:1;">{!! $item['icon'] !!}</div>
                        <div>
                            <div style="font-size:.85rem; font-weight:700; margin-bottom:.2rem; line-height:1.3;">
                                {{ $item['title'] }}
                            </div>
                            <div style="font-size:.76rem; color:var(--text-muted); line-height:1.5; margin-bottom:.3rem;">
                                {{ $item['summary'] }}
                            </div>
                            <div style="font-size:.7rem; color:var(--primary); font-weight:600;">
                                <i class="bi bi-calendar3"></i> {{ $item['date'] }}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function updateStatClock() {
        const now = new Date();
        const h = String(now.getHours()).padStart(2,'0');
        const m = String(now.getMinutes()).padStart(2,'0');
        document.getElementById('clockStat').textContent = h + ':' + m;
    }
    updateStatClock();
    setInterval(updateStatClock, 1000);
</script>
@endpush
