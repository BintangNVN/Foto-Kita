<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login ke FotoKita dan kelola foto pribadi Anda.">
    <title>@yield('title') – FotoKita</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --primary:   #6c63ff;
            --primary-d: #5a52d5;
            --secondary: #ff6584;
            --accent:    #43e97b;
            --dark:      #0d0d1a;
            --dark-2:    #13132b;
            --dark-3:    #1c1c3a;
            --border:    rgba(108,99,255,0.2);
            --text:      #e8e8f0;
            --text-muted:#9592b8;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--dark); color: var(--text);
            min-height: 100vh; overflow: hidden;
        }
        body::before {
            content: '';
            position: fixed; inset: 0; z-index: -1;
            background:
                radial-gradient(ellipse 80% 60% at 10% 20%, rgba(108,99,255,.2) 0%, transparent 55%),
                radial-gradient(ellipse 60% 50% at 90% 80%, rgba(255,101,132,.15) 0%, transparent 55%),
                var(--dark);
        }
        .auth-container {
            min-height: 100vh; display: flex;
            align-items: center; justify-content: center;
            padding: 1.5rem;
        }
        .auth-card {
            background: rgba(19,19,43,.9);
            border: 1px solid var(--border);
            border-radius: 24px;
            backdrop-filter: blur(20px);
            padding: 2.5rem 2rem;
            width: 100%; max-width: 420px;
            box-shadow: 0 32px 80px rgba(0,0,0,.5), 0 0 0 1px rgba(108,99,255,.1);
        }
        .auth-logo {
            display: flex; align-items: center; justify-content: center;
            gap: .75rem; margin-bottom: 1.8rem;
        }
        .auth-logo-icon {
            width: 48px; height: 48px; border-radius: 14px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; box-shadow: 0 8px 24px rgba(108,99,255,.4);
        }
        .auth-logo-name {
            font-size: 1.6rem; font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .auth-title { font-size: 1.15rem; font-weight: 700; margin-bottom: .25rem; }
        .auth-subtitle { font-size: .85rem; color: var(--text-muted); margin-bottom: 1.8rem; }
        .form-group { margin-bottom: 1rem; }
        .form-label { font-size: .82rem; font-weight: 600; color: var(--text-muted); margin-bottom: .4rem; display: block; }
        .form-control {
            width: 100%; background: rgba(255,255,255,.05) !important;
            border: 1px solid var(--border) !important;
            color: var(--text) !important;
            border-radius: 12px !important;
            padding: .75rem 1rem !important;
            font-size: .9rem !important; font-family: inherit;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(108,99,255,.18) !important;
            outline: none !important;
            background: rgba(255,255,255,.07) !important;
        }
        .form-control::placeholder { color: var(--text-muted) !important; }
        .input-icon-wrap { position: relative; }
        .input-icon-wrap .form-control { padding-left: 2.6rem !important; }
        .input-icon {
            position: absolute; left: .9rem; top: 50%;
            transform: translateY(-50%); color: var(--text-muted);
            font-size: 1rem; pointer-events: none;
        }
        .btn-auth {
            width: 100%; padding: .8rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-d));
            color: #fff; border: none; border-radius: 12px;
            font-size: .95rem; font-weight: 700; font-family: inherit;
            cursor: pointer; transition: all .25s;
            box-shadow: 0 6px 20px rgba(108,99,255,.35);
            margin-top: .25rem;
        }
        .btn-auth:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(108,99,255,.5); }
        .btn-auth:active { transform: translateY(0); }
        .auth-divider { text-align: center; font-size: .82rem; color: var(--text-muted); margin: 1.2rem 0; }
        .auth-link { color: var(--primary); font-weight: 600; text-decoration: none; transition: color .2s; }
        .auth-link:hover { color: #fff; }
        .invalid-feedback { font-size: .78rem; color: #ff6584; display: block; margin-top: .3rem; }
        .is-invalid { border-color: #ff6584 !important; }
        .remember-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.2rem; }
        .form-check-input {
            background-color: rgba(255,255,255,.06) !important;
            border-color: var(--border) !important;
        }
        .form-check-input:checked { background-color: var(--primary) !important; border-color: var(--primary) !important; }
        .form-check-label { font-size: .83rem; color: var(--text-muted); }
        .floating-circles {
            position: fixed; inset: 0; z-index: -1; pointer-events: none; overflow: hidden;
        }
        .circle {
            position: absolute; border-radius: 50%;
            background: linear-gradient(135deg, rgba(108,99,255,.1), rgba(255,101,132,.05));
            animation: float 8s ease-in-out infinite;
        }
        .circle:nth-child(1) { width: 300px; height: 300px; top: -80px; right: -80px; animation-delay: 0s; }
        .circle:nth-child(2) { width: 200px; height: 200px; bottom: -60px; left: -60px; animation-delay: 3s; }
        .circle:nth-child(3) { width: 150px; height: 150px; top: 40%; right: 10%; animation-delay: 1.5s; }
        @keyframes float {
            0%,100% { transform: translateY(0) rotate(0deg); }
            50%      { transform: translateY(-20px) rotate(10deg); }
        }
    </style>
</head>
<body>
<div class="floating-circles">
    <div class="circle"></div>
    <div class="circle"></div>
    <div class="circle"></div>
</div>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-logo">
            <div class="auth-logo-icon">📷</div>
            <span class="auth-logo-name">FotoKita</span>
        </div>

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
