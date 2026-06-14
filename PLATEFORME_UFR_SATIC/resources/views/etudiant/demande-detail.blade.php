@extends('layouts.dashboard')

@section('title', 'Détail Demande')
@section('page-title', 'Détail de la demande')

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




<div class="row justify-content-center">
    <div class="col-lg-8">

        {{-- Statut --}}
        <div class="card-uadb p-4 mb-4">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h5 style="color:var(--uadb-bleu);font-weight:700;">
                        {{ $demande->libelle_type }}
                    </h5>
                    <small style="color:var(--uadb-texte);">
                        Soumise le {{ $demande->date_soumission?->format('d/m/Y à H:i') }}
                    </small>
                </div>
                <span class="badge badge-{{ $demande->badge_statut }} px-3 py-2 rounded-pill fs-6">
                    {{ ucfirst(str_replace('_', ' ', $demande->statut)) }}
                </span>
            </div>

            {{-- Timeline --}}
            <div class="mt-4">
                <div class="d-flex gap-3 align-items-start mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:36px;height:36px;background:var(--uadb-vert);">
                        <i class="bi bi-check text-white"></i>
                    </div>
                    <div>
                        <div style="font-weight:600;font-size:0.88rem;">Demande soumise</div>
                        <small style="color:var(--uadb-texte);">
                            {{ $demande->date_soumission?->format('d/m/Y à H:i') }}
                        </small>
                    </div>
                </div>

                <div class="d-flex gap-3 align-items-start mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:36px;height:36px;background:{{ in_array($demande->statut, ['en_cours','validee','rejetee']) ? 'var(--uadb-bleu)' : '#dee2e6' }};">
                        <i class="bi bi-arrow-repeat text-white"></i>
                    </div>
                    <div>
                        <div style="font-weight:600;font-size:0.88rem;">En cours de traitement</div>
                        <small style="color:var(--uadb-texte);">
                            {{ in_array($demande->statut, ['en_cours','validee','rejetee']) ? 'Prise en charge par la scolarité' : 'En attente' }}
                        </small>
                    </div>
                </div>

                <div class="d-flex gap-3 align-items-start">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:36px;height:36px;background:{{ in_array($demande->statut, ['validee','rejetee']) ? ($demande->statut === 'validee' ? 'var(--uadb-vert)' : '#dc3545') : '#dee2e6' }};">
                        <i class="bi bi-{{ $demande->statut === 'validee' ? 'check-circle' : ($demande->statut === 'rejetee' ? 'x-circle' : 'hourglass') }} text-white"></i>
                    </div>
                    <div>
                        <div style="font-weight:600;font-size:0.88rem;">
                            {{ $demande->statut === 'validee' ? 'Demande validée' : ($demande->statut === 'rejetee' ? 'Demande rejetée' : 'Décision finale') }}
                        </div>
                        @if($demande->date_traitement)
                        <small style="color:var(--uadb-texte);">
                            {{ $demande->date_traitement?->format('d/m/Y à H:i') }}
                        </small>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Commentaire étudiant --}}
        @if($demande->commentaire_etudiant)
        <div class="card-uadb p-4 mb-4">
            <h6 style="color:var(--uadb-bleu);font-weight:700;">
                <i class="bi bi-chat-left-text me-2"></i>Votre commentaire
            </h6>
            <p style="font-size:0.88rem;margin:0;">{{ $demande->commentaire_etudiant }}</p>
        </div>
        @endif

        {{-- Motif rejet --}}
        @if($demande->statut === 'rejetee' && $demande->motif_rejet)
        <div class="alert alert-danger">
            <h6 class="fw-bold"><i class="bi bi-x-circle me-2"></i>Motif de rejet</h6>
            <p class="mb-0" style="font-size:0.88rem;">{{ $demande->motif_rejet }}</p>
        </div>
        @endif

        {{-- Réponse PATS --}}
        @if($demande->reponse)
        <div class="card-uadb p-4 mb-4">
            <h6 style="color:var(--uadb-bleu);font-weight:700;">
                <i class="bi bi-person-check me-2"></i>Réponse de la scolarité
            </h6>
            <p style="font-size:0.88rem;">{{ $demande->reponse->commentaire }}</p>
            <small style="color:var(--uadb-texte);">
                Par {{ $demande->reponse->pats->user->nom_complet ?? 'N/A' }} •
                {{ $demande->reponse->date_reponse?->format('d/m/Y') }}
            </small>
        </div>
        @endif

        {{-- Document généré --}}
        @if($demande->statut === 'validee' && $demande->fichier_genere)
        <div class="card-uadb p-4 mb-4"
             style="border:2px solid var(--uadb-vert);">
            <h6 style="color:var(--uadb-vert);font-weight:700;">
                <i class="bi bi-file-earmark-check me-2"></i>Document disponible
            </h6>
            <p style="font-size:0.85rem;color:var(--uadb-texte);">
                Votre document est prêt. Vous pouvez le télécharger maintenant.
            </p>
            <a href="{{ Storage::url($demande->fichier_genere) }}"
               download class="btn btn-vert">
                <i class="bi bi-download me-2"></i> Télécharger le document
            </a>
        </div>
        @endif

        <a href="{{ route('etudiant.demandes') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i> Retour à mes demandes
        </a>
    </div>
</div>

@endsection