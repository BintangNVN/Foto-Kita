<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="FotoKita - Platform upload dan kelola foto pribadi Anda dengan mudah dan aman.">
    <title>@yield('title', 'FotoKita') – FotoKita</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --primary:   #4f46e5;
            --primary-d: #4338ca;
            --secondary: #ec4899;
            --accent:    #10b981;
            --dark:      #0f172a;
            --dark-2:    #1e293b;
            --dark-3:    #334155;
            --dark-4:    #475569;
            --card-bg:   rgba(30, 41, 59, 0.8);
            --text:      #f1f5f9;
            --text-muted:#94a3b8;
            --border:    rgba(71, 85, 105, 0.3);
            --shadow:    0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, var(--dark) 0%, var(--dark-2) 100%);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: 280px; min-height: 100vh;
            background: var(--dark-2);
            border-right: 1px solid var(--border);
            position: fixed; left: 0; top: 0; bottom: 0;
            display: flex; flex-direction: column;
            z-index: 1000;
            transition: transform .3s ease;
        }
        .sidebar-brand {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
        }
        .sidebar-brand .brand-logo {
            display: flex; align-items: center; gap: .75rem;
            text-decoration: none;
        }
        .brand-icon {
            width: 42px; height: 42px; border-radius: 12px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; color: white;
        }
        .brand-name {
            font-size: 1.4rem; font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .sidebar-user {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border);
        }
        .user-avatar {
            width: 40px; height: 40px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 1rem; color: #fff;
            flex-shrink: 0;
        }
        .user-info .user-name { font-size: .9rem; font-weight: 600; color: var(--text); }
        .user-info .user-role {
            font-size: .75rem; font-weight: 500; padding: 2px 8px;
            border-radius: 20px; display: inline-block;
            margin-top: 4px;
        }
        .badge-admin { background: rgba(79, 70, 229, 0.2); color: var(--primary); }
        .badge-user  { background: rgba(16, 185, 129, 0.2); color: var(--accent); }

        .sidebar-nav { flex: 1; padding: 1rem 0; overflow-y: auto; }
        .nav-section-label {
            font-size: .7rem; font-weight: 700; letter-spacing: .1em;
            color: var(--text-muted); padding: .5rem 1.5rem .25rem;
            text-transform: uppercase;
        }
        .nav-item { margin: 2px 10px; }
        .nav-link {
            display: flex; align-items: center; gap: .75rem;
            padding: .7rem 1rem; border-radius: 10px;
            color: var(--text-muted); font-size: .9rem; font-weight: 500;
            text-decoration: none; transition: all .2s;
        }
        .nav-link i { font-size: 1.1rem; width: 20px; text-align: center; }
        .nav-link:hover { background: rgba(79, 70, 229, 0.1); color: var(--text); }
        .nav-link.active {
            background: rgba(79, 70, 229, 0.15);
            color: var(--primary);
            font-weight: 600;
        }

        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid var(--border);
        }
        .btn-logout {
            width: 100%; display: flex; align-items: center; justify-content: center;
            gap: .5rem; padding: .7rem 1rem; border-radius: 10px;
            background: rgba(236, 72, 153, 0.1); color: var(--secondary);
            border: 1px solid rgba(236, 72, 153, 0.2); font-size: .9rem;
            font-weight: 600; cursor: pointer; transition: all .2s;
        }
        .btn-logout:hover { background: rgba(236, 72, 153, 0.15); }

        /* ── Main Content ── */
        .main-wrapper { margin-left: 280px; min-height: 100vh; }

        .topbar {
            background: rgba(15, 23, 42, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border);
            padding: 1rem 2rem;
            position: sticky; top: 0; z-index: 900;
            display: flex; align-items: center; justify-content: space-between;
        }
        .topbar-title { font-size: 1.2rem; font-weight: 700; color: var(--text); }
        .topbar-clock { font-size: .9rem; color: var(--text-muted); font-weight: 500; }

        .profile-topbar {
            display: flex; align-items: center; gap: .75rem;
            cursor: pointer; padding: .35rem .55rem; border-radius: 16px;
            transition: background .25s ease, transform .25s ease;
        }
        .profile-topbar:hover { background: rgba(79, 70, 229, 0.12); transform: translateY(-1px); }
        .profile-avatar {
            width: 42px; height: 42px; border-radius: 50%; object-fit: cover;
            border: 2px solid rgba(79, 70, 229, 0.9);
        }
        .profile-info {
            display: flex; flex-direction: column; line-height: 1.1;
            text-align: left; min-width: 0;
        }
        .profile-name {
            font-size: .9rem; font-weight: 700; color: var(--text);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
            max-width: 140px;
        }
        .profile-label {
            font-size: .75rem; color: var(--text-muted); font-weight: 500;
        }

        .profile-dropdown {
            background: rgba(15, 23, 42, 0.97);
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(18px);
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.24);
            min-width: 220px;
        }
        .profile-dropdown .dropdown-item {
            color: var(--text); padding: 0.9rem 1.1rem;
        }
        .profile-dropdown .dropdown-item:hover,
        .profile-dropdown .dropdown-item:focus {
            background: rgba(79, 70, 229, 0.14);
            color: var(--text);
        }
        .profile-dropdown .dropdown-divider {
            border-top-color: rgba(255,255,255,0.1);
        }
        .profile-dropdown .dropdown-item i {
            color: var(--primary);
        }

        .content-area { padding: 2rem; max-width: 1400px; margin: 0 auto; }

        /* ── Cards ── */
        .card-dark {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow);
        }
        .card-dark .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border);
            padding: 1.2rem 1.5rem;
            font-weight: 700; font-size: 1rem;
        }
        .card-dark .card-body { padding: 1.5rem; }

        /* ── Stat Cards ── */
        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem;
            display: flex; align-items: center; gap: 1.2rem;
            transition: transform .2s, box-shadow .2s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15); }
        .stat-icon {
            width: 56px; height: 56px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; color: white;
        }
        .stat-value { font-size: 2rem; font-weight: 800; line-height: 1; }
        .stat-label { font-size: .85rem; color: var(--text-muted); font-weight: 500; margin-top: .2rem; }

        /* ── Buttons ── */
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary), var(--primary-d));
            color: #fff; border: none; padding: .7rem 1.5rem;
            border-radius: 10px; font-weight: 600; font-size: .9rem;
            cursor: pointer; transition: all .2s; display: inline-flex;
            align-items: center; gap: .5rem; text-decoration: none;
        }
        .btn-primary-custom:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4); color:#fff; }
        .btn-danger-custom {
            background: rgba(236, 72, 153, 0.1); color: var(--secondary);
            border: 1px solid rgba(236, 72, 153, 0.25); padding: .5rem 1rem;
            border-radius: 8px; font-size: .85rem; font-weight: 600;
            cursor: pointer; transition: all .2s; display: inline-flex;
            align-items: center; gap: .4rem; text-decoration: none;
        }
        .btn-danger-custom:hover { background: rgba(236, 72, 153, 0.2); color: var(--secondary); }
        .btn-secondary-custom {
            background: rgba(255,255,255,.06); color: var(--text-muted);
            border: 1px solid var(--border); padding: .5rem 1rem;
            border-radius: 8px; font-size: .85rem; font-weight: 600;
            cursor: pointer; transition: all .2s; display: inline-flex;
            align-items: center; gap: .4rem; text-decoration: none;
        }
        .btn-secondary-custom:hover { background: rgba(255,255,255,.1); color: var(--text); }

        /* ── Alerts ── */
        .alert-custom {
            padding: .9rem 1.3rem; border-radius: 12px; font-size: .9rem;
            font-weight: 500; display: flex; align-items: center; gap: .6rem;
            margin-bottom: 1.2rem;
        }
        .alert-success-custom { background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: var(--accent); }
        .alert-error-custom   { background: rgba(236, 72, 153, 0.1); border: 1px solid rgba(236, 72, 153, 0.2); color: var(--secondary); }

        /* ── Form Inputs ── */
        .form-control, .form-select {
            background: rgba(255,255,255,.05) !important;
            border: 1px solid var(--border) !important;
            color: var(--text) !important;
            border-radius: 10px !important;
            padding: .7rem 1rem !important;
            font-size: .9rem !important;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1) !important;
            outline: none !important;
        }
        .form-control::placeholder { color: var(--text-muted) !important; }
        .form-label { font-size: .88rem; font-weight: 600; color: var(--text); margin-bottom: .5rem; }
        .invalid-feedback { font-size: .8rem; color: var(--secondary); }

        /* ── Table ── */
        .table-dark-custom thead th {
            background: rgba(79, 70, 229, 0.1);
            color: var(--text-muted); font-size: .8rem;
            font-weight: 700; letter-spacing: .05em; text-transform: uppercase;
            border-bottom: 1px solid var(--border); padding: .9rem 1rem;
        }
        .table-dark-custom tbody td {
            border-bottom: 1px solid rgba(255,255,255,.04);
            padding: .9rem 1rem; font-size: .9rem;
            vertical-align: middle; color: var(--text);
        }
        .table-dark-custom tbody tr:hover td { background: rgba(79, 70, 229, 0.05); }

        /* ── Photo Grid ── */
        .photo-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.2rem; }
        .photo-card {
            border-radius: 14px; overflow: hidden;
            background: var(--dark-3);
            border: 1px solid var(--border);
            transition: transform .25s, box-shadow .25s;
            cursor: pointer;
        }
        .photo-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0, 0, 0, 0.2); }
        .photo-card img { width: 100%; height: 180px; object-fit: cover; display: block; }
        .photo-card-info { padding: .8rem 1rem; }
        .photo-card-title { font-size: .85rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .photo-card-meta  { font-size: .75rem; color: var(--text-muted); margin-top: .2rem; }

        /* ── Pagination ── */
        .pagination .page-link {
            background: var(--dark-3); border: 1px solid var(--border);
            color: var(--text-muted); border-radius: 8px !important;
            margin: 0 2px; font-size: .85rem;
        }
        .pagination .page-link:hover { background: rgba(79, 70, 229, 0.1); color: var(--primary); }
        .pagination .page-item.active .page-link {
            background: var(--primary); border-color: var(--primary); color: #fff;
        }

        /* ── Toggle Sidebar on Mobile ── */
        .sidebar-toggle { display: none; }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .sidebar-toggle { display: flex; }
            .content-area { padding: 1rem; }
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--primary-d); border-radius: 10px; }

            font-size: .72rem; font-weight: 600; padding: 1px 8px;
            border-radius: 20px; display: inline-block;
        }
        .badge-admin { background: rgba(108,99,255,.2); color: var(--primary); }
        .badge-user  { background: rgba(67,233,123,.15); color: var(--accent); }

        .sidebar-nav { flex: 1; padding: 1rem 0; overflow-y: auto; }
        .nav-section-label {
            font-size: .68rem; font-weight: 700; letter-spacing: .1em;
            color: var(--text-muted); padding: .5rem 1.5rem .25rem;
            text-transform: uppercase;
        }
        .nav-item { margin: 2px 10px; }
        .nav-link {
            display: flex; align-items: center; gap: .75rem;
            padding: .65rem 1rem; border-radius: 10px;
            color: var(--text-muted); font-size: .88rem; font-weight: 500;
            text-decoration: none; transition: all .2s;
        }
        .nav-link i { font-size: 1rem; width: 18px; text-align: center; }
        .nav-link:hover { background: rgba(108,99,255,.12); color: var(--text); }
        .nav-link.active {
            background: rgba(108,99,255,.2);
            color: var(--primary);
            font-weight: 600;
        }

        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid var(--border);
        }
        .btn-logout {
            width: 100%; display: flex; align-items: center; justify-content: center;
            gap: .5rem; padding: .6rem 1rem; border-radius: 10px;
            background: rgba(255,101,132,.1); color: var(--secondary);
            border: 1px solid rgba(255,101,132,.2); font-size: .88rem;
            font-weight: 600; cursor: pointer; transition: all .2s;
        }
        .btn-logout:hover { background: rgba(255,101,132,.2); }

        /* ── Main Content ── */
        .main-wrapper { margin-left: 280px; min-height: 100vh; }

        .topbar {
            background: rgba(15, 23, 42, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border);
            padding: 1rem 2rem;
            position: sticky; top: 0; z-index: 900;
            display: flex; align-items: center; justify-content: space-between;
        }
        .topbar-title { font-size: 1.2rem; font-weight: 700; color: var(--text); }
        .topbar-clock { font-size: .9rem; color: var(--text-muted); font-weight: 500; }

        .content-area { padding: 2rem; max-width: 1400px; margin: 0 auto; }

        /* ── Cards ── */
        .card-dark {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow);
        }
        .card-dark .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border);
            padding: 1.2rem 1.5rem;
            font-weight: 700; font-size: 1rem;
        }
        .card-dark .card-body { padding: 1.5rem; }

        /* ── Stat Cards ── */
        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem;
            display: flex; align-items: center; gap: 1.2rem;
            transition: transform .2s, box-shadow .2s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15); }
        .stat-icon {
            width: 56px; height: 56px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; color: white;
        }
        .stat-value { font-size: 2rem; font-weight: 800; line-height: 1; }
        .stat-label { font-size: .85rem; color: var(--text-muted); font-weight: 500; margin-top: .2rem; }

        /* ── Buttons ── */
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary), var(--primary-d));
            color: #fff; border: none; padding: .7rem 1.5rem;
            border-radius: 10px; font-weight: 600; font-size: .9rem;
            cursor: pointer; transition: all .2s; display: inline-flex;
            align-items: center; gap: .5rem; text-decoration: none;
        }
        .btn-primary-custom:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4); color:#fff; }
        .btn-danger-custom {
            background: rgba(236, 72, 153, 0.1); color: var(--secondary);
            border: 1px solid rgba(236, 72, 153, 0.25); padding: .5rem 1rem;
            border-radius: 8px; font-size: .85rem; font-weight: 600;
            cursor: pointer; transition: all .2s; display: inline-flex;
            align-items: center; gap: .4rem; text-decoration: none;
        }
        .btn-danger-custom:hover { background: rgba(236, 72, 153, 0.2); color: var(--secondary); }
        .btn-secondary-custom {
            background: rgba(255,255,255,.06); color: var(--text-muted);
            border: 1px solid var(--border); padding: .5rem 1rem;
            border-radius: 8px; font-size: .85rem; font-weight: 600;
            cursor: pointer; transition: all .2s; display: inline-flex;
            align-items: center; gap: .4rem; text-decoration: none;
        }
        .btn-secondary-custom:hover { background: rgba(255,255,255,.1); color: var(--text); }

        /* ── Alerts ── */
        .alert-custom {
            padding: .9rem 1.3rem; border-radius: 12px; font-size: .9rem;
            font-weight: 500; display: flex; align-items: center; gap: .6rem;
            margin-bottom: 1.2rem;
        }
        .alert-success-custom { background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: var(--accent); }
        .alert-error-custom   { background: rgba(236, 72, 153, 0.1); border: 1px solid rgba(236, 72, 153, 0.2); color: var(--secondary); }

        /* ── Form Inputs ── */
        .form-control, .form-select {
            background: rgba(255,255,255,.05) !important;
            border: 1px solid var(--border) !important;
            color: var(--text) !important;
            border-radius: 10px !important;
            padding: .7rem 1rem !important;
            font-size: .9rem !important;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1) !important;
            outline: none !important;
        }
        .form-control::placeholder { color: var(--text-muted) !important; }
        .form-label { font-size: .88rem; font-weight: 600; color: var(--text); margin-bottom: .5rem; }
        .invalid-feedback { font-size: .8rem; color: var(--secondary); }

        /* ── Table ── */
        .table-dark-custom thead th {
            background: rgba(79, 70, 229, 0.1);
            color: var(--text-muted); font-size: .8rem;
            font-weight: 700; letter-spacing: .05em; text-transform: uppercase;
            border-bottom: 1px solid var(--border); padding: .9rem 1rem;
        }
        .table-dark-custom tbody td {
            border-bottom: 1px solid rgba(255,255,255,.04);
            padding: .9rem 1rem; font-size: .9rem;
            vertical-align: middle; color: var(--text);
        }
        .table-dark-custom tbody tr:hover td { background: rgba(79, 70, 229, 0.05); }

        /* ── Photo Grid ── */
        .photo-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.2rem; }
        .photo-card {
            border-radius: 14px; overflow: hidden;
            background: var(--dark-3);
            border: 1px solid var(--border);
            transition: transform .25s, box-shadow .25s;
            cursor: pointer;
        }
        .photo-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0, 0, 0, 0.2); }
        .photo-card img { width: 100%; height: 180px; object-fit: cover; display: block; }
        .photo-card-info { padding: .8rem 1rem; }
        .photo-card-title { font-size: .85rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .photo-card-meta  { font-size: .75rem; color: var(--text-muted); margin-top: .2rem; }

        /* ── Pagination ── */
        .pagination .page-link {
            background: var(--dark-3); border: 1px solid var(--border);
            color: var(--text-muted); border-radius: 8px !important;
            margin: 0 2px; font-size: .85rem;
        }
        .pagination .page-link:hover { background: rgba(79, 70, 229, 0.1); color: var(--primary); }
        .pagination .page-item.active .page-link {
            background: var(--primary); border-color: var(--primary); color: #fff;
        }

        /* ── Toggle Sidebar on Mobile ── */
        .sidebar-toggle { display: none; }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .sidebar-toggle { display: flex; }
            .content-area { padding: 1rem; }
            .topbar { padding: .85rem 1rem; }
        }

        @media (max-width: 768px) {
            .sidebar { width: 100%; }
            .sidebar-brand,
            .sidebar-user,
            .sidebar-footer { padding-left: 1rem; padding-right: 1rem; }
            .topbar { flex-direction: column; align-items: stretch; gap: .75rem; }
            .topbar-title { font-size: 1rem; }
            .topbar-clock { width: 100%; text-align: left; }
            .content-area { padding: 1rem .75rem; }
            .stat-card { flex-direction: column; align-items: flex-start; }
            .stat-icon { width: 48px; height: 48px; }
            .photo-card img { height: 160px; }
            .card-dark .card-header { padding: 1rem 1rem; }
            .card-dark .card-body { padding: 1rem; }
            .form-control, .form-select { padding: .65rem .9rem !important; }
            .btn-primary-custom, .btn-danger-custom, .btn-secondary-custom { width: 100%; justify-content: center; }
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--primary-d); border-radius: 10px; }
        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.5); z-index: 999; backdrop-filter: blur(4px);
        }
        .sidebar-overlay.show { display: block; }
    </style>

    @stack('styles')
