@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')

<div class="mb-4">
    <h1 style="font-size:1.5rem;font-weight:800;margin-bottom:.2rem;">
        <i class="bi bi-speedometer2 text-primary me-2"></i>Panel Admin
    </h1>
    <p style="font-size:.85rem;color:var(--text-muted);">Monitoring dan manajemen seluruh data FotoKita.</p>
</div>

{{-- ── Stat Cards ── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(79,70,229,.15)">
                <i class="bi bi-people text-primary"></i>
            </div>
            <div>
                <div class="stat-value" style="color:#4f46e5">{{ $totalUsers }}</div>
                <div class="stat-label">Total User</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(16,185,129,.12)">
                <i class="bi bi-camera text-success"></i>
            </div>
            <div>
                <div class="stat-value" style="color:#10b981">{{ $totalPhotos }}</div>
                <div class="stat-label">Total Foto</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(245,158,11,.12)">
                <i class="bi bi-sunrise text-warning"></i>
            </div>
            <div>
                <div class="stat-value" style="color:#f59e0b">{{ $todayPhotos }}</div>
                <div class="stat-label">Upload Hari Ini</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(236,72,153,.12)">
                <i class="bi bi-key text-danger"></i>
            </div>
            <div>
                <div class="stat-value" style="color:#ec4899">{{ $todayLogins }}</div>
                <div class="stat-label">Login Hari Ini</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    {{-- ── Upload Chart (7 days) ── --}}
    <div class="col-lg-7">
        <div class="card-dark h-100">
            <div class="card-header">
                <i class="bi bi-bar-chart me-2" style="color:var(--primary)"></i>Upload 7 Hari Terakhir
            </div>
            <div class="card-body" style="padding:1.5rem;">
                <div style="display:flex;align-items:flex-end;gap:8px;height:140px;">
                    @php $maxCount = max(collect($uploadStats)->pluck('count')->max(), 1); @endphp
                    @foreach($uploadStats as $stat)
                    @php $heightPct = max(($stat['count'] / $maxCount) * 100, 4); @endphp
                    <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:.4rem;">
                        <div style="font-size:.72rem;color:var(--text-muted);font-weight:600;">
                            {{ $stat['count'] > 0 ? $stat['count'] : '' }}
                        </div>
                        <div style="width:100%;height:{{ $heightPct }}%;
                                    background:linear-gradient(180deg,var(--primary),var(--primary-d));
                                    border-radius:6px 6px 0 0;transition:height .5s;
                                    min-height:4px;position:relative;"
                             title="{{ $stat['date'] }}: {{ $stat['count'] }} foto">
                        </div>
                        <div style="font-size:.68rem;color:var(--text-muted);text-align:center;">
                            {{ $stat['date'] }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ── Top Uploaders ── --}}
    <div class="col-lg-5">
        <div class="card-dark h-100">
            <div class="card-header">
                <i class="bi bi-trophy me-2" style="color:#ffc107"></i>Top Uploader
            </div>
            <div class="card-body" style="padding:1rem;">
                @forelse($topUploaders as $i => $uploader)
                <div style="display:flex;align-items:center;gap:.85rem;padding:.6rem .5rem;
                            border-radius:10px;transition:background .2s;"
                     onmouseenter="this.style.background='rgba(108,99,255,.07)'"
                     onmouseleave="this.style.background='transparent'">
                    <div style="width:28px;height:28px;border-radius:50%;
                                background:{{ $i===0?'linear-gradient(135deg,#f59e0b,#d97706)':($i===1?'linear-gradient(135deg,#9ca3af,#6b7280)':($i===2?'linear-gradient(135deg,#a16207,#92400e)':'rgba(255,255,255,.08)')) }};
                                display:flex;align-items:center;justify-content:center;
                                font-size:.8rem;font-weight:700;flex-shrink:0;color:#fff;">
                        {{ $i < 3 ? ['🏆','🥈','🥉'][$i] : $i+1 }}
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:.85rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $uploader->name }}
                        </div>
                        <div style="font-size:.72rem;color:var(--text-muted);">{{ $uploader->email }}</div>
                    </div>
                    <div style="font-size:.82rem;font-weight:700;color:var(--primary);">
                        {{ $uploader->photos_count }} <span style="font-size:.68rem;color:var(--text-muted);font-weight:400;">foto</span>
                    </div>
                </div>
                @empty
                <div style="text-align:center;padding:1.5rem;color:var(--text-muted);font-size:.88rem;">
                    Belum ada data upload
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- ── Recent Photos ── --}}
    <div class="col-lg-7">
        <div class="card-dark">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-images me-2" style="color:var(--primary)"></i>Foto Terbaru</span>
                <a href="{{ route('admin.photos.index') }}" style="font-size:.8rem;color:var(--primary);text-decoration:none;font-weight:600;">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="card-body">
                @if($recentPhotos->isEmpty())
                    <div style="text-align:center;padding:2rem;color:var(--text-muted);font-size:.88rem;">Belum ada foto</div>
                @else
                    <div class="photo-grid" style="grid-template-columns:repeat(auto-fill,minmax(110px,1fr));">
                        @foreach($recentPhotos as $photo)
                        <div class="photo-card">
                            <div style="position:relative;">
                                <img src="{{ asset('storage/'.$photo->path) }}" alt="{{ $photo->title }}" loading="lazy">
                                <div style="position:absolute;bottom:0;left:0;right:0;
                                            background:linear-gradient(transparent,rgba(0,0,0,.8));
                                            padding:.4rem .5rem;">
                                    <div style="font-size:.68rem;color:rgba(255,255,255,.8);font-weight:600;
                                                white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                        {{ $photo->user->name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Recent Activity ── --}}
    <div class="col-lg-5">
        <div class="card-dark">
            <div class="card-header">
                <i class="bi bi-activity me-2" style="color:var(--accent)"></i>Aktivitas Terbaru
            </div>
            <div class="card-body" style="padding:.75rem;">
                @forelse($recentActivity as $log)
                @php
                    $icons = [
                        'login'                 => ['🔑','rgba(67,233,123,.1)','#43e97b'],
                        'logout'                => ['🚪','rgba(255,193,7,.08)','#ffc107'],
                        'upload'                => ['📤','rgba(108,99,255,.1)','#6c63ff'],
                        'download'              => ['📥','rgba(67,233,123,.08)','#43e97b'],
                        'delete'                => ['🗑️','rgba(255,101,132,.1)','#ff6584'],
                        'register'              => ['✨','rgba(108,99,255,.1)','#6c63ff'],
                        'admin_delete_photo'    => ['⚡','rgba(255,101,132,.1)','#ff6584'],
                        'admin_delete_user'     => ['💥','rgba(255,101,132,.1)','#ff6584'],
                        'admin_create_user'     => ['➕','rgba(67,233,123,.1)','#43e97b'],
                        'admin_edit_user'       => ['✏️','rgba(255,193,7,.08)','#ffc107'],
                    ];
                    $ic = $icons[$log->action] ?? ['📌','rgba(255,255,255,.05)','var(--text-muted)'];
                @endphp
                <div style="display:flex;gap:.7rem;align-items:flex-start;padding:.6rem .5rem;
                            border-radius:10px;margin-bottom:.2rem;transition:background .2s;"
                     onmouseenter="this.style.background='rgba(255,255,255,.03)'"
                     onmouseleave="this.style.background='transparent'">
                    <div style="width:32px;height:32px;border-radius:8px;
                                background:{{ $ic[1] }};display:flex;align-items:center;
                                justify-content:center;font-size:.9rem;flex-shrink:0;margin-top:.1rem;">
                        {{ $ic[0] }}
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:.8rem;font-weight:600;line-height:1.3;">
                            {{ $log->description ?? $log->action }}
                        </div>
                        <div style="font-size:.7rem;color:var(--text-muted);margin-top:.1rem;">
                            {{ $log->user?->name ?? 'System' }} &middot; {{ $log->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
                @empty
                <div style="text-align:center;padding:1.5rem;color:var(--text-muted);font-size:.88rem;">
                    Belum ada aktivitas
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
