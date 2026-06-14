@extends('layouts.public')

@section('title', 'Accueil – UFR SATIC UADB')

@section('content')

{{-- ── HERO ─────────────────────────────────────────────── --}}
<section class="hero-section">
    <div class="container position-relative" style="z-index:1;">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="badge mb-3 px-3 py-2"
                      style="background:rgba(255,255,255,0.2);font-size:0.85rem;">
                    🎓 Année académique 2024-2025
                </span>
                <h1 class="mb-3">
                    Bienvenue à l'<span style="color:var(--uadb-accent)">UFR SATIC</span>
                </h1>
                <p class="mb-4" style="font-size:1.05rem;opacity:0.9;max-width:550px;">
                    Unité de Formation et de Recherche en Sciences Appliquées et
                    Technologies de l'Information et de la Communication.
                    Université Alioune Diop de Bambey, Sénégal.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('login') }}" class="btn btn-vert btn-lg px-4">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Mon espace
                    </a>
                    <a href="{{ route('departements') }}" class="btn btn-lg px-4"
                       style="background:rgba(255,255,255,0.15);color:white;border:2px solid rgba(255,255,255,0.5);">
                        <i class="bi bi-book me-2"></i> Nos formations
                    </a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-flex justify-content-center">
                <div class="text-center" style="opacity:0.15;">
                    <i class="bi bi-mortarboard-fill" style="font-size:12rem;color:white;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── STATS ────────────────────────────────────────────── --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-6 col-md-3">
                <div class="card-stat h-100">
                    <div class="stat-icon bg-primary bg-opacity-10 mx-auto mb-3">
                        <i class="bi bi-people-fill text-primary"></i>
                    </div>
                    <div class="stat-number">2000+</div>
                    <div class="stat-label">Étudiants inscrits</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card-stat h-100">
                    <div class="stat-icon bg-success bg-opacity-10 mx-auto mb-3">
                        <i class="bi bi-person-workspace text-success"></i>
                    </div>
                    <div class="stat-number">80+</div>
                    <div class="stat-label">Enseignants</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card-stat h-100">
                    <div class="stat-icon bg-warning bg-opacity-10 mx-auto mb-3">
                        <i class="bi bi-book-fill text-warning"></i>
                    </div>
                    <div class="stat-number">12+</div>
                    <div class="stat-label">Formations</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card-stat h-100">
                    <div class="stat-icon bg-info bg-opacity-10 mx-auto mb-3">
                        <i class="bi bi-building text-info"></i>
                    </div>
                    <div class="stat-number">4</div>
                    <div class="stat-label">Départements</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── DÉPARTEMENTS ─────────────────────────────────────── --}}
