<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CFM') — Campus Formations et Métiers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background-color: #f1f5f9; }

        /* Navbar */
        .cfm-navbar {
            height: 58px;
            background: #f97316;
            display: flex;
            align-items: center;
            padding: 0 1.25rem;
            gap: 1rem;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,.18);
        }

        .cfm-navbar-brand {
            display: flex;
            align-items: center;
            gap: .6rem;
            text-decoration: none;
            flex-shrink: 0;
        }

        .cfm-logo-pill {
            background: #fff;
            color: #f97316;
            font-weight: 800;
            font-size: .85rem;
            padding: .2rem .55rem;
            border-radius: 6px;
            letter-spacing: -.5px;
        }

        .cfm-navbar-brand span {
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: -.2px;
        }

        .cfm-navbar-brand small {
            color: rgba(255,255,255,.55);
            font-size: .7rem;
            font-weight: 400;
            display: block;
            line-height: 1;
        }

        .cfm-navbar-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .cfm-user-name {
            color: rgba(255,255,255,.8);
            font-size: .85rem;
            font-weight: 500;
        }

        .cfm-role-badge {
            font-size: .7rem;
            font-weight: 600;
            padding: .2rem .6rem;
            border-radius: 999px;
        }

        .cfm-role-admin   { background: #003f87; color: #fff; }
        .cfm-role-student { background: rgba(255,255,255,.15); color: #fff; }

        .btn-cfm-logout {
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.2);
            color: rgba(255,255,255,.85);
            font-size: .8rem;
            padding: .3rem .75rem;
            border-radius: 8px;
            transition: background .15s;
        }
        .btn-cfm-logout:hover { background: rgba(255,255,255,.2); color: #fff; }

        /* Sidebar */
        .cfm-sidebar {
            width: 220px;
            min-height: calc(100vh - 58px);
            background: #fff;
            border-right: 1px solid #e2e8f0;
            padding: 1.25rem .75rem;
            flex-shrink: 0;
        }

        .cfm-nav-section {
            color: #94a3b8;
            font-size: .65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .09em;
            padding: .4rem .6rem;
            margin-top: .5rem;
        }

        .cfm-nav-link {
            display: flex;
            align-items: center;
            gap: .6rem;
            color: #475569;
            font-size: .85rem;
            font-weight: 500;
            padding: .5rem .75rem;
            border-radius: 8px;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: background .15s, color .15s, border-color .15s;
            margin-bottom: 1px;
        }

        .cfm-nav-link:hover {
            background: #fff4ed;
            color: #ea6a0a;
        }

        .cfm-nav-link.active {
            background: #f97316;
            color: #fff;
            border-left: none;
            font-weight: 600;
        }

        .cfm-nav-link.active i { color: #fff; }

        .cfm-nav-ai {
            background: linear-gradient(135deg, rgba(99,102,241,.08), rgba(139,92,246,.08));
            border-left-color: transparent;
        }

        .cfm-nav-ai.active, .cfm-nav-ai:hover {
            background: linear-gradient(135deg, rgba(99,102,241,.15), rgba(139,92,246,.15));
            color: #6366f1;
            border-left-color: #8b5cf6;
        }

        .cfm-nav-ai i { color: #8b5cf6; }

        /* Main content */
        .cfm-main {
            flex: 1;
            padding: 1.75rem;
            min-width: 0;
        }

        /* Alerts */
        .alert { border-radius: 10px; border: none; font-size: .875rem; }
    </style>
</head>
<body>

    {{-- Top navbar --}}
    <nav class="cfm-navbar">
        <a class="cfm-navbar-brand" href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('apprenant.dashboard') }}">
            <div class="cfm-logo-pill">CFM</div>
            <div>
                <span>Campus Formations et Métiers</span>
                <small>Bobigny 93</small>
            </div>
        </a>
        <div class="cfm-navbar-right">
            <span class="cfm-user-name d-none d-sm-inline">{{ auth()->user()->name }}</span>
            @if(auth()->user()->isAdmin())
                <span class="cfm-role-badge cfm-role-admin">Admin</span>
            @else
                <span class="cfm-role-badge cfm-role-student">Apprenant</span>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button class="btn-cfm-logout btn">
                    <i class="bi bi-box-arrow-right me-1"></i>Déconnexion
                </button>
            </form>
        </div>
    </nav>

    <div class="d-flex" style="min-height: calc(100vh - 58px);">

        {{-- Sidebar --}}
        <div class="cfm-sidebar">
            @if(auth()->user()->isAdmin())
                <div class="cfm-nav-section">Administration</div>
                <nav class="d-flex flex-column gap-0">
                    <a href="{{ route('admin.dashboard') }}" class="cfm-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>Dashboard
                    </a>
                    <a href="{{ route('admin.formations.index') }}" class="cfm-nav-link {{ request()->routeIs('admin.formations*') ? 'active' : '' }}">
                        <i class="bi bi-collection"></i>Formations
                    </a>
                    <a href="{{ route('admin.chapitres.index') }}" class="cfm-nav-link {{ request()->routeIs('admin.chapitres*') ? 'active' : '' }}">
                        <i class="bi bi-journals"></i>Chapitres
                    </a>
                    <a href="{{ route('admin.quizzes.index') }}" class="cfm-nav-link {{ request()->routeIs('admin.quizzes*') ? 'active' : '' }}">
                        <i class="bi bi-patch-question"></i>Quiz
                    </a>
                    <a href="{{ route('admin.apprenants.index') }}" class="cfm-nav-link {{ request()->routeIs('admin.apprenants*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>Apprenants
                    </a>
                    <a href="{{ route('admin.notes.index') }}" class="cfm-nav-link {{ request()->routeIs('admin.notes*') ? 'active' : '' }}">
                        <i class="bi bi-clipboard-check"></i>Notes
                    </a>
                </nav>

                <div class="cfm-nav-section" style="margin-top:1.25rem;">Outils IA</div>
                <nav>
                    <a href="{{ route('admin.ai-generator') }}"
                       class="cfm-nav-link cfm-nav-ai {{ request()->routeIs('admin.ai-generator*') ? 'active' : '' }}">
                        <i class="bi bi-stars"></i>Générer avec l'IA
                    </a>
                </nav>
            @else
                <div class="cfm-nav-section">Mon espace</div>
                <nav class="d-flex flex-column gap-0">
                    <a href="{{ route('apprenant.dashboard') }}" class="cfm-nav-link {{ request()->routeIs('apprenant.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-house"></i>Dashboard
                    </a>
                    <a href="{{ route('apprenant.formations.index') }}" class="cfm-nav-link {{ request()->routeIs('apprenant.formations*') ? 'active' : '' }}">
                        <i class="bi bi-collection"></i>Mes formations
                    </a>
                    <a href="{{ route('apprenant.notes.index') }}" class="cfm-nav-link {{ request()->routeIs('apprenant.notes*') ? 'active' : '' }}">
                        <i class="bi bi-clipboard-check"></i>Mes notes
                    </a>
                </nav>
            @endif
        </div>

        {{-- Main content --}}
        <div class="cfm-main">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
