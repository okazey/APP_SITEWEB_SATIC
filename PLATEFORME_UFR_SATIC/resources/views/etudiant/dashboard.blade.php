@extends('layouts.dashboard')

@section('title', 'Mon Espace Étudiant')
@section('page-title', 'Tableau de bord')

@section('sidebar-menu')
    <x-sidebar-etudiant />
@endsection

@section('content')

{{-- Bienvenue --}}
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="p-4 rounded-3"
             style="background:linear-gradient(135deg,var(--uadb-bleu) 0%,#005cbf 100%);color:white;">
            <div class="row align-items-center">
                <div class="col">
                    <h4 style="font-weight:800;margin:0;">
                        Bonjour, {{ auth()->user()->prenom }} 👋
                    </h4>
                    @if($etudiant)
                    <p style="opacity:0.85;margin:0.3rem 0 0;">
                        {{ $etudiant->matricule }} •
                        {{ $etudiant->niveau }} •
                        {{ $etudiant->formation->nom ?? '' }}
                    </p>
                    @endif
                </div>
                <div class="col-auto d-none d-md-block">
                    <i class="bi bi-mortarboard-fill" style="font-size:3rem;opacity:0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Stats --}}
<div class="row g-4 mb-4">
    <div class="col-6 col-md-3">
        <div class="card-stat">
            <div class="stat-icon bg-primary bg-opacity-10 mb-3">
                <i class="bi bi-book-fill text-primary"></i>
            </div>
            <div class="stat-number">{{ $totalCours }}</div>
            <div class="stat-label">Cours disponibles</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card-stat">
            <div class="stat-icon bg-warning bg-opacity-10 mb-3">
                <i class="bi bi-hourglass text-warning"></i>
            </div>
            <div class="stat-number">{{ $demandesEnAttente }}</div>
            <div class="stat-label">Demandes en attente</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card-stat">
            <div class="stat-icon bg-success bg-opacity-10 mb-3">
                <i class="bi bi-check-circle text-success"></i>
            </div>
            <div class="stat-number">{{ $demandesValidees }}</div>
            <div class="stat-label">Demandes validées</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card-stat">
            <div class="stat-icon bg-info bg-opacity-10 mb-3">
                <i class="bi bi-bell-fill text-info"></i>
            </div>
            <div class="stat-number">{{ $notifications }}</div>
            <div class="stat-label">Notifications</div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Derniers cours --}}
    <div class="col-lg-8">
        <div class="card-uadb p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 style="color:var(--uadb-bleu);font-weight:700;margin:0;">
                    <i class="bi bi-book me-2"></i>Derniers cours
                </h5>
                <a href="{{ route('etudiant.cours') }}"
                   style="font-size:0.85rem;color:var(--uadb-bleu);">
                    Voir tout <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            @forelse($derniersCours as $cours)
            <div class="d-flex align-items-center gap-3 p-3 rounded-3 mb-2"
                 style="background:var(--uadb-gris);">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:42px;height:42px;background:var(--uadb-bleu-light);">
                    <i class="bi bi-file-earmark-pdf" style="color:var(--uadb-bleu);"></i>
                </div>
                <div class="flex-grow-1">
                    <div style="font-weight:600;font-size:0.88rem;color:#333;">
                        {{ $cours->titre }}
                    </div>
                    <div style="font-size:0.78rem;color:var(--uadb-texte);">
                        {{ $cours->enseignant->user->nom_complet ?? 'N/A' }} •
                        {{ $cours->date_publication?->format('d/m/Y') }}
                    </div>
                </div>
                @if($cours->fichier)
                <a href="{{ route('etudiant.cours.telecharger', $cours->id) }}"
                   class="btn btn-sm btn-uadb">
                    <i class="bi bi-download"></i>
                </a>
                @endif
            </div>
            @empty
            <div class="text-center py-4">
                <i class="bi bi-book" style="font-size:2rem;color:#ccc;"></i>
                <p class="text-muted mt-2 mb-0" style="font-size:0.88rem;">
                    Aucun cours disponible pour le moment.
                </p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Notifications --}}
    <div class="col-lg-4">
        <div class="card-uadb p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 style="color:var(--uadb-bleu);font-weight:700;margin:0;">
                    <i class="bi bi-bell me-2"></i>Notifications
                </h5>
                <a href="{{ route('etudiant.notifications') }}"
                   style="font-size:0.85rem;color:var(--uadb-bleu);">
                    Tout voir
                </a>
            </div>
            @forelse($dernieresNotifs as $notif)
            <div class="p-3 rounded-3 mb-2 {{ $notif->lu ? '' : 'border-start border-3 border-primary' }}"
                 style="background:{{ $notif->lu ? 'var(--uadb-gris)' : 'var(--uadb-bleu-light)' }};">
                <div style="font-size:0.82rem;color:#333;">{{ $notif->message }}</div>
                <div style="font-size:0.72rem;color:var(--uadb-texte);margin-top:0.3rem;">
                    {{ $notif->date_envoi?->diffForHumans() }}
                </div>
            </div>
            @empty
            <div class="text-center py-4">
                <i class="bi bi-bell-slash" style="font-size:2rem;color:#ccc;"></i>
                <p class="text-muted mt-2 mb-0" style="font-size:0.85rem;">
                    Aucune notification.
                </p>
            </div>
            @endforelse
        </div>

        {{-- Accès rapide --}}
        <div class="card-uadb p-4 mt-4">
            <h5 style="color:var(--uadb-bleu);font-weight:700;margin-bottom:1rem;">
                <i class="bi bi-lightning me-2"></i>Accès rapide
            </h5>
            <div class="d-grid gap-2">
                <a href="{{ route('etudiant.demandes.create') }}" class="btn btn-uadb">
                    <i class="bi bi-plus-circle me-2"></i> Nouvelle demande
                </a>
                <a href="{{ route('etudiant.emploi-du-temps') }}" class="btn btn-outline-primary">
                    <i class="bi bi-calendar3 me-2"></i> Emploi du temps
                </a>
            </div>
        </div>
    </div>
</div>

@endsection