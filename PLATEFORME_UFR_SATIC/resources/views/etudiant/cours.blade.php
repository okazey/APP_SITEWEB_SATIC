@extends('layouts.dashboard')

@section('title', 'Mes Cours')
@section('page-title', 'Mes Cours')

@section('sidebar-menu')
    <x-sidebar-etudiant />
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 style="color:var(--uadb-bleu);font-weight:700;margin:0;">
            Cours de ma formation
        </h5>
        @if($etudiant)
        <small style="color:var(--uadb-texte);">
            {{ $etudiant->formation->nom ?? '' }} – {{ $etudiant->niveau }}
        </small>
        @endif
    </div>
</div>

@if($cours->count() > 0)
<div class="row g-4">
    @foreach($cours as $c)
    <div class="col-md-6 col-lg-4">
        <div class="card-uadb h-100 p-4">
            <div class="d-flex gap-3 align-items-start mb-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:48px;height:48px;background:var(--uadb-bleu-light);">
                    <i class="bi bi-file-earmark-pdf"
                       style="color:var(--uadb-bleu);font-size:1.2rem;"></i>
                </div>
                <div>
                    <h6 style="color:var(--uadb-bleu);font-weight:700;
                               margin-bottom:0.2rem;font-size:0.92rem;">
                        {{ $c->titre }}
                    </h6>
                    <small style="color:var(--uadb-texte);">
                        {{ $c->enseignant->user->nom_complet ?? 'N/A' }}
                    </small>
                </div>
            </div>

            @if($c->description)
            <p style="font-size:0.82rem;color:var(--uadb-texte);">
                {{ Str::limit($c->description, 80) }}
            </p>
            @endif

            <div class="d-flex gap-2 flex-wrap mb-3">
                @if($c->semestre)
                <span class="badge"
                      style="background:var(--uadb-bleu-light);
                             color:var(--uadb-bleu);font-size:0.75rem;">
                    {{ $c->semestre }}
                </span>
                @endif
                @if($c->niveau)
                <span class="badge"
                      style="background:var(--uadb-bleu-light);
                             color:var(--uadb-bleu);font-size:0.75rem;">
                    {{ $c->niveau }}
                </span>
                @endif
            </div>

            <div class="d-flex justify-content-between align-items-center mt-auto">
                <small style="color:var(--uadb-texte);font-size:0.75rem;">
                    <i class="bi bi-calendar3 me-1"></i>
                    {{ $c->date_publication?->format('d/m/Y') }}
                </small>
                @if($c->fichier)
                <a href="{{ route('etudiant.cours.telecharger', $c->id) }}"
                   class="btn btn-uadb btn-sm">
                    <i class="bi bi-download me-1"></i> Télécharger
                </a>
                @else
                <span class="badge bg-secondary" style="font-size:0.75rem;">
                    Pas de fichier
                </span>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $cours->links('pagination::bootstrap-5') }}
</div>

@else
<div class="card-uadb p-5 text-center">
    <i class="bi bi-book" style="font-size:4rem;color:#ccc;"></i>
    <h5 class="mt-3 text-muted">Aucun cours disponible pour le moment.</h5>
    <p style="font-size:0.88rem;color:var(--uadb-texte);">
        Les cours seront disponibles dès que vos enseignants les auront publiés.
    </p>
</div>
@endif

@endsection