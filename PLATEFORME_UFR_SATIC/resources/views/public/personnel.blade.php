@extends('layouts.public')

@section('title', 'Personnel – UFR SATIC')

@section('content')

<section class="py-5" style="background:var(--uadb-bleu);color:white;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('accueil') }}" style="color:rgba(255,255,255,0.7);">Accueil</a>
                </li>
                <li class="breadcrumb-item active" style="color:white;">Personnel</li>
            </ol>
        </nav>
        <h1 style="font-weight:800;">Notre Personnel</h1>
        <p style="opacity:0.85;">Nos enseignants-chercheurs et personnel administratif</p>
    </div>
</section>

<section class="py-5">
    <div class="container">

        {{-- Filtre par département --}}
        <div class="d-flex gap-2 flex-wrap mb-4">
            <button class="btn btn-uadb btn-sm active-filter" onclick="filtrer('tous')">
                Tous
            </button>
            @foreach($departements as $dep)
            <button class="btn btn-outline-primary btn-sm" onclick="filtrer('{{ $dep->slug }}')">
                {{ $dep->nom }}
            </button>
            @endforeach
        </div>

        <div class="row g-4" id="liste-personnel">
            @forelse($enseignants as $ens)
            <div class="col-md-6 col-lg-4 personnel-card"
                 data-dept="{{ $ens->departement?->slug }}">
                <div class="card-uadb p-4 text-center h-100">
                    <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center"
                         style="width:80px;height:80px;background:var(--uadb-bleu-light);">
                        @if($ens->user->photo)
                            <img src="{{ asset('storage/'.$ens->user->photo) }}"
                                 class="rounded-circle w-100 h-100 object-fit-cover" alt="">
                        @else
                            <i class="bi bi-person-fill fs-1" style="color:var(--uadb-bleu);"></i>
                        @endif
                    </div>
                    <h6 style="color:var(--uadb-bleu);font-weight:700;margin-bottom:0.2rem;">
                        {{ $ens->user->nom_complet }}
                    </h6>
                    <span class="badge mb-2"
                          style="background:var(--uadb-bleu-light);color:var(--uadb-bleu);font-size:0.75rem;">
                        {{ $ens->grade }}
                    </span>
                    @if($ens->specialite)
                    <p style="font-size:0.82rem;color:var(--uadb-texte);">
                        {{ $ens->specialite }}
                    </p>
                    @endif
                    @if($ens->departement)
                    <div style="font-size:0.78rem;color:var(--uadb-texte);">
                        <i class="bi bi-building me-1"></i>
                        {{ $ens->departement->nom }}
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-people" style="font-size:3rem;color:#ccc;"></i>
                <p class="text-muted mt-2">Aucun personnel disponible pour le moment.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function filtrer(dept) {
    document.querySelectorAll('.personnel-card').forEach(card => {
        if (dept === 'tous' || card.dataset.dept === dept) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>
@endpush