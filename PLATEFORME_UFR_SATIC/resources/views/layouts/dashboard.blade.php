<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') – UFR SATIC</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/uadb.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body>

{{-- ── SIDEBAR ──────────────────────────────────────────── --}}
<div class="sidebar" id="sidebar">

    {{-- Brand --}}
    <div class="sidebar-brand">
        <div class="d-flex align-items-center gap-2">
            <div class="bg-white rounded p-1">
                <i class="bi bi-mortarboard-fill text-primary fs-5"></i>
            </div>
            <div>
                <div class="brand-title">UFR SATIC</div>
                <div class="brand-sub">UADB – Bambey</div>
            </div>
        </div>
    </div>

    {{-- Profil utilisateur --}}
    <div class="p-3 border-bottom" style="border-color:rgba(255,255,255,0.1)!important;">
        <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle bg-white d-flex align-items-center justify-content-center"
                 style="width:40px;height:40px;min-width:40px;">
                @if(auth()->user()->photo)
                    <img src="{{ asset('storage/'.auth()->user()->photo) }}"
                         class="rounded-circle w-100 h-100 object-fit-cover" alt="">
                @else
                    <i class="bi bi-person-fill text-primary fs-5"></i>
                @endif
            </div>
            <div style="overflow:hidden;">
                <div style="color:white;font-weight:600;font-size:0.85rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ auth()->user()->nom_complet }}
                </div>
                <div style="color:rgba(255,255,255,0.6);font-size:0.72rem;">
                    {{ ucfirst(auth()->user()->type) }}
                </div>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="py-2">
        @yield('sidebar-menu')

        {{-- Liens communs --}}
        <div class="sidebar-section-title">Compte</div>
        <a href="{{ route('accueil') }}" class="nav-link">
            <i class="bi bi-globe"></i> Site public
        </a>
        <a href="#" class="nav-link">
            <i class="bi bi-person-circle"></i> Mon profil
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent"
                    style="color:rgba(0, 0, 0, 0.75);">
                <i class="bi bi-box-arrow-left"></i> Déconnexion
            </button>
        </form>
    </nav>
</div>

{{-- ── CONTENU PRINCIPAL ────────────────────────────────── --}}
<div class="main-with-sidebar">

    {{-- Topbar --}}
    <div class="topbar d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm d-lg-none" onclick="toggleSidebar()">
                <i class="bi bi-list fs-5"></i>
            </button>
            <span class="page-title">@yield('page-title', 'Dashboard')</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            {{-- Notifications --}}
            <div class="position-relative">
                <button class="btn btn-sm btn-light rounded-circle p-2">
                    <i class="bi bi-bell"></i>
                </button>
                @php
                    $notifsCount = auth()->user()->notifications()->where('lu', false)->count();
                @endphp
                @if($notifsCount > 0)
                    <span class="notif-badge">{{ $notifsCount }}</span>
                @endif
            </div>
            {{-- Avatar --}}
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center"
                     style="width:35px;height:35px;font-size:0.8rem;color:white;font-weight:700;">
                    {{ strtoupper(substr(auth()->user()->prenom, 0, 1)) }}{{ strtoupper(substr(auth()->user()->nom, 0, 1)) }}
                </div>
                <span style="font-size:0.85rem;font-weight:600;color:#333;">
                    {{ auth()->user()->prenom }}
                </span>
            </div>
        </div>
    </div>

    {{-- Page content --}}
    <div class="p-4">
        {{-- Alertes --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show alert-uadb" role="alert">
                <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show alert-uadb" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('show');
}
</script>

@stack('scripts')
</body>
</html>