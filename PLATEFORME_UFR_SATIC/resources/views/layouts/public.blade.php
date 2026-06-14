<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portail UFR SATIC - UADB')</title>

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- CSS UADB -->
    <link href="{{ asset('css/uadb.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body>

{{-- ── NAVBAR ──────────────────────────────────────────── --}}
<nav class="navbar navbar-expand-lg navbar-uadb">
    <div class="container">
        {{-- Logo --}}
        <a class="navbar-brand" href="{{ route('accueil') }}">
            <div class="logo-icon bg-white rounded p-1 me-2">
                <i class="bi bi-mortarboard-fill text-primary fs-5"></i>
            </div>
            <div class="logo-text">
                <span class="logo-title">UFR SATIC</span>
                <span class="logo-subtitle">Université Alioune Diop de Bambey</span>
            </div>
        </a>

        {{-- Toggle mobile --}}
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <i class="bi bi-list text-white fs-4"></i>
        </button>

        {{-- Menu --}}
        <div class="collapse navbar-collapse" id="navMenu">
           <ul class="navbar-nav mx-auto gap-1">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('accueil') ? 'active' : '' }}"
           href="{{ route('accueil') }}">
            <i class="bi bi-house me-1"></i> Accueil
        </a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle {{ request()->routeIs('presentation') ? 'active' : '' }}"
           href="#" data-bs-toggle="dropdown">
            <i class="bi bi-building me-1"></i> UFR SATIC
        </a>
        <ul class="dropdown-menu">
            <li>
                <a class="dropdown-item" href="{{ route('presentation') }}">
                    <i class="bi bi-info-circle me-2"></i>Présentation
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('departements') }}">
                    <i class="bi bi-building me-2"></i>Départements
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('personnel') }}">
                    <i class="bi bi-people me-2"></i>Personnel
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('actualites*') ? 'active' : '' }}"
           href="{{ route('actualites') }}">
            <i class="bi bi-newspaper me-1"></i> Actualités
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
           href="{{ route('contact') }}">
            <i class="bi bi-envelope me-1"></i> Contact
        </a>
    </li>
</ul>
            {{-- Bouton connexion --}}
            @auth
                <a href="{{ match(auth()->user()->type) {
                    'administrateur' => route('admin.dashboard'),
                    'enseignant'     => route('enseignant.dashboard'),
                    'pats'           => route('pats.dashboard'),
                    default          => route('etudiant.dashboard'),
                } }}" class="btn btn-connexion">
                    <i class="bi bi-grid me-1"></i> Mon espace
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-connexion">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Connexion
                </a>
            @endauth
        </div>
    </div>
</nav>

{{-- ── CONTENU ──────────────────────────────────────────── --}}
@yield('content')

{{-- ── FOOTER ───────────────────────────────────────────── --}}
<footer class="footer-uadb">
    <div class="container">
        <div class="row g-4">
            {{-- Logo & description --}}
            <div class="col-lg-4">
                <h5><i class="bi bi-mortarboard-fill me-2"></i>UFR SATIC</h5>
                <p style="font-size:0.88rem; opacity:0.8;">
                    Unité de Formation et de Recherche en Sciences Appliquées
                    et Technologies de l'Information et de la Communication.
                    Université Alioune Diop de Bambey, Sénégal.
                </p>
                <div class="d-flex gap-2 mt-3">
                    <a href="#" class="btn btn-sm btn-outline-light rounded-circle">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-light rounded-circle">
                        <i class="bi bi-twitter-x"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-light rounded-circle">
                        <i class="bi bi-linkedin"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-light rounded-circle">
                        <i class="bi bi-youtube"></i>
                    </a>
                </div>
            </div>

            {{-- Liens rapides --}}
            <div class="col-lg-2 col-6">
                <h5>Liens rapides</h5>
                <ul class="list-unstyled" style="font-size:0.88rem;">
                    <li class="mb-2"><a href="#"><i class="bi bi-chevron-right me-1"></i>Accueil</a></li>
                    <li class="mb-2"><a href="#"><i class="bi bi-chevron-right me-1"></i>Présentation</a></li>
                    <li class="mb-2"><a href="#"><i class="bi bi-chevron-right me-1"></i>Formations</a></li>
                    <li class="mb-2"><a href="#"><i class="bi bi-chevron-right me-1"></i>Actualités</a></li>
                    <li class="mb-2"><a href="#"><i class="bi bi-chevron-right me-1"></i>Contact</a></li>
                </ul>
            </div>

            {{-- Formations --}}
            <div class="col-lg-2 col-6">
                <h5>Formations</h5>
                <ul class="list-unstyled" style="font-size:0.88rem;">
                    <li class="mb-2"><a href="#"><i class="bi bi-chevron-right me-1"></i>D2A</a></li>
                    <li class="mb-2"><a href="#"><i class="bi bi-chevron-right me-1"></i>SRT</a></li>
                    <li class="mb-2"><a href="#"><i class="bi bi-chevron-right me-1"></i>MPCI</a></li>
                    <li class="mb-2"><a href="#"><i class="bi bi-chevron-right me-1"></i>Masters</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div class="col-lg-4">
                <h5>Contact</h5>
                <ul class="list-unstyled" style="font-size:0.88rem;">
                    <li class="mb-2">
                        <i class="bi bi-geo-alt me-2" style="color:var(--uadb-accent)"></i>
                        Bambey, Sénégal
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-telephone me-2" style="color:var(--uadb-accent)"></i>
                        +221 33 XXX XX XX
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-envelope me-2" style="color:var(--uadb-accent)"></i>
                        contact@uadb.edu.sn
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-globe me-2" style="color:var(--uadb-accent)"></i>
                        www.uadb.edu.sn
                    </li>
                </ul>
            </div>
        </div>

        {{-- Footer bottom --}}
        <div class="footer-bottom text-center">
            <p class="mb-0">
                © {{ date('Y') }} UFR SATIC – Université Alioune Diop de Bambey.
                Tous droits réservés.
            </p>
        </div>
    </div>
