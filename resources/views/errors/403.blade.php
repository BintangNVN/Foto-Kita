<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 – Akses Ditolak | FotoKita</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary:#6c63ff; --secondary:#ff6584; --dark:#0d0d1a; --text:#e8e8f0; --muted:#9592b8; }
        * { box-sizing:border-box; margin:0; padding:0; }
        body {
            font-family:'Plus Jakarta Sans',sans-serif;
            background:var(--dark); color:var(--text);
            min-height:100vh; display:flex; align-items:center; justify-content:center;
        }
        body::before {
            content:''; position:fixed; inset:0; z-index:-1;
            background:radial-gradient(ellipse 70% 50% at 30% 20%,rgba(108,99,255,.18) 0%,transparent 60%),
                       radial-gradient(ellipse 60% 45% at 80% 80%,rgba(255,101,132,.12) 0%,transparent 60%),
                       var(--dark);
        }
        .error-card {
            text-align:center; padding:3.5rem 2.5rem; max-width:440px; width:calc(100% - 2rem);
            background:rgba(19,19,43,.85); border:1px solid rgba(108,99,255,.2);
            border-radius:24px; backdrop-filter:blur(20px);
        }
        .error-code { font-size:5rem; font-weight:800; line-height:1;
                      background:linear-gradient(135deg,var(--primary),var(--secondary));
                      -webkit-background-clip:text; -webkit-text-fill-color:transparent;
                      background-clip:text; margin-bottom:.5rem; }
        .error-title { font-size:1.35rem; font-weight:700; margin-bottom:.75rem; }
        .error-desc  { font-size:.9rem; color:var(--muted); margin-bottom:2rem; line-height:1.6; }
        .btn-back {
            display:inline-flex; align-items:center; gap:.5rem;
            background:linear-gradient(135deg,var(--primary),#5a52d5);
            color:#fff; text-decoration:none; padding:.7rem 1.6rem;
            border-radius:12px; font-weight:700; font-size:.9rem;
            transition:transform .2s, box-shadow .2s;
            box-shadow:0 6px 20px rgba(108,99,255,.35);
        }
        .btn-back:hover { transform:translateY(-2px); box-shadow:0 10px 28px rgba(108,99,255,.5); color:#fff; }
        .emoji { font-size:3.5rem; margin-bottom:1rem; display:block; }
    </style>
</head>
<body>
    <div class="error-card">
        <span class="emoji">🚫</span>
        <div class="error-code">403</div>
        <div class="error-title">Akses Ditolak</div>
        <div class="error-desc">Maaf, Anda tidak memiliki izin untuk mengakses halaman ini. Pastikan Anda login dengan akun yang sesuai.</div>
        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : '/' }}" class="btn-back">
            ← Kembali
        </a>
    </div>
</body>
</html>
