@extends('layouts.dashboard')

@section('title', 'Nouvelle Demande')
@section('page-title', 'Nouvelle Demande Administrative')

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
    <div class="col-lg-7">
        <div class="card-uadb p-4 p-md-5">
            <h5 style="color:var(--uadb-bleu);font-weight:700;" class="mb-4">
                <i class="bi bi-file-earmark-plus me-2"></i>
                Soumettre une demande administrative
            </h5>

            <form method="POST" action="{{ route('etudiant.demandes.store') }}">
                @csrf

                {{-- Type de demande --}}
                <div class="mb-4">
                    <label class="form-label">Type de document souhaité *</label>
                    <div class="row g-3">
                        @foreach([
                            ['val'=>'attestation_inscription','label'=>'Attestation d\'inscription','icon'=>'bi-file-earmark-check'],
                            ['val'=>'releve_notes','label'=>'Relevé de notes','icon'=>'bi-file-earmark-bar-graph'],
                            ['val'=>'certificat_scolarite','label'=>'Certificat de scolarité','icon'=>'bi-file-earmark-text'],
                            ['val'=>'autre','label'=>'Autre document','icon'=>'bi-file-earmark'],
                        ] as $type)
                        <div class="col-6">
                            <input type="radio" class="btn-check"
                                   name="type_demande"
                                   id="type_{{ $type['val'] }}"
                                   value="{{ $type['val'] }}"
                                   {{ old('type_demande') === $type['val'] ? 'checked' : '' }}>
                            <label class="btn btn-outline-primary w-100 p-3 text-start"
                                   for="type_{{ $type['val'] }}">
                                <i class="bi {{ $type['icon'] }} d-block fs-4 mb-1"></i>
                                <span style="font-size:0.82rem;">{{ $type['label'] }}</span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @error('type_demande')
                        <div class="text-danger mt-2" style="font-size:0.85rem;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Commentaire --}}
                <div class="mb-4">
                    <label class="form-label">
                        Commentaire / Précisions
                        <span style="font-weight:400;color:var(--uadb-texte);">(optionnel)</span>
                    </label>
                    <textarea name="commentaire_etudiant"
                              class="form-control"
                              rows="4"
                              placeholder="Précisez votre demande si nécessaire...">{{ old('commentaire_etudiant') }}</textarea>
                </div>

                {{-- Info --}}
                <div class="alert alert-info mb-4" style="font-size:0.85rem;">
                    <i class="bi bi-info-circle me-2"></i>
                    Votre demande sera traitée dans un délai de <strong>48h ouvrables</strong>.
                    Vous recevrez une notification dès qu'elle sera traitée.
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-uadb px-5">
                        <i class="bi bi-send me-2"></i> Soumettre la demande
                    </button>
                    <a href="{{ route('etudiant.demandes') }}" class="btn btn-outline-secondary px-4">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection