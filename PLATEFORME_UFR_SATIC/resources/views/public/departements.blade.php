@extends('layouts.public')

@section('title', 'Départements – UFR SATIC')

@section('content')

<section class="py-5" style="background:var(--uadb-bleu);color:white;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('accueil') }}" style="color:rgba(255,255,255,0.7);">Accueil</a>
                </li>
                <li class="breadcrumb-item active" style="color:white;">Départements</li>
            </ol>
        </nav>
        <h1 style="font-weight:800;">Nos Départements</h1>
        <p style="opacity:0.85;">Découvrez nos domaines d'enseignement et de recherche</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            @foreach($departements as $dep)
            <div class="col-md-6">
                <div class="card-uadb p-4 h-100">
                    <div class="d-flex gap-3 align-items-start mb-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                             style="width:55px;height:55px;background:var(--uadb-bleu);">
                            <i class="bi bi-building-fill text-white fs-4"></i>
                        </div>
                        <div>
                            <h5 style="color:var(--uadb-bleu);font-weight:700;margin-bottom:0.3rem;">
                                {{ $dep->nom }}
                            </h5>
                            <p style="font-size:0.85rem;color:var(--uadb-texte);margin:0;">
                                {{ $dep->description }}
                            </p>
                        </div>
                    </div>

                    @if($dep->formations->count() > 0)
                    <div class="mt-3">
                        <h6 style="color:var(--uadb-bleu);font-weight:700;font-size:0.88rem;">
                            <i class="bi bi-book me-1"></i> Formations :
                        </h6>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            @foreach($dep->formations as $formation)
                            <span class="badge px-3 py-2"
                                  style="background:var(--uadb-bleu-light);color:var(--uadb-bleu);font-size:0.8rem;">
                                {{ $formation->nom }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <a href="{{ route('departements.show', $dep->slug) }}"
                       class="btn btn-uadb btn-sm mt-4">
                        <i class="bi bi-arrow-right me-1"></i> Voir le département
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection