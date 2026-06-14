@extends('layouts.dashboard')

@section('title', 'Mon Profil')
@section('page-title', 'Mon Profil')

@section('sidebar-menu')
    <x-sidebar-enseignant />
@endsection

@section('content')

<div class="row g-4">

    {{-- Carte profil --}}
    <div class="col-lg-4">
        <div class="card-uadb p-4 text-center">
            <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center"
                 style="width:100px;height:100px;background:var(--uadb-bleu-light);">
                @if($user->photo)
                    <img src="{{ asset('storage/'.$user->photo) }}"
                         class="rounded-circle w-100 h-100 object-fit-cover" alt="">
                @else
                    <i class="bi bi-person-fill"
                       style="font-size:3rem;color:var(--uadb-bleu);"></i>
                @endif
            </div>
            <h5 style="color:var(--uadb-bleu);font-weight:700;">
                {{ $user->nom_complet }}
            </h5>
            <span class="badge mb-3"
                  style="background:var(--uadb-bleu-light);color:var(--uadb-bleu);">
                Enseignant
            </span>

            @if($enseignant)
            <div class="text-start mt-3">
                <div class="d-flex justify-content-between py-2 border-bottom"
                     style="font-size:0.85rem;">
                    <span style="color:var(--uadb-texte);">Grade</span>
                    <strong>{{ $enseignant->grade }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom"
                     style="font-size:0.85rem;">
                    <span style="color:var(--uadb-texte);">Département</span>
                    <strong>{{ $enseignant->departement->nom ?? 'N/A' }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2"
                     style="font-size:0.85rem;">
                    <span style="color:var(--uadb-texte);">Spécialité</span>
                    <strong>{{ $enseignant->specialite ?? 'N/A' }}</strong>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Formulaire --}}
    <div class="col-lg-8">
        <div class="card-uadb p-4">
            <h5 style="color:var(--uadb-bleu);font-weight:700;" class="mb-4">
                <i class="bi bi-pencil-square me-2"></i>
                Modifier mes informations
            </h5>

            <form method="POST"
                  action="{{ route('enseignant.profil.update') }}"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    {{-- Infos personnelles --}}
                    <div class="col-12">
                        <h6 style="color:var(--uadb-bleu);font-weight:700;">
                            Informations personnelles
                        </h6>
                        <hr>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom"
                               value="{{ old('nom', $user->nom) }}"
                               class="form-control @error('nom') is-invalid @enderror">
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Prénom</label>
                        <input type="text" name="prenom"
                               value="{{ old('prenom', $user->prenom) }}"
                               class="form-control @error('prenom') is-invalid @enderror">
                        @error('prenom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Photo de profil</label>
                        <input type="file" name="photo"
                               class="form-control"
                               accept="image/*">
                    </div>

                    {{-- Infos académiques --}}
                    <div class="col-12 mt-2">
                        <h6 style="color:var(--uadb-bleu);font-weight:700;">
                            Informations académiques
                        </h6>
                        <hr>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Grade</label>
                        <select name="grade" class="form-select">
                            @foreach(['Professeur','Maître de conférences','Assistant','Vacataire'] as $grade)
                            <option value="{{ $grade }}"
                                    {{ ($enseignant->grade ?? '') === $grade ? 'selected' : '' }}>
                                {{ $grade }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Spécialité</label>
                        <input type="text" name="specialite"
                               value="{{ old('specialite', $enseignant->specialite ?? '') }}"
                               class="form-control"
                               placeholder="Ex: Génie Logiciel">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Domaine de recherche</label>
                        <input type="text" name="domaine_recherche"
                               value="{{ old('domaine_recherche', $enseignant->domaine_recherche ?? '') }}"
                               class="form-control"
                               placeholder="Ex: Intelligence Artificielle, Big Data">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Biographie</label>
                        <textarea name="biographie"
                                  class="form-control"
                                  rows="4"
                                  placeholder="Présentez-vous en quelques lignes...">{{ old('biographie', $enseignant->biographie ?? '') }}</textarea>
                    </div>

                    {{-- Mot de passe --}}
                    <div class="col-12 mt-2">
                        <h6 style="color:var(--uadb-bleu);font-weight:700;">
                            Changer le mot de passe
                            <span style="font-weight:400;font-size:0.8rem;
                                         color:var(--uadb-texte);">
                                (optionnel)
                            </span>
                        </h6>
                        <hr>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nouveau mot de passe</label>
                        <input type="password" name="password"
                               class="form-control"
                               placeholder="••••••••">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Confirmer</label>
                        <input type="password"
                               name="password_confirmation"
                               class="form-control"
                               placeholder="••••••••">
                    </div>

                    <div class="col-12 mt-2">
                        <button type="submit" class="btn btn-uadb px-5">
                            <i class="bi bi-save me-2"></i>
                            Enregistrer les modifications
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection