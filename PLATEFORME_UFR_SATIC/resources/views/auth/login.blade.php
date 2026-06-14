<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion – UFR SATIC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/uadb.css') }}" rel="stylesheet">
    <style>
        body { background: var(--uadb-gris); }
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-left {
            background: linear-gradient(135deg, var(--uadb-bleu) 0%, #005cbf 100%);
            border-radius: var(--radius-lg) 0 0 var(--radius-lg);
            padding: 3rem;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 550px;
        }
        .login-right {
            background: white;
            border-radius: 0 var(--radius-lg) var(--radius-lg) 0;
            padding: 3rem;
            min-height: 550px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-card {
            box-shadow: var(--shadow-lg);
            border-radius: var(--radius-lg);
            overflow: hidden;
        }
    </style>
</head>
<body>
<div class="login-wrapper p-3">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-xl-8">
                <div class="login-card">
                    <div class="row g-0">

                        {{-- Gauche --}}
                        <div class="col-lg-5 login-left">
                            <div>
                                <div class="d-flex align-items-center gap-3 mb-4">
                                    <div class="bg-white rounded-circle p-2">
                                        <i class="bi bi-mortarboard-fill text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight:800;font-size:1.1rem;">UFR SATIC</div>
                                        <div style="font-size:0.75rem;opacity:0.8;">Université Alioune Diop de Bambey</div>
                                    </div>
                                </div>
                                <h2 style="font-weight:800;font-size:1.8rem;line-height:1.3;">
                                    Bienvenue sur votre portail universitaire
                                </h2>
                                <p style="opacity:0.85;font-size:0.9rem;margin-top:1rem;">
                                    Accédez à vos cours, emplois du temps, demandes administratives et bien plus encore.
                                </p>
                                <hr style="border-color:rgba(255,255,255,0.3);margin:1.5rem 0;">
                                <div class="d-flex flex-column gap-2" style="font-size:0.85rem;">
                                    <div><i class="bi bi-check-circle me-2" style="color:var(--uadb-accent)"></i>Cours et documents en ligne</div>
                                    <div><i class="bi bi-check-circle me-2" style="color:var(--uadb-accent)"></i>Demandes administratives</div>
                                    <div><i class="bi bi-check-circle me-2" style="color:var(--uadb-accent)"></i>Emplois du temps</div>
                                    <div><i class="bi bi-check-circle me-2" style="color:var(--uadb-accent)"></i>Assistant virtuel IA</div>
                                </div>
                            </div>
                        </div>

                        {{-- Droite --}}
                        <div class="col-lg-7 login-right">
                            <h3 style="font-weight:800;color:var(--uadb-bleu);margin-bottom:0.3rem;">
                                Connexion
                            </h3>
                            <p style="color:var(--uadb-texte);font-size:0.9rem;margin-bottom:2rem;">
                                Entrez vos identifiants pour accéder à votre espace
                            </p>

                            {{-- Erreurs --}}
                            @if($errors->any())
                                <div class="alert alert-danger alert-uadb">
                                    <i class="bi bi-exclamation-circle me-2"></i>
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                {{-- Email --}}
                                <div class="mb-3">
                                    <label class="form-label">Adresse email</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-envelope" style="color:var(--uadb-bleu)"></i>
                                        </span>
                                        <input type="email"
                                               name="email"
                                               value="{{ old('email') }}"
                                               class="form-control border-start-0 @error('email') is-invalid @enderror"
                                               placeholder="votre@email.com"
                                               required autofocus>
                                    </div>
                                </div>

                                {{-- Mot de passe --}}
                                <div class="mb-3">
                                    <label class="form-label">Mot de passe</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-lock" style="color:var(--uadb-bleu)"></i>
                                        </span>
                                        <input type="password"
                                               name="password"
                                               id="password"
                                               class="form-control border-start-0 border-end-0"
                                               placeholder="••••••••"
                                               required>
                                        <span class="input-group-text bg-light border-start-0"
                                              style="cursor:pointer;"
                                              onclick="togglePassword()">
                                            <i class="bi bi-eye" id="eye-icon"></i>
                                        </span>
                                    </div>
                                </div>

                                {{-- Remember me --}}
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                               name="remember" id="remember">
                                        <label class="form-check-label" for="remember"
                                               style="font-size:0.88rem;">
                                            Se souvenir de moi
                                        </label>
                                    </div>
                                    <a href="#" style="font-size:0.88rem;color:var(--uadb-bleu);">
                                        Mot de passe oublié ?
                                    </a>
                                </div>

                                {{-- Bouton --}}
                                <button type="submit" class="btn btn-uadb w-100 py-2 fs-6">
                                    <i class="bi bi-box-arrow-in-right me-2"></i> Se connecter
                                </button>
                            </form>

                            <hr class="my-4">
                            <p class="text-center mb-0" style="font-size:0.85rem;color:var(--uadb-texte);">
                                <a href="{{ route('accueil') }}" style="color:var(--uadb-bleu);">
                                    <i class="bi bi-arrow-left me-1"></i> Retour au site
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePassword() {
    const pwd  = document.getElementById('password');
    const icon = document.getElementById('eye-icon');
    if (pwd.type === 'password') {
        pwd.type  = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        pwd.type  = 'password';
        icon.className = 'bi bi-eye';
    }
}
</script>
</body>
</html>