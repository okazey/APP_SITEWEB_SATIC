@extends('layouts.dashboard')

@section('title', 'Modifier le cours')
@section('page-title', 'Modifier le cours')

@section('sidebar-menu')
    <x-sidebar-enseignant />
@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-uadb p-4 p-md-5">
            <h5 style="color:var(--uadb-bleu);font-weight:700;" class="mb-4">
                <i class="bi bi-pencil-square me-2"></i>
                Modifier le cours
            </h5>

            <form method="POST"
                  action="{{ route('enseignant.cours.update', $cours->id) }}"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Titre du cours *</label>
                        <input type="text"
                               name="titre"
                               value="{{ old('titre', $cours->titre) }}"
                               class="form-control @error('titre') is-invalid @enderror">
                        @error('titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Formation *</label>
                        <select name="formation_id"
                                class="form-select @error('formation_id') is-invalid @enderror">
                            @foreach($formations as $formation)
                            <option value="{{ $formation->id }}"
                                    {{ $cours->formation_id == $formation->id ? 'selected' : '' }}>
                                {{ $formation->nom }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Niveau</label>
                        <select name="niveau" class="form-select">
                            <option value="">-- Niveau --</option>
                            @foreach(['L1','L2','L3','M1','M2'] as $n)
                            <option value="{{ $n }}"
                                    {{ $cours->niveau === $n ? 'selected' : '' }}>
                                {{ $n }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Semestre</label>
                        <select name="semestre" class="form-select">
                            <option value="">-- Semestre --</option>
                            @foreach(['S1','S2','S3','S4','S5','S6'] as $s)
                            <option value="{{ $s }}"
                                    {{ $cours->semestre === $s ? 'selected' : '' }}>
                                {{ $s }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description"
                                  class="form-control"
                                  rows="4">{{ old('description', $cours->description) }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Remplacer le fichier</label>
                        @if($cours->fichier)
                        <div class="alert alert-info mb-2" style="font-size:0.85rem;">
                            <i class="bi bi-file-earmark-pdf me-2"></i>
                            Fichier actuel :
                            <strong>{{ basename($cours->fichier) }}</strong>
                        </div>
                        @endif
                        <input type="file"
                               name="fichier"
                               accept=".pdf,.doc,.docx,.ppt,.pptx"
                               class="form-control @error('fichier') is-invalid @enderror">
                        <small class="text-muted">
                            Laissez vide pour conserver le fichier actuel.
                        </small>
                        @error('fichier')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 d-flex gap-3 mt-2">
                        <button type="submit" class="btn btn-uadb px-5">
                            <i class="bi bi-save me-2"></i> Enregistrer
                        </button>
                        <a href="{{ route('enseignant.cours') }}"
                           class="btn btn-outline-secondary px-4">
                            Annuler
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection