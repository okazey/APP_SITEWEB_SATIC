@extends('layouts.dashboard')

@section('title', 'Espace Enseignant')
@section('page-title', 'Tableau de bord')

@section('sidebar-menu')
    <x-sidebar-enseignant />
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
                    @if($enseignant)
                    <p style="opacity:0.85;margin:0.3rem 0 0;">
                        {{ $enseignant->grade }} •
                        {{ $enseignant->departement->nom ?? '' }}
                    </p>
                    @endif
                </div>
                <div class="col-auto d-none d-md-block">
                    <i class="bi bi-person-workspace"
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
                <i class="bi bi-collection-fill text-primary"></i>
            </div>
            <div class="stat-number">{{ $totalCours }}</div>
            <div class="stat-label">Total cours</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card-stat">
            <div class="stat-icon bg-success bg-opacity-10 mb-3">
                <i class="bi bi-check-circle text-success"></i>
            </div>
            <div class="stat-number">{{ $coursPublies }}</div>
            <div class="stat-label">Cours publiés</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card-stat">
            <div class="stat-icon bg-warning bg-opacity-10 mb-3">
                <i class="bi bi-pencil-square text-warning"></i>
            </div>
            <div class="stat-number">{{ $coursBrouillon }}</div>
            <div class="stat-label">Brouillons</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card-stat">
            <div class="stat-icon bg-secondary bg-opacity-10 mb-3">
                <i class="bi bi-archive text-secondary"></i>
            </div>
            <div class="stat-number">{{ $coursArchives }}</div>
            <div class="stat-label">Archivés</div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Derniers cours --}}
    <div class="col-lg-8">
        <div class="card-uadb p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 style="color:var(--uadb-bleu);font-weight:700;margin:0;">
                    <i class="bi bi-book me-2"></i>Mes derniers cours
                </h5>
                <a href="{{ route('enseignant.cours') }}"
                   style="font-size:0.85rem;color:var(--uadb-bleu);">
                    Voir tout <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            @forelse($derniersCours as $cours)
            <div class="d-flex align-items-center gap-3 p-3 rounded-3 mb-2"
                 style="background:var(--uadb-gris);">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:42px;height:42px;background:var(--uadb-bleu-light);">
                    <i class="bi bi-file-earmark-pdf"
                       style="color:var(--uadb-bleu);"></i>
                </div>
                <div class="flex-grow-1">
                    <div style="font-weight:600;font-size:0.88rem;color:#333;">
                        {{ $cours->titre }}
                    </div>
                    <div style="font-size:0.78rem;color:var(--uadb-texte);">
                        {{ $cours->formation->nom ?? 'N/A' }} •
                        {{ $cours->created_at->format('d/m/Y') }}
                    </div>
                </div>
                <span class="badge badge-{{ match($cours->statut) {
                    'publie'    => 'publie',
                    'brouillon' => 'brouillon',
                    'archive'   => 'brouillon',
                    default     => 'brouillon'
                } }} px-3 py-2 rounded-pill">
                    {{ ucfirst($cours->statut) }}
                </span>
                <div class="d-flex gap-1">
                    <a href="{{ route('enseignant.cours.edit', $cours->id) }}"
                       class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    @if($cours->statut === 'brouillon')
                    <form method="POST"
                          action="{{ route('enseignant.cours.publier', $cours->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-vert">
                            <i class="bi bi-send"></i>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-4">
                <i class="bi bi-book" style="font-size:2rem;color:#ccc;"></i>
                <p class="text-muted mt-2 mb-0" style="font-size:0.88rem;">
                    Vous n'avez pas encore déposé de cours.
                </p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Actions rapides --}}
    <div class="col-lg-4">
        <div class="card-uadb p-4 mb-4">
            <h5 style="color:var(--uadb-bleu);font-weight:700;margin-bottom:1rem;">
                <i class="bi bi-lightning me-2"></i>Actions rapides
            </h5>
            <div class="d-grid gap-2">
                <a href="{{ route('enseignant.cours.create') }}"
                   class="btn btn-uadb">
                    <i class="bi bi-cloud-upload me-2"></i> Déposer un cours
                </a>
                <a href="{{ route('enseignant.cours') }}"
                   class="btn btn-outline-primary">
                    <i class="bi bi-book me-2"></i> Gérer mes cours
                </a>
                <a href="{{ route('enseignant.profil') }}"
                   class="btn btn-outline-secondary">
                    <i class="bi bi-person-circle me-2"></i> Mon profil
                </a>
            </div>
        </div>

        @if($enseignant)
        <div class="card-uadb p-4">
            <h5 style="color:var(--uadb-bleu);font-weight:700;margin-bottom:1rem;">
                <i class="bi bi-person-badge me-2"></i>Ma fiche
            </h5>
            <div style="font-size:0.85rem;">
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span style="color:var(--uadb-texte);">Grade</span>
                    <strong>{{ $enseignant->grade }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span style="color:var(--uadb-texte);">Spécialité</span>
                    <strong>{{ $enseignant->specialite ?? 'N/A' }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <span style="color:var(--uadb-texte);">Département</span>
                    <strong>{{ $enseignant->departement->nom ?? 'N/A' }}</strong>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection