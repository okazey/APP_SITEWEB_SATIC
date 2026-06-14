@extends('layouts.public')

@section('title', $departement->nom . ' – UFR SATIC')

@section('content')

{{-- Header --}}
<section class="py-5" style="background:var(--uadb-bleu);color:white;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('accueil') }}" style="color:rgba(255,255,255,0.7);">Accueil</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('departements') }}" style="color:rgba(255,255,255,0.7);">Départements</a>
                </li>
                <li class="breadcrumb-item active" style="color:white;">
                    {{ $departement->nom }}
                </li>
            </ol>
        </nav>
        <h1 style="font-weight:800;">{{ $departement->nom }}</h1>
        <p style="opacity:0.85;">{{ $departement->description }}</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-5">

            {{-- Contenu principal --}}
            <div class="col-lg-8">

                {{-- Formations --}}
                <h4 style="color:var(--uadb-bleu);font-weight:700;">
                    <i class="bi bi-book me-2"></i>Formations proposées
                </h4>
                <div class="section-divider" style="margin:0.8rem 0 1.5rem;"></div>

                @forelse($departement->formations as $formation)
                <div class="card-uadb p-4 mb-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 style="color:var(--uadb-bleu);font-weight:700;">
                                {{ $formation->nom }}
                            </h5>
                            <span class="badge mb-2"
                                  style="background:var(--uadb-bleu-light);color:var(--uadb-bleu);">
                                {{ $formation->niveau }}
                            </span>
                            @if($formation->description)
                            <p style="font-size:0.88rem;color:var(--uadb-texte);margin-top:0.5rem;">
                                {{ $formation->description }}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <i class="bi bi-book" style="font-size:2.5rem;color:#ccc;"></i>
                    <p class="text-muted mt-2">Aucune formation disponible.</p>
                </div>
                @endforelse

                {{-- Enseignants --}}
                @if($departement->enseignants->count() > 0)
                <h4 class="mt-5" style="color:var(--uadb-bleu);font-weight:700;">
                    <i class="bi bi-people me-2"></i>Enseignants du département
                </h4>
                <div class="section-divider" style="margin:0.8rem 0 1.5rem;"></div>

                <div class="row g-3">
                    @foreach($departement->enseignants as $ens)
                    <div class="col-md-6">
                        <div class="d-flex gap-3 align-items-center p-3 rounded-3"
                             style="background:var(--uadb-bleu-light);">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                 style="width:50px;height:50px;background:var(--uadb-bleu);">
                                @if($ens->user->photo)
                                    <img src="{{ asset('storage/'.$ens->user->photo) }}"
                                         class="rounded-circle w-100 h-100 object-fit-cover" alt="">
                                @else
                                    <i class="bi bi-person-fill text-white fs-5"></i>
                                @endif
                            </div>
                            <div>
                                <div style="font-weight:700;color:var(--uadb-bleu);font-size:0.88rem;">
                                    {{ $ens->user->nom_complet }}
                                </div>
                                <div style="font-size:0.78rem;color:var(--uadb-texte);">
                                    {{ $ens->grade }}
                                </div>
                                @if($ens->specialite)
                                <div style="font-size:0.75rem;color:var(--uadb-texte);opacity:0.8;">
                                    {{ $ens->specialite }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                <div class="card-uadb p-4 mb-4">
                    <h5 style="color:var(--uadb-bleu);font-weight:700;">
                        <i class="bi bi-info-circle me-2"></i>En chiffres
                    </h5>
                    <hr>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span style="font-size:0.88rem;">Formations</span>
                        <strong style="color:var(--uadb-bleu);">
                            {{ $departement->formations->count() }}
                        </strong>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span style="font-size:0.88rem;">Enseignants</span>
                        <strong style="color:var(--uadb-bleu);">
                            {{ $departement->enseignants->count() }}
                        </strong>
                    </div>
                </div>

                <div class="card-uadb p-4">
                    <h5 style="color:var(--uadb-bleu);font-weight:700;">
                        <i class="bi bi-grid me-2"></i>Autres départements
                    </h5>
                    <hr>
                    @foreach(\App\Models\Departement::where('id', '!=', $departement->id)->get() as $dep)
                    <a href="{{ route('departements.show', $dep->slug) }}"
                       class="d-block py-2 border-bottom"
                       style="font-size:0.88rem;color:var(--uadb-bleu);">
                        <i class="bi bi-chevron-right me-1"></i> {{ $dep->nom }}
                    </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</section>

@endsection