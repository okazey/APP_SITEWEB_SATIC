@extends('layouts.dashboard')

@section('title', 'Demandes Administratives')
@section('page-title', 'Gestion des demandes')

@section('sidebar-menu')
    <x-sidebar-pats />
@endsection

@section('content')

{{-- Filtres & Recherche --}}
<div class="card-uadb p-3 mb-4">
    <form method="GET" action="{{ route('pats.demandes') }}">
        <div class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label" style="font-size:0.85rem;">
                    Rechercher un étudiant
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-light">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text"
                           name="recherche"
                           value="{{ $recherche }}"
                           class="form-control"
                           placeholder="Nom, prénom ou matricule...">
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label" style="font-size:0.85rem;">
                    Statut
                </label>
                <select name="statut" class="form-select">
                    <option value="">Tous les statuts</option>
                    @foreach([
                        'en_attente' => 'En attente',
                        'en_cours'   => 'En cours',
                        'validee'    => 'Validée',
                        'rejetee'    => 'Rejetée',
                    ] as $val => $label)
                    <option value="{{ $val }}"
                            {{ $statut === $val ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-uadb w-100">
                    <i class="bi bi-funnel me-2"></i> Filtrer
                </button>
            </div>
        </div>
    </form>
</div>

{{-- Liste --}}
@if($demandes->count() > 0)
<div class="card-uadb">
    <div class="table-responsive">
        <table class="table table-uadb mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Étudiant</th>
                    <th>Type de demande</th>
                    <th>Date soumission</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($demandes as $demande)
                <tr>
                    <td style="font-size:0.85rem;color:var(--uadb-texte);">
                        #{{ $demande->id }}
                    </td>
                    <td>
                        <div style="font-weight:600;font-size:0.88rem;">
                            {{ $demande->etudiant->user->nom_complet ?? 'N/A' }}
                        </div>
                        <small style="color:var(--uadb-texte);">
                            {{ $demande->etudiant->matricule ?? '' }}
                        </small>
                    </td>
                    <td style="font-size:0.88rem;">
                        {{ $demande->libelle_type }}
                    </td>
                    <td style="font-size:0.85rem;">
                        {{ $demande->date_soumission?->format('d/m/Y H:i') }}
                    </td>
                    <td>
                        <span class="badge badge-{{ $demande->badge_statut }} px-3 py-2 rounded-pill">
                            {{ ucfirst(str_replace('_', ' ', $demande->statut)) }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('pats.demandes.show', $demande->id) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if($demande->statut === 'en_attente')
                            <form method="POST"
                                  action="{{ route('pats.demandes.traiter', $demande->id) }}">
                                @csrf
                                <button type="submit"
                                        class="btn btn-sm btn-outline-info"
                                        title="Prendre en charge">
                                    <i class="bi bi-arrow-repeat"></i>
                                </button>
                            </form>
                            @endif
                        </div>
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
    <i class="bi bi-inbox" style="font-size:4rem;color:#ccc;"></i>
    <h5 class="mt-3 text-muted">Aucune demande trouvée.</h5>
</div>
@endif

@endsection