</head>
<body>

{{-- Mobile sidebar overlay --}}
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

{{-- ── Sidebar ── --}}
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <a href="{{ auth()->user()?->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="brand-logo">
            <div class="brand-icon">📷</div>
            <span class="brand-name">FotoKita</span>
        </a>
    </div>

    @auth
    {{-- <div class="sidebar-user">
        <div class="d-flex align-items-center gap-2">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <span class="user-role {{ auth()->user()->isAdmin() ? 'badge-admin' : 'badge-user' }}">
                    {{ auth()->user()->isAdmin() ? '⚡ Admin' : '👤 User' }}
                </span>
            </div>
        </div>
    </div> --}}

    <nav class="sidebar-nav">
        @if(auth()->user()->isAdmin())
            <div class="nav-section-label">Admin Panel</div>
            <div class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.photos.index') }}" class="nav-link {{ request()->routeIs('admin.photos.*') ? 'active' : '' }}">
                    <i class="bi bi-images"></i> Semua Foto
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Manajemen User
                </a>
            </div>
        @else
            <div class="nav-section-label">Menu</div>
            <div class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house"></i> Dashboard
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('gallery') }}" class="nav-link {{ request()->routeIs('gallery') ? 'active' : '' }}">
                    <i class="bi bi-grid"></i> Galeri Saya
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('upload') }}" class="nav-link {{ request()->routeIs('upload') ? 'active' : '' }}">
                    <i class="bi bi-cloud-upload"></i> Upload Foto
                </a>
            </div>
        @endif
    </nav>

    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="bi bi-box-arrow-left"></i> Keluar
            </button>
        </form>
    </div>
    @endauth