</footer>

{{-- ── CHATBOT BOUTON ────────────────────────────────────── --}}
@auth
<button class="chatbot-btn" onclick="toggleChatbot()" title="Assistant virtuel">
    <i class="bi bi-chat-dots-fill" id="chatbot-icon"></i>
</button>

<div class="chatbot-window" id="chatbotWindow">
    <div class="chatbot-header">
        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center"
             style="width:38px;height:38px;">
            <i class="bi bi-robot text-primary fs-5"></i>
        </div>
        <div>
            <div style="font-weight:700;font-size:0.9rem;">Assistant SATIC</div>
            <div style="font-size:0.75rem;opacity:0.8;">En ligne</div>
        </div>
        <button onclick="toggleChatbot()"
                class="btn btn-sm ms-auto"
                style="color:white;background:rgba(255,255,255,0.2);border:none;">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
    <div class="chatbot-messages" id="chatMessages">
        <div class="chatbot-message bot">
            👋 Bonjour ! Je suis l'assistant virtuel de l'UFR SATIC.
            Comment puis-je vous aider ?
        </div>
    </div>
    <div class="chatbot-input">
        <input type="text"
               id="chatInput"
               class="form-control form-control-sm"
               placeholder="Posez votre question..."
               onkeypress="if(event.key==='Enter') sendMessage()">
        <button onclick="sendMessage()" class="btn btn-sm btn-uadb px-3">
            <i class="bi bi-send-fill"></i>
        </button>
    </div>
</div>
@endauth

{{-- ── SCRIPTS ───────────────────────────────────────────── --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
function toggleChatbot() {
    const win  = document.getElementById('chatbotWindow');
    const icon = document.getElementById('chatbot-icon');
    win.classList.toggle('active');
    icon.className = win.classList.contains('active')
        ? 'bi bi-x-lg'
        : 'bi bi-chat-dots-fill';
}

async function sendMessage() {
    const input = document.getElementById('chatInput');
    const msg   = input.value.trim();
    if (!msg) return;

    const messages = document.getElementById('chatMessages');

    // Message utilisateur
    messages.innerHTML += `
        <div class="chatbot-message user">${msg}</div>`;
    input.value = '';
    messages.scrollTop = messages.scrollHeight;

    // Appel API chatbot
    try {
        const res = await fetch('/api/chatbot', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ message: msg }),
        });
        const data = await res.json();
        messages.innerHTML += `
            <div class="chatbot-message bot">${data.reponse}</div>`;
    } catch {
        messages.innerHTML += `
            <div class="chatbot-message bot">
                Désolé, je rencontre un problème. Réessayez plus tard.
            </div>`;
    }
    messages.scrollTop = messages.scrollHeight;
}
</script>

@stack('scripts')
</body>
</html>