<section class="py-5" style="background:var(--uadb-gris);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Nos Départements</h2>
            <div class="section-divider mx-auto"></div>
            <p class="section-subtitle">Explorez nos domaines d'excellence académique</p>
        </div>
        <div class="row g-4">
            @forelse($departements as $dep)
            <div class="col-md-6 col-lg-3">
                <div class="card-uadb p-4 h-100 text-center">
                    <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center"
                         style="width:65px;height:65px;background:var(--uadb-bleu-light);">
                        <i class="bi bi-cpu-fill fs-3" style="color:var(--uadb-bleu);"></i>
                    </div>
                    <h5 style="color:var(--uadb-bleu);font-weight:700;">{{ $dep->nom }}</h5>
                    <p style="font-size:0.85rem;color:var(--uadb-texte);">
                        {{ $dep->description }}
                    </p>
                    <div class="mt-3">
                        <span class="badge rounded-pill"
                              style="background:var(--uadb-bleu-light);color:var(--uadb-bleu);">
                            {{ $dep->formations->count() }} formation(s)
                        </span>
                    </div>
                    <a href="{{ route('departements.show', $dep->slug) }}"
                       class="btn btn-uadb btn-sm mt-3 w-100">
                        Découvrir
                    </a>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p class="text-muted">Aucun département disponible pour le moment.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ── POURQUOI SATIC ───────────────────────────────────── --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h2 class="section-title">Pourquoi choisir l'UFR SATIC ?</h2>
                <div class="section-divider"></div>
                <div class="d-flex flex-column gap-3 mt-4">
                    <div class="d-flex gap-3 align-items-start">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                             style="width:45px;height:45px;background:var(--uadb-bleu-light);">
                            <i class="bi bi-award-fill" style="color:var(--uadb-bleu);"></i>
                        </div>
                        <div>
                            <h6 style="color:var(--uadb-bleu);font-weight:700;">Formation d'excellence</h6>
                            <p style="font-size:0.88rem;color:var(--uadb-texte);margin:0;">
                                Des programmes adaptés aux besoins du marché de l'emploi et aux standards internationaux.
                            </p>
                        </div>
                    </div>
                    <div class="d-flex gap-3 align-items-start">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                             style="width:45px;height:45px;background:var(--uadb-bleu-light);">
                            <i class="bi bi-people-fill" style="color:var(--uadb-bleu);"></i>
                        </div>
                        <div>
                            <h6 style="color:var(--uadb-bleu);font-weight:700;">Corps enseignant qualifié</h6>
                            <p style="font-size:0.88rem;color:var(--uadb-texte);margin:0;">
                                Des enseignants-chercheurs expérimentés et passionnés par la transmission du savoir.
                            </p>
                        </div>
                    </div>
                    <div class="d-flex gap-3 align-items-start">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                             style="width:45px;height:45px;background:var(--uadb-bleu-light);">
                            <i class="bi bi-laptop-fill" style="color:var(--uadb-bleu);"></i>
                        </div>
                        <div>
                            <h6 style="color:var(--uadb-bleu);font-weight:700;">Infrastructure moderne</h6>
                            <p style="font-size:0.88rem;color:var(--uadb-texte);margin:0;">
                                Des laboratoires équipés et un portail numérique pour faciliter l'apprentissage.
                            </p>
                        </div>
                    </div>
                    <div class="d-flex gap-3 align-items-start">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                             style="width:45px;height:45px;background:var(--uadb-bleu-light);">
                            <i class="bi bi-globe" style="color:var(--uadb-bleu);"></i>
                        </div>
                        <div>
                            <h6 style="color:var(--uadb-bleu);font-weight:700;">Partenariats internationaux</h6>
                            <p style="font-size:0.88rem;color:var(--uadb-texte);margin:0;">
                                Des accords avec des universités et entreprises à l'échelle internationale.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="rounded-3 p-4"
                     style="background:linear-gradient(135deg,var(--uadb-bleu) 0%,#005cbf 100%);">
                    <h4 class="text-white fw-bold mb-4">Accès rapide</h4>
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="{{ route('login') }}"
                               class="d-block text-center p-3 rounded-3 text-white"
                               style="background:rgba(255,255,255,0.15);transition:all 0.2s;"
                               onmouseover="this.style.background='rgba(255,255,255,0.25)'"
                               onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                                <i class="bi bi-person-circle fs-2 mb-2 d-block"></i>
                                <span style="font-size:0.85rem;font-weight:600;">Espace Étudiant</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('login') }}"
                               class="d-block text-center p-3 rounded-3 text-white"
                               style="background:rgba(255,255,255,0.15);transition:all 0.2s;"
                               onmouseover="this.style.background='rgba(255,255,255,0.25)'"
                               onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                                <i class="bi bi-person-workspace fs-2 mb-2 d-block"></i>
                                <span style="font-size:0.85rem;font-weight:600;">Espace Enseignant</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('actualites') }}"
                               class="d-block text-center p-3 rounded-3 text-white"
                               style="background:rgba(255,255,255,0.15);transition:all 0.2s;"
                               onmouseover="this.style.background='rgba(255,255,255,0.25)'"
                               onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                                <i class="bi bi-newspaper fs-2 mb-2 d-block"></i>
                                <span style="font-size:0.85rem;font-weight:600;">Actualités</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('contact') }}"
                               class="d-block text-center p-3 rounded-3 text-white"
                               style="background:rgba(255,255,255,0.15);transition:all 0.2s;"
                               onmouseover="this.style.background='rgba(255,255,255,0.25)'"
                               onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                                <i class="bi bi-envelope-fill fs-2 mb-2 d-block"></i>
                                <span style="font-size:0.85rem;font-weight:600;">Contact</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── ACTUALITÉS ───────────────────────────────────────── --}}
