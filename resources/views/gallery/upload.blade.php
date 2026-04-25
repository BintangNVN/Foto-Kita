@extends('layouts.app')
@section('title', 'Upload Foto')
@section('page-title', 'Upload Foto')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="mb-4">
            <h1 style="font-size:1.4rem;font-weight:800;margin-bottom:.2rem;">
                <i class="bi bi-cloud-upload text-primary me-2"></i>Upload Foto
            </h1>
            <p style="font-size:.85rem;color:var(--text-muted);">Format JPG/PNG, maksimal 2MB per file.</p>
        </div>

        <div class="card-dark">
            <div class="card-body">
                <form action="{{ route('upload.post') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label">Judul Foto (opsional)</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               placeholder="Misal: Liburan Bali 2026" value="{{ old('title') }}">
                        @error('title')
                            <div class="invalid-feedback d-block" style="color:var(--secondary);font-size:.8rem;margin-top:.3rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Pilih Foto</label>
                        {{-- Drop Zone --}}
                        <div id="dropZone"
                             onclick="document.getElementById('photoInput').click()"
                             ondragover="event.preventDefault();this.classList.add('active')"
                             ondragleave="this.classList.remove('active')"
                             ondrop="handleDrop(event)"
                             style="border:2px dashed var(--border);border-radius:16px;
                                    padding:3rem 2rem;text-align:center;cursor:pointer;
                                    transition:all .25s;background:rgba(79,70,229,.03);">
                            <div id="dropZoneContent">
                                <div style="font-size:2.5rem;margin-bottom:.75rem;">
                                    <i class="bi bi-folder text-muted"></i>
                                </div>
                                <div style="font-size:.95rem;font-weight:600;margin-bottom:.3rem;">Klik atau seret foto ke sini</div>
                                <div style="font-size:.8rem;color:var(--text-muted);">JPG, PNG &middot; Maks 2MB per file &middot; Bisa banyak file</div>
                            </div>
                        </div>
                        <input type="file" id="photoInput" name="photos[]"
                               accept="image/jpeg,image/png,image/jpg"
                               multiple hidden
                               onchange="previewFiles(this.files)">
                        @error('photos')
                            <div style="color:var(--secondary);font-size:.8rem;margin-top:.4rem;">{{ $message }}</div>
                        @enderror
                        @error('photos.*')
                            <div style="color:var(--secondary);font-size:.8rem;margin-top:.4rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Preview grid --}}
                    <div id="previewGrid" class="photo-grid mb-4" style="display:none;"></div>

                    {{-- Progress --}}
                    <div id="progressWrap" style="display:none;margin-bottom:1.2rem;">
                        <div style="font-size:.82rem;color:var(--text-muted);margin-bottom:.4rem;">Mengunggah...</div>
                        <div style="height:6px;border-radius:10px;background:rgba(255,255,255,.08);overflow:hidden;">
                            <div id="progressBar"
                                 style="height:100%;width:0%;background:linear-gradient(90deg,var(--primary),var(--secondary));
                                        border-radius:10px;transition:width .3s;"></div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-primary-custom" id="submitBtn">
                            <i class="bi bi-cloud-upload"></i> Upload Sekarang
                        </button>
                        <a href="{{ route('gallery') }}" class="btn-secondary-custom">
                            <i class="bi bi-x-lg"></i> Batal
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
    #dropZone.active {
        border-color: var(--primary) !important;
        background: rgba(108,99,255,.1) !important;
    }
    #dropZone:hover { border-color: var(--primary); }
    .preview-item { position: relative; border-radius: 12px; overflow: hidden;
                    background: var(--dark-3); border: 1px solid var(--border); }
    .preview-item img { width:100%; height:120px; object-fit:cover; display:block; }
    .preview-remove {
        position:absolute;top:5px;right:5px;width:24px;height:24px;
        background:rgba(255,101,132,.8);border:none;border-radius:50%;
        color:#fff;cursor:pointer;font-size:.7rem;display:flex;
        align-items:center;justify-content:center;
    }
    .preview-name { font-size:.72rem;color:var(--text-muted);padding:.35rem .5rem;
                    white-space:nowrap;overflow:hidden;text-overflow:ellipsis; }
</style>
@endpush

@push('scripts')
<script>
    let selectedFiles = [];

    function handleDrop(e) {
        e.preventDefault();
        document.getElementById('dropZone').classList.remove('active');
        const files = Array.from(e.dataTransfer.files).filter(f =>
            ['image/jpeg','image/jpg','image/png'].includes(f.type)
        );
        addFiles(files);
    }

    function previewFiles(files) {
        addFiles(Array.from(files));
    }

    function addFiles(newFiles) {
        newFiles.forEach(f => {
            if (f.size > 2 * 1024 * 1024) {
                alert(`File "${f.name}" melebihi 2MB dan tidak akan diunggah.`);
                return;
            }
            selectedFiles.push(f);
        });
        renderPreviews();
        syncInput();
    }

    function renderPreviews() {
        const grid = document.getElementById('previewGrid');
        grid.innerHTML = '';
        if (selectedFiles.length === 0) {
            grid.style.display = 'none';
            return;
        }
        grid.style.display = 'grid';
        selectedFiles.forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = e => {
                const div = document.createElement('div');
                div.className = 'preview-item';
                div.innerHTML = `
                    <img src="${e.target.result}" alt="${file.name}">
                    <button class="preview-remove" onclick="removeFile(${idx})">✕</button>
                    <div class="preview-name">${file.name}</div>
                `;
                grid.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }

    function removeFile(idx) {
        selectedFiles.splice(idx, 1);
        renderPreviews();
        syncInput();
    }

    function syncInput() {
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(f => dataTransfer.items.add(f));
        document.getElementById('photoInput').files = dataTransfer.files;
    }

    // Fake upload progress animation
    document.getElementById('uploadForm').addEventListener('submit', function (e) {
        if (selectedFiles.length === 0) return;
        document.getElementById('progressWrap').style.display = 'block';
        document.getElementById('submitBtn').disabled = true;
        const bar = document.getElementById('progressBar');
        let pct = 0;
        const interval = setInterval(() => {
            pct = Math.min(pct + Math.random() * 15, 90);
            bar.style.width = pct + '%';
            if (pct >= 90) clearInterval(interval);
        }, 200);
    });
</script>
@endpush
