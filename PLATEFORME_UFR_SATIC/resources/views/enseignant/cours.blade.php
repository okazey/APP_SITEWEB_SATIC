@extends('layouts.dashboard')

@section('title', 'Mes Cours')
@section('page-title', 'Gestion des cours')

@section('sidebar-menu')
    <x-sidebar-enseignant />
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 style="color:var(--uadb-bleu);font-weight:700;margin:0;">
        Tous mes cours
    </h5>
    <a href="{{ route('enseignant.cours.create') }}" class="btn btn-uadb">
        <i class="bi bi-plus-circle me-2"></i> Déposer un cours
    </a>
</div>

{{-- Filtres statut --}}
<div class="d-flex gap-2 mb-4 flex-wrap">
    <a href="{{ route('enseignant.cours') }}"
       class="btn btn-sm {{ !request('statut') ? 'btn-uadb' : 'btn-outline-primary' }}">
        Tous
    </a>
    @foreach(['brouillon'=>'Brouillons','publie'=>'Publiés','archive'=>'Archivés'] as $val=>$label)
    <a href="{{ route('enseignant.cours', ['statut'=>$val]) }}"
       class="btn btn-sm {{ request('statut')===$val ? 'btn-uadb' : 'btn-outline-primary' }}">
        {{ $label }}
    </a>
    @endforeach
</div>

@if($cours->count() > 0)
<div class="row g-4">
    @foreach($cours as $c)
    <div class="col-md-6 col-lg-4">
        <div class="card-uadb h-100 p-4">
            {{-- Statut badge --}}
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                     style="width:45px;height:45px;background:var(--uadb-bleu-light);">
                    <i class="bi bi-file-earmark-pdf"
                       style="color:var(--uadb-bleu);font-size:1.2rem;"></i>
                </div>
                <span class="badge badge-{{ match($c->statut) {
                    'publie'    => 'publie',
                    'brouillon' => 'brouillon',
                    default     => 'brouillon'
                } }} px-3 py-2 rounded-pill">
                    {{ ucfirst($c->statut) }}
                </span>
            </div>

            <h6 style="color:var(--uadb-bleu);font-weight:700;font-size:0.92rem;">
                {{ $c->titre }}
            </h6>

            @if($c->description)
            <p style="font-size:0.82rem;color:var(--uadb-texte);">
                {{ Str::limit($c->description, 80) }}
            </p>
            @endif

            <div class="d-flex gap-2 flex-wrap mb-3">
                @if($c->formation)
                <span class="badge"
                      style="background:var(--uadb-bleu-light);color:var(--uadb-bleu);font-size:0.75rem;">
                    {{ $c->formation->nom }}
                </span>
                @endif
                @if($c->semestre)
                <span class="badge bg-light text-dark" style="font-size:0.75rem;">
                    {{ $c->semestre }}
                </span>
                @endif
            </div>

            <div class="mt-auto">
                <small style="color:var(--uadb-texte);font-size:0.75rem;">
                    <i class="bi bi-calendar3 me-1"></i>
                    {{ $c->created_at->format('d/m/Y') }}
                </small>

                {{-- Actions --}}
                <div class="d-flex gap-2 mt-3 flex-wrap">
                    <a href="{{ route('enseignant.cours.edit', $c->id) }}"
                       class="btn btn-sm btn-outline-primary flex-fill">
                        <i class="bi bi-pencil me-1"></i> Modifier
                    </a>

                    @if($c->statut === 'brouillon')
                    <form method="POST"
                          action="{{ route('enseignant.cours.publier', $c->id) }}"
                          class="flex-fill">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-vert w-100">
                            <i class="bi bi-send me-1"></i> Publier
                        </button>
                    </form>

                    @elseif($c->statut === 'publie')
                    <form method="POST"
                          action="{{ route('enseignant.cours.archiver', $c->id) }}"
                          class="flex-fill">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-secondary w-100">
                            <i class="bi bi-archive me-1"></i> Archiver
                        </button>
                    </form>
                    @endif
                </div>

                <form method="POST"
                      action="{{ route('enseignant.cours.destroy', $c->id) }}"
                      class="mt-2"
                      onsubmit="return confirm('Supprimer ce cours ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="btn btn-sm btn-outline-danger w-100">
                        <i class="bi bi-trash me-1"></i> Supprimer
                    </button>
                </form>
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
    <h5 class="mt-3 text-muted">Aucun cours pour le moment.</h5>
    <a href="{{ route('enseignant.cours.create') }}"
       class="btn btn-uadb mt-3">
        <i class="bi bi-plus-circle me-2"></i> Déposer mon premier cours
    </a>
</div>
@endif

@endsection