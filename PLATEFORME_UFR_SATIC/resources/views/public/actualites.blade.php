@extends('layouts.public')

@section('title', 'Actualités – UFR SATIC')

@section('content')

<section class="py-5" style="background:var(--uadb-bleu);color:white;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('accueil') }}" style="color:rgba(255,255,255,0.7);">Accueil</a>
                </li>
                <li class="breadcrumb-item active" style="color:white;">Actualités</li>
            </ol>
        </nav>
        <h1 style="font-weight:800;">Actualités</h1>
        <p style="opacity:0.85;">Les dernières nouvelles de l'UFR SATIC</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if($actualites->count() > 0)
        <div class="row g-4">
            @foreach($actualites as $actu)
            <div class="col-md-6 col-lg-4">
                <div class="card-uadb h-100">
                    <div style="height:200px;background:var(--uadb-bleu-light);
                                border-radius:12px 12px 0 0;overflow:hidden;">
                        @if($actu->image)
                            <img src="{{ asset('storage/'.$actu->image) }}"
                                 class="w-100 h-100 object-fit-cover" alt="">
                        @else
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                <i class="bi bi-newspaper"
                                   style="font-size:3rem;color:var(--uadb-bleu);opacity:0.3;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <span class="badge mb-2"
                              style="background:var(--uadb-bleu-light);color:var(--uadb-bleu);">
                            {{ $actu->categorie ?? 'Actualité' }}
                        </span>
                        <h6 style="color:var(--uadb-bleu);font-weight:700;line-height:1.4;">
                            {{ $actu->titre }}
                        </h6>
                        <p style="font-size:0.83rem;color:var(--uadb-texte);">
                            {{ Str::limit(strip_tags($actu->contenu), 120) }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <small style="color:var(--uadb-texte);font-size:0.78rem;">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $actu->date_publication?->format('d/m/Y') }}
                            </small>
                            <a href="{{ route('actualites.show', $actu->slug) }}"
                               class="btn btn-uadb btn-sm">
                                Lire <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-5">
            {{ $actualites->links('pagination::bootstrap-5') }}
        </div>

        @else
        <div class="text-center py-5">
            <i class="bi bi-newspaper" style="font-size:4rem;color:#ccc;"></i>
            <h5 class="mt-3 text-muted">Aucune actualité disponible pour le moment.</h5>
        </div>
        @endif
    </div>
</section>

@endsection