@if($actualites->count() > 0)
<section class="py-5" style="background:var(--uadb-gris);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Actualités</h2>
            <div class="section-divider mx-auto"></div>
            <p class="section-subtitle">Les dernières nouvelles de l'UFR SATIC</p>
        </div>
        <div class="row g-4">
            @foreach($actualites as $actu)
            <div class="col-md-4">
                <div class="card-uadb h-100">
                    <div style="height:180px;background:var(--uadb-bleu-light);border-radius:12px 12px 0 0;overflow:hidden;">
                        @if($actu->image)
                            <img src="{{ asset('storage/'.$actu->image) }}"
                                 class="w-100 h-100 object-fit-cover" alt="">
                        @else
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                <i class="bi bi-newspaper" style="font-size:3rem;color:var(--uadb-bleu);opacity:0.3;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <span class="badge mb-2"
                              style="background:var(--uadb-bleu-light);color:var(--uadb-bleu);font-size:0.75rem;">
                            {{ $actu->categorie ?? 'Actualité' }}
                        </span>
                        <h6 style="color:var(--uadb-bleu);font-weight:700;line-height:1.4;">
                            {{ $actu->titre }}
                        </h6>
                        <p style="font-size:0.83rem;color:var(--uadb-texte);">
                            {{ Str::limit(strip_tags($actu->contenu), 100) }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <small style="color:var(--uadb-texte);font-size:0.78rem;">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $actu->date_publication?->format('d/m/Y') }}
                            </small>
                            <a href="{{ route('actualites.show', $actu->slug) }}"
                               style="font-size:0.82rem;color:var(--uadb-bleu);font-weight:600;">
                                Lire <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('actualites') }}" class="btn btn-uadb px-5">
                Toutes les actualités <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>
@endif

{{-- ── PARTENAIRES ──────────────────────────────────────── --}}
@if($partenaires->count() > 0)
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="section-title">Nos Partenaires</h2>
            <div class="section-divider mx-auto"></div>
        </div>
        <div class="row g-3 justify-content-center align-items-center">
            @foreach($partenaires as $partenaire)
            <div class="col-6 col-md-3 col-lg-2 text-center">
                <div class="p-3 rounded-3 border"
                     style="transition:all 0.2s;"
                     onmouseover="this.style.borderColor='var(--uadb-bleu)'"
                     onmouseout="this.style.borderColor='#dee2e6'">
                    @if($partenaire->logo)
                        <img src="{{ asset('storage/'.$partenaire->logo) }}"
                             style="max-height:50px;object-fit:contain;" alt="{{ $partenaire->nom }}">
                    @else
                        <div style="font-size:0.8rem;font-weight:600;color:var(--uadb-bleu);">
                            {{ $partenaire->nom }}
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ── CTA ──────────────────────────────────────────────── --}}
<section class="py-5" style="background:linear-gradient(135deg,var(--uadb-vert) 0%,#00875a 100%);">
    <div class="container text-center text-white">
        <h2 style="font-weight:800;font-size:2rem;">Prêt à rejoindre l'UFR SATIC ?</h2>
        <p class="mt-2 mb-4" style="opacity:0.9;">
            Accédez à votre espace personnel ou contactez-nous pour plus d'informations.
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('login') }}" class="btn btn-uadb btn-lg px-5">
                <i class="bi bi-box-arrow-in-right me-2"></i> Se connecter
            </a>
            <a href="{{ route('contact') }}" class="btn btn-lg px-5"
               style="background:rgba(255,255,255,0.2);color:white;border:2px solid rgba(255,255,255,0.5);">
                <i class="bi bi-envelope me-2"></i> Nous contacter
            </a>
        </div>
    </div>
</section>

@endsection