<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Connexion') — CFM</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }

        body { margin: 0; min-height: 100vh; display: flex; }

        /* Left panel */
        .cfm-panel-left {
            width: 45%;
            background: linear-gradient(145deg, #003f87 0%, #001f4d 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .cfm-panel-left::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: rgba(249,115,22,.12);
        }

        .cfm-panel-left::after {
            content: '';
            position: absolute;
            bottom: -60px; left: -60px;
            width: 220px; height: 220px;
            border-radius: 50%;
            background: rgba(255,255,255,.05);
        }

        .cfm-logo-box {
            width: 88px; height: 88px;
            background: #fff;
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 32px rgba(0,0,0,.25);
            position: relative; z-index: 1;
        }

        .cfm-logo-box span {
            font-size: 2rem;
            font-weight: 800;
            color: #003f87;
            letter-spacing: -1px;
        }

        .cfm-brand { position: relative; z-index: 1; text-align: center; }

        .cfm-brand h1 {
            color: #fff;
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: .25rem;
            letter-spacing: -.5px;
        }

        .cfm-brand .cfm-sub {
            color: rgba(255,255,255,.7);
            font-size: .875rem;
            font-weight: 500;
            margin-bottom: 2rem;
        }

        .cfm-tagline {
            color: rgba(255,255,255,.55);
            font-size: .8rem;
            text-align: center;
            position: relative; z-index: 1;
            max-width: 280px;
            line-height: 1.6;
        }

        .cfm-accent-bar {
            width: 40px; height: 4px;
            background: #f97316;
            border-radius: 2px;
            margin: 1rem auto;
        }

        .cfm-badge {
            display: inline-flex; align-items: center; gap: .4rem;
            background: rgba(249,115,22,.2);
            border: 1px solid rgba(249,115,22,.4);
            color: #fbbf24;
            font-size: .75rem;
            font-weight: 600;
            padding: .3rem .75rem;
            border-radius: 999px;
            position: relative; z-index: 1;
            margin-top: 1.5rem;
        }

        /* Right panel */
        .cfm-panel-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            padding: 2rem;
        }

        .cfm-form-card {
            width: 100%;
            max-width: 420px;
        }

        .cfm-form-card h2 {
            font-size: 1.625rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: .25rem;
        }

        .cfm-form-card .cfm-welcome-sub {
            color: #64748b;
            font-size: .9rem;
            margin-bottom: 2rem;
        }

        .form-label {
            font-weight: 600;
            font-size: .825rem;
            color: #374151;
            margin-bottom: .4rem;
        }

        .form-control {
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: .65rem 1rem;
            font-size: .9rem;
            transition: border-color .2s, box-shadow .2s;
        }

        .form-control:focus {
            border-color: #003f87;
            box-shadow: 0 0 0 3px rgba(0,63,135,.1);
        }

        .btn-cfm-primary {
            background: #f97316;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: .75rem 1.5rem;
            font-weight: 600;
            font-size: .95rem;
            width: 100%;
            transition: background .2s, transform .1s, box-shadow .2s;
        }

        .btn-cfm-primary:hover {
            background: #ea6a0a;
            color: #fff;
            box-shadow: 0 4px 16px rgba(249,115,22,.4);
            transform: translateY(-1px);
        }

        .btn-cfm-primary:active { transform: translateY(0); }

        .cfm-divider {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin: 1.5rem 0;
        }

        .cfm-footer-note {
            text-align: center;
            font-size: .78rem;
            color: #94a3b8;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            .cfm-panel-left { display: none; }
            .cfm-panel-right { background: #fff; }
        }
    </style>
</head>
<body>

    {{-- Left panel --}}
    <div class="cfm-panel-left">
        <div class="cfm-logo-box"><span>CFM</span></div>
        <div class="cfm-brand">
            <h1>Campus Formations<br>et Métiers</h1>
            <div class="cfm-sub">Bobigny — Seine-Saint-Denis (93)</div>
        </div>
        <div class="cfm-accent-bar"></div>
        <p class="cfm-tagline">
            Votre plateforme d'apprentissage en ligne pour des formations professionnelles certifiantes.
        </p>
        <div class="cfm-badge">
            <i class="bi bi-patch-check-fill"></i>
            Formations certifiantes
        </div>
    </div>

    {{-- Right panel --}}
    <div class="cfm-panel-right">
        <div class="cfm-form-card">
            <h2>Bienvenue</h2>
            <p class="cfm-welcome-sub">Connectez-vous pour accéder à votre espace CFM.</p>

            {{ $slot }}

            <p class="cfm-footer-note">
                &copy; {{ date('Y') }} Campus Formations et Métiers — Bobigny 93
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
