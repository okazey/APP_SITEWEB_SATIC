@extends('layouts.dashboard')

@section('title', 'Mon Profil')
@section('page-title', 'Mon Profil')

@section('sidebar-menu')
    <x-sidebar-pats />
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
                Personnel Administratif
            </span>
            @if($pats)
            <div class="text-start mt-3">
                <div class="d-flex justify-content-between py-2 border-bottom"
                     style="font-size:0.85rem;">
                    <span style="color:var(--uadb-texte);">Fonction</span>
                    <strong>{{ $pats->fonction }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2"
                     style="font-size:0.85rem;">
                    <span style="color:var(--uadb-texte);">Service</span>
                    <strong>{{ $pats->service }}</strong>
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
                  action="{{ route('pats.profil.update') }}"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
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
                               class="form-control" accept="image/*">
                    </div>

                    <div class="col-12 mt-2">
                        <h6 style="color:var(--uadb-bleu);font-weight:700;">
                            Informations professionnelles
                        </h6>
                        <hr>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Fonction</label>
                        <input type="text" name="fonction"
                               value="{{ old('fonction', $pats->fonction ?? '') }}"
                               class="form-control"
                               placeholder="Ex: Chef de scolarité">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Service</label>
                        <input type="text" name="service"
                               value="{{ old('service', $pats->service ?? '') }}"
                               class="form-control"
                               placeholder="Ex: Scolarité">
                    </div>

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