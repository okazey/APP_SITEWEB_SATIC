@extends('layouts.dashboard')

@section('title', 'Mes Demandes')
@section('page-title', 'Mes Demandes Administratives')

@section('sidebar-menu')
    <x-sidebar-etudiant />
@endsection
@section('content')
    <div class="sidebar-section-title">Principal</div>
    <a href="{{ route('etudiant.dashboard') }}" class="nav-link">
        <i class="bi bi-grid"></i> Dashboard
    </a>
    <div class="sidebar-section-title">Académique</div>
    <a href="{{ route('etudiant.cours') }}" class="nav-link">
        <i class="bi bi-book"></i> Mes cours
    </a>
    <a href="{{ route('etudiant.emploi-du-temps') }}" class="nav-link">
        <i class="bi bi-calendar3"></i> Emploi du temps
    </a>
    <div class="sidebar-section-title">Administratif</div>
    <a href="{{ route('etudiant.demandes') }}" class="nav-link active">
        <i class="bi bi-file-earmark-text"></i> Mes demandes
    </a>
    <a href="{{ route('etudiant.notifications') }}" class="nav-link">
        <i class="bi bi-bell"></i> Notifications
    </a>
    <div class="sidebar-section-title">Mon compte</div>
    <a href="{{ route('etudiant.profil') }}" class="nav-link">
        <i class="bi bi-person-circle"></i> Mon profil
    </a>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 style="color:var(--uadb-bleu);font-weight:700;margin:0;">
        Historique de mes demandes
    </h5>
    <a href="{{ route('etudiant.demandes.create') }}" class="btn btn-uadb">
        <i class="bi bi-plus-circle me-2"></i> Nouvelle demande
    </a>
</div>

@if($demandes->count() > 0)
<div class="card-uadb">
    <div class="table-responsive">
        <table class="table table-uadb mb-0">
            <thead>
                <tr>
                    <th>Type de demande</th>
                    <th>Date soumission</th>
                    <th>Statut</th>
                    <th>Date traitement</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($demandes as $demande)
                <tr>
                    <td>
                        <div style="font-weight:600;font-size:0.88rem;">
                            {{ $demande->libelle_type }}
                        </div>
                    </td>
                    <td style="font-size:0.85rem;">
                        {{ $demande->date_soumission?->format('d/m/Y H:i') }}
                    </td>
                    <td>
                        <span class="badge badge-{{ $demande->badge_statut }} px-3 py-2 rounded-pill">
                            {{ ucfirst(str_replace('_', ' ', $demande->statut)) }}
                        </span>
                    </td>
                    <td style="font-size:0.85rem;">
                        {{ $demande->date_traitement?->format('d/m/Y') ?? '–' }}
                    </td>
                    <td>
                        <a href="{{ route('etudiant.demandes.show', $demande->id) }}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i> Détail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $demandes->links('pagination::bootstrap-5') }}
</div>

@else
<div class="card-uadb p-5 text-center">
    <i class="bi bi-file-earmark-x" style="font-size:4rem;color:#ccc;"></i>
    <h5 class="mt-3 text-muted">Aucune demande pour le moment.</h5>
    <a href="{{ route('etudiant.demandes.create') }}" class="btn btn-uadb mt-3">
        <i class="bi bi-plus-circle me-2"></i> Faire une demande
    </a>
</div>
@endif

@endsection