</aside>

{{-- ── Main Wrapper ── --}}
<div class="main-wrapper">
    {{-- Topbar --}}
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn-secondary-custom sidebar-toggle" onclick="toggleSidebar()">
                <i class="bi bi-list" style="font-size:1.1rem"></i>
            </button>
            <span class="topbar-title">@yield('page-title', 'Dashboard')</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="topbar-clock" id="liveClock">--:--:--</div>
            @auth
                @if(!Auth::user()->isAdmin())
                <div class="dropdown">
                    <button class="btn btn-link p-0 text-decoration-none dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="profile-topbar">
                            <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : 'https://via.placeholder.com/42x42/4f46e5/ffffff?text=' . substr(Auth::user()->name, 0, 1) }}" alt="Profile" class="profile-avatar">
                            <div class="profile-info">
                                <span class="profile-name">{{ Auth::user()->name }}</span>
                                
                            </div>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end profile-dropdown" aria-labelledby="profileDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person-gear me-2"></i>
                                Ubah Profil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('dashboard') }}">
                                <i class="bi bi-house-door me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-left me-2"></i>Keluar</button>
                            </form>
                        </li>
                    </ul>
                </div>
                @endif
            @endauth
        </div>
    </div>

    {{-- Alerts --}}
    <div style="padding: 1rem 2rem 0;">
        @if(session('success'))
            <div class="alert-custom alert-success-custom">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert-custom alert-error-custom">
                <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
            </div>
        @endif
    </div>

    {{-- Page Content --}}
    <main class="content-area">
        @yield('content')
    </main>
</div>

{{-- Bootstrap 5 JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Live Clock
    function updateClock() {
        const now = new Date();
        const h = String(now.getHours()).padStart(2, '0');
        const m = String(now.getMinutes()).padStart(2, '0');
        const s = String(now.getSeconds()).padStart(2, '0');
        const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        const day = days[now.getDay()];
        document.getElementById('liveClock').textContent = `${day}, ${h}:${m}:${s}`;
    }
    updateClock();
    setInterval(updateClock, 1000);

    // Sidebar Toggle
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
        document.getElementById('sidebarOverlay').classList.toggle('show');
    }
</script>

@stack('scripts')
</body>
</html>
