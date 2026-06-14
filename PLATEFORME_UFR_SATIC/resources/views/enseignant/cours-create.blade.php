@extends('layouts.dashboard')

@section('title', 'Déposer un cours')
@section('page-title', 'Déposer un cours')

@section('sidebar-menu')
    <x-sidebar-enseignant />
@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-uadb p-4 p-md-5">
            <h5 style="color:var(--uadb-bleu);font-weight:700;" class="mb-4">
                <i class="bi bi-cloud-upload me-2"></i>
                Déposer un nouveau cours
            </h5>

            <form method="POST"
                  action="{{ route('enseignant.cours.store') }}"
                  enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    {{-- Titre --}}
                    <div class="col-12">
                        <label class="form-label">Titre du cours *</label>
                        <input type="text"
                               name="titre"
                               value="{{ old('titre') }}"
                               class="form-control @error('titre') is-invalid @enderror"
                               placeholder="Ex: Introduction à la programmation Python">
                        @error('titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Formation --}}
                    <div class="col-md-6">
                        <label class="form-label">Formation *</label>
                        <select name="formation_id"
                                class="form-select @error('formation_id') is-invalid @enderror">
                            <option value="">-- Choisir une formation --</option>
                            @foreach($formations as $formation)
                            <option value="{{ $formation->id }}"
                                    {{ old('formation_id') == $formation->id ? 'selected' : '' }}>
                                {{ $formation->nom }}
                            </option>
                            @endforeach
                        </select>
                        @error('formation_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Niveau --}}
                    <div class="col-md-3">
                        <label class="form-label">Niveau</label>
                        <select name="niveau" class="form-select">
                            <option value="">-- Niveau --</option>
                            @foreach(['L1','L2','L3','M1','M2'] as $n)
                            <option value="{{ $n }}"
                                    {{ old('niveau') === $n ? 'selected' : '' }}>
                                {{ $n }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Semestre --}}
                    <div class="col-md-3">
                        <label class="form-label">Semestre</label>
                        <select name="semestre" class="form-select">
                            <option value="">-- Semestre --</option>
                            @foreach(['S1','S2','S3','S4','S5','S6'] as $s)
                            <option value="{{ $s }}"
                                    {{ old('semestre') === $s ? 'selected' : '' }}>
                                {{ $s }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Description --}}
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description"
                                  class="form-control"
                                  rows="4"
                                  placeholder="Décrivez le contenu de ce cours...">{{ old('description') }}</textarea>
                    </div>

                    {{-- Fichier --}}
                    <div class="col-12">
                        <label class="form-label">Fichier du cours</label>
                        <div class="border rounded-3 p-4 text-center"
                             style="border-style:dashed!important;background:var(--uadb-gris);cursor:pointer;"
                             onclick="document.getElementById('fichier').click()">
                            <i class="bi bi-cloud-upload fs-2"
                               style="color:var(--uadb-bleu);"></i>
                            <p class="mt-2 mb-1" style="font-weight:600;color:var(--uadb-bleu);">
                                Cliquez pour uploader
                            </p>
                            <small style="color:var(--uadb-texte);">
                                PDF, Word, PowerPoint – Max 20 Mo
                            </small>
                            <div id="filename" class="mt-2"
                                 style="font-size:0.85rem;color:var(--uadb-vert);display:none;">
                            </div>
                        </div>
                        <input type="file"
                               id="fichier"
                               name="fichier"
                               accept=".pdf,.doc,.docx,.ppt,.pptx"
                               class="d-none @error('fichier') is-invalid @enderror"
                               onchange="showFilename(this)">
                        @error('fichier')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Info --}}
                    <div class="col-12">
                        <div class="alert alert-info" style="font-size:0.85rem;">
                            <i class="bi bi-info-circle me-2"></i>
                            Le cours sera sauvegardé en <strong>brouillon</strong>.
                            Vous pourrez le publier quand il sera prêt.
                        </div>
                    </div>

                    {{-- Boutons --}}
                    <div class="col-12 d-flex gap-3">
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

@push('scripts')
<script>
function showFilename(input) {
    const div = document.getElementById('filename');
    if (input.files && input.files[0]) {
        div.textContent = '✅ ' + input.files[0].name;
        div.style.display = 'block';
    }
}
</script>
@endpush