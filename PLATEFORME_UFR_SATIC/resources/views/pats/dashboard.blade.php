@extends('layouts.dashboard')

@section('title', 'Espace PATS')
@section('page-title', 'Tableau de bord')

@section('sidebar-menu')
    <x-sidebar-pats />
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
                    @if($pats)
                    <p style="opacity:0.85;margin:0.3rem 0 0;">
                        {{ $pats->fonction }} • {{ $pats->service }}
                    </p>
                    @endif
                </div>
                <div class="col-auto d-none d-md-block">
                    <i class="bi bi-person-badge"
                       style="font-size:3rem;opacity:0.3;"></i>
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
                <i class="bi bi-inbox-fill text-primary"></i>
            </div>
            <div class="stat-number">{{ $totalDemandes }}</div>
            <div class="stat-label">Total demandes</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card-stat">
            <div class="stat-icon bg-warning bg-opacity-10 mb-3">
                <i class="bi bi-hourglass text-warning"></i>
            </div>
            <div class="stat-number">{{ $enAttente }}</div>
            <div class="stat-label">En attente</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card-stat">
            <div class="stat-icon bg-success bg-opacity-10 mb-3">
                <i class="bi bi-check-circle text-success"></i>
            </div>
            <div class="stat-number">{{ $validees }}</div>
            <div class="stat-label">Validées</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card-stat">
            <div class="stat-icon bg-danger bg-opacity-10 mb-3">
                <i class="bi bi-x-circle text-danger"></i>
            </div>
            <div class="stat-number">{{ $rejetees }}</div>
            <div class="stat-label">Rejetées</div>
        </div>
    </div>
</div>

{{-- Dernières demandes --}}
<div class="card-uadb p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 style="color:var(--uadb-bleu);font-weight:700;margin:0;">
            <i class="bi bi-clock-history me-2"></i>Dernières demandes
        </h5>
        <a href="{{ route('pats.demandes') }}"
           style="font-size:0.85rem;color:var(--uadb-bleu);">
            Voir tout <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    @forelse($dernieresDemandes as $demande)
    <div class="d-flex align-items-center gap-3 p-3 rounded-3 mb-2"
         style="background:var(--uadb-gris);">
        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
             style="width:42px;height:42px;background:var(--uadb-bleu-light);">
            <i class="bi bi-file-earmark-text"
               style="color:var(--uadb-bleu);"></i>
        </div>
        <div class="flex-grow-1">
            <div style="font-weight:600;font-size:0.88rem;color:#333;">
                {{ $demande->libelle_type }}
            </div>
            <div style="font-size:0.78rem;color:var(--uadb-texte);">
                {{ $demande->etudiant->user->nom_complet ?? 'N/A' }} •
                {{ $demande->etudiant->matricule ?? '' }} •
                {{ $demande->date_soumission?->format('d/m/Y') }}
            </div>
        </div>
        <span class="badge badge-{{ $demande->badge_statut }} px-3 py-2 rounded-pill">
            {{ ucfirst(str_replace('_', ' ', $demande->statut)) }}
        </span>
        <a href="{{ route('pats.demandes.show', $demande->id) }}"
           class="btn btn-sm btn-outline-primary">
            <i class="bi bi-eye"></i>
        </a>
    </div>
    @empty
    <div class="text-center py-4">
        <i class="bi bi-inbox" style="font-size:2rem;color:#ccc;"></i>
        <p class="text-muted mt-2 mb-0" style="font-size:0.88rem;">
            Aucune demande pour le moment.
        </p>
    </div>
    @endforelse
</div>

@endsection