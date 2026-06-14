@extends('layouts.dashboard')

@section('title', 'Détail Demande')
@section('page-title', 'Traitement de la demande')

@section('sidebar-menu')
    <x-sidebar-pats />
@endsection

@section('content')

<div class="row g-4">

    {{-- Infos demande --}}
    <div class="col-lg-8">

        {{-- Carte demande --}}
        <div class="card-uadb p-4 mb-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h5 style="color:var(--uadb-bleu);font-weight:700;">
                    {{ $demande->libelle_type }}
                </h5>
                <span class="badge badge-{{ $demande->badge_statut }} px-3 py-2 rounded-pill fs-6">
                    {{ ucfirst(str_replace('_', ' ', $demande->statut)) }}
                </span>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <div style="font-size:0.82rem;color:var(--uadb-texte);">
                        Date de soumission
                    </div>
                    <div style="font-weight:600;font-size:0.9rem;">
                        {{ $demande->date_soumission?->format('d/m/Y à H:i') }}
                    </div>
                </div>
                @if($demande->date_traitement)
                <div class="col-md-6">
                    <div style="font-size:0.82rem;color:var(--uadb-texte);">
                        Date de traitement
                    </div>
                    <div style="font-weight:600;font-size:0.9rem;">
                        {{ $demande->date_traitement?->format('d/m/Y à H:i') }}
                    </div>
                </div>
                @endif
            </div>

            @if($demande->commentaire_etudiant)
            <div class="mt-3 p-3 rounded-3"
                 style="background:var(--uadb-bleu-light);">
                <div style="font-size:0.82rem;color:var(--uadb-texte);font-weight:600;">
                    Commentaire de l'étudiant :
                </div>
                <div style="font-size:0.88rem;margin-top:0.3rem;">
                    {{ $demande->commentaire_etudiant }}
                </div>
            </div>
            @endif

            @if($demande->motif_rejet)
            <div class="alert alert-danger mt-3">
                <strong>Motif de rejet :</strong> {{ $demande->motif_rejet }}
            </div>
            @endif
        </div>

        {{-- Actions --}}
        @if(in_array($demande->statut, ['en_attente', 'en_cours']))
        <div class="card-uadb p-4 mb-4">
            <h5 style="color:var(--uadb-bleu);font-weight:700;" class="mb-4">
                <i class="bi bi-gear me-2"></i>Traitement de la demande
            </h5>

            {{-- Prendre en charge --}}
            @if($demande->statut === 'en_attente')
            <div class="mb-4 p-3 rounded-3"
                 style="background:var(--uadb-bleu-light);">
                <h6 style="color:var(--uadb-bleu);font-weight:700;">
                    Étape 1 — Prendre en charge
                </h6>
                <p style="font-size:0.85rem;color:var(--uadb-texte);">
                    Cliquez pour indiquer que vous traitez cette demande.
                </p>
                <form method="POST"
                      action="{{ route('pats.demandes.traiter', $demande->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-repeat me-2"></i>
                        Prendre en charge
                    </button>
                </form>
            </div>
            @endif

            {{-- Valider --}}
            <div class="mb-4 p-3 rounded-3"
                 style="background:#f0fff4;">
                <h6 style="color:var(--uadb-vert);font-weight:700;">
                    ✅ Valider la demande
                </h6>
                <form method="POST"
                      action="{{ route('pats.demandes.valider', $demande->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" style="font-size:0.85rem;">
                            Commentaire (optionnel)
                        </label>
                        <textarea name="commentaire"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Message pour l'étudiant..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-vert">
                        <i class="bi bi-check-circle me-2"></i>
                        Valider et générer le document
                    </button>
                </form>
            </div>

            {{-- Rejeter --}}
            <div class="p-3 rounded-3" style="background:#fff5f5;">
                <h6 style="color:#dc3545;font-weight:700;">
                    ❌ Rejeter la demande
                </h6>
                <form method="POST"
                      action="{{ route('pats.demandes.rejeter', $demande->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label"
                               style="font-size:0.85rem;">
                            Motif de rejet *
                        </label>
                        <textarea name="motif_rejet"
                                  class="form-control @error('motif_rejet') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Expliquez pourquoi la demande est rejetée..."></textarea>
                        @error('motif_rejet')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit"
                            class="btn btn-danger"
                            onclick="return confirm('Confirmer le rejet ?')">
                        <i class="bi bi-x-circle me-2"></i>
                        Rejeter la demande
                    </button>
                </form>
            </div>
        </div>
        @endif

        {{-- Générer PDF si validée --}}
        @if($demande->statut === 'validee')
        <div class="card-uadb p-4 mb-4"
             style="border:2px solid var(--uadb-vert);">
            <h5 style="color:var(--uadb-vert);font-weight:700;">
                <i class="bi bi-file-earmark-pdf me-2"></i>
                Document officiel
            </h5>
            <p style="font-size:0.88rem;color:var(--uadb-texte);">
                Générez et téléchargez le document officiel pour cet étudiant.
            </p>
            <a href="{{ route('pats.demandes.pdf', $demande->id) }}"
               class="btn btn-vert">
                <i class="bi bi-download me-2"></i>
                Générer et télécharger le PDF
            </a>
        </div>
        @endif

        {{-- Réponse existante --}}
        @if($demande->reponse)
        <div class="card-uadb p-4">
            <h6 style="color:var(--uadb-bleu);font-weight:700;">
                <i class="bi bi-chat-left-text me-2"></i>
                Réponse enregistrée
            </h6>
            <p style="font-size:0.88rem;">{{ $demande->reponse->commentaire }}</p>
            <small style="color:var(--uadb-texte);">
                Par {{ $demande->reponse->pats->user->nom_complet ?? 'N/A' }} •
                {{ $demande->reponse->date_reponse?->format('d/m/Y') }}
            </small>
        </div>
        @endif
    </div>

    {{-- Infos étudiant --}}
    <div class="col-lg-4">
        <div class="card-uadb p-4 mb-4">
            <h5 style="color:var(--uadb-bleu);font-weight:700;" class="mb-3">
                <i class="bi bi-person me-2"></i>Informations étudiant
            </h5>
            @if($demande->etudiant)
            <div class="text-center mb-3">
                <div class="mx-auto rounded-circle d-flex align-items-center justify-content-center"
                     style="width:70px;height:70px;background:var(--uadb-bleu-light);">
                    <i class="bi bi-person-fill fs-2"
                       style="color:var(--uadb-bleu);"></i>
                </div>
                <h6 class="mt-2" style="color:var(--uadb-bleu);font-weight:700;">
                    {{ $demande->etudiant->user->nom_complet ?? 'N/A' }}
                </h6>
            </div>
            <div style="font-size:0.85rem;">
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span style="color:var(--uadb-texte);">Matricule</span>
                    <strong>{{ $demande->etudiant->matricule }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span style="color:var(--uadb-texte);">Niveau</span>
                    <strong>{{ $demande->etudiant->niveau }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span style="color:var(--uadb-texte);">Formation</span>
                    <strong style="font-size:0.8rem;">
                        {{ $demande->etudiant->formation->nom ?? 'N/A' }}
                    </strong>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <span style="color:var(--uadb-texte);">Email</span>
                    <strong style="font-size:0.8rem;">
                        {{ $demande->etudiant->user->email ?? 'N/A' }}
                    </strong>
                </div>
            </div>
            @endif
        </div>

        <a href="{{ route('pats.demandes') }}"
           class="btn btn-outline-secondary w-100">
            <i class="bi bi-arrow-left me-2"></i>
            Retour à la liste
        </a>
    </div>
</div>

@endsection