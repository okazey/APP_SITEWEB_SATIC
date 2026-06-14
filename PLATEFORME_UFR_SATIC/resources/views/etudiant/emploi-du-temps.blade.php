@extends('layouts.dashboard')

@section('title', 'Emploi du temps')
@section('page-title', 'Emploi du temps')

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
    <a href="{{ route('etudiant.emploi-du-temps') }}" class="nav-link active">
        <i class="bi bi-calendar3"></i> Emploi du temps
    </a>
    <div class="sidebar-section-title">Administratif</div>
    <a href="{{ route('etudiant.demandes') }}" class="nav-link">
        <i class="bi bi-file-earmark-text"></i> Mes demandes
    </a>
    <a href="{{ route('etudiant.notifications') }}" class="nav-link">
        <i class="bi bi-bell"></i> Notifications
    </a>
    <div class="sidebar-section-title">Mon compte</div>
    <a href="{{ route('etudiant.profil') }}" class="nav-link">
        <i class="bi bi-person-circle"></i> Mon profil
    </a>


@forelse($emplois as $emploi)
<div class="card-uadb p-4 mb-3">
    <div class="row align-items-center">
        <div class="col-md-8">
            <div class="d-flex gap-3 align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:50px;height:50px;background:var(--uadb-bleu-light);">
                    <i class="bi bi-calendar-week" style="color:var(--uadb-bleu);font-size:1.3rem;"></i>
                </div>
                <div>
                    <h6 style="color:var(--uadb-bleu);font-weight:700;margin:0;">
                        {{ $emploi->semestre }} – {{ $emploi->niveau }}
                    </h6>
                    <small style="color:var(--uadb-texte);">
                        Année {{ $emploi->annee_academique }} •
                        Publié le {{ $emploi->date_publication?->format('d/m/Y') }}
                    </small>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            @if($emploi->fichier_pdf)
            <a href="{{ Storage::url($emploi->fichier_pdf) }}"
               target="_blank"
               class="btn btn-uadb">
                <i class="bi bi-eye me-2"></i> Voir le PDF
            </a>
            <a href="{{ Storage::url($emploi->fichier_pdf) }}"
               download
               class="btn btn-outline-primary ms-2">
                <i class="bi bi-download me-1"></i>
            </a>
            @else
            <span class="badge bg-secondary px-3 py-2">
                Fichier non disponible
            </span>
            @endif
        </div>
    </div>
</div>
@empty
<div class="card-uadb p-5 text-center">
    <i class="bi bi-calendar-x" style="font-size:4rem;color:#ccc;"></i>
    <h5 class="mt-3 text-muted">Aucun emploi du temps disponible.</h5>
    <p style="font-size:0.88rem;color:var(--uadb-texte);">
        Les emplois du temps seront publiés par l'administration.
    </p>
</div>
@endforelse

@endsection