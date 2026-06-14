@extends('layouts.public')

@section('title', 'Contact – UFR SATIC')

@section('content')

<section class="py-5" style="background:var(--uadb-bleu);color:white;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('accueil') }}" style="color:rgba(255,255,255,0.7);">Accueil</a>
                </li>
                <li class="breadcrumb-item active" style="color:white;">Contact</li>
            </ol>
        </nav>
        <h1 style="font-weight:800;">Contactez-nous</h1>
        <p style="opacity:0.85;">Notre équipe est à votre disposition</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-5">

            {{-- Formulaire --}}
            <div class="col-lg-7">
                <div class="card-uadb p-4 p-md-5">
                    <h4 style="color:var(--uadb-bleu);font-weight:700;" class="mb-4">
                        <i class="bi bi-envelope me-2"></i> Envoyer un message
                    </h4>

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('contact.store') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nom complet *</label>
                                <input type="text" name="nom"
                                       value="{{ old('nom') }}"
                                       class="form-control @error('nom') is-invalid @enderror"
                                       placeholder="Votre nom">
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email *</label>
                                <input type="email" name="email"
                                       value="{{ old('email') }}"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="votre@email.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Sujet *</label>
                                <input type="text" name="sujet"
                                       value="{{ old('sujet') }}"
                                       class="form-control @error('sujet') is-invalid @enderror"
                                       placeholder="Objet de votre message">
                                @error('sujet')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Message *</label>
                                <textarea name="message" rows="6"
                                          class="form-control @error('message') is-invalid @enderror"
                                          placeholder="Votre message (minimum 20 caractères)...">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-uadb px-5 py-2">
                                    <i class="bi bi-send me-2"></i> Envoyer le message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Infos contact --}}
            <div class="col-lg-5">
                <h4 style="color:var(--uadb-bleu);font-weight:700;" class="mb-4">
                    Informations de contact
                </h4>

                <div class="d-flex flex-column gap-3">
                    @foreach([
                        ['icon'=>'bi-geo-alt-fill','titre'=>'Adresse','info'=>'Bambey, Sénégal'],
                        ['icon'=>'bi-telephone-fill','titre'=>'Téléphone','info'=>'+221 33 XXX XX XX'],
                        ['icon'=>'bi-envelope-fill','titre'=>'Email','info'=>'contact@uadb.edu.sn'],
                        ['icon'=>'bi-clock-fill','titre'=>'Horaires','info'=>'Lun – Ven : 08h00 – 17h00'],
                    ] as $info)
                    <div class="d-flex gap-3 align-items-start p-3 rounded-3"
                         style="background:var(--uadb-bleu-light);">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                             style="width:45px;height:45px;background:var(--uadb-bleu);">
                            <i class="bi {{ $info['icon'] }} text-white"></i>
                        </div>
                        <div>
                            <div style="font-weight:700;color:var(--uadb-bleu);font-size:0.88rem;">
                                {{ $info['titre'] }}
                            </div>
                            <div style="color:var(--uadb-texte);font-size:0.88rem;">
                                {{ $info['info'] }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Réseaux sociaux --}}
                <div class="mt-4">
                    <h6 style="color:var(--uadb-bleu);font-weight:700;">Suivez-nous</h6>
                    <div class="d-flex gap-2 mt-2">
                        @foreach([
                            ['icon'=>'bi-facebook','color'=>'#1877f2'],
                            ['icon'=>'bi-twitter-x','color'=>'#000'],
                            ['icon'=>'bi-linkedin','color'=>'#0077b5'],
                            ['icon'=>'bi-youtube','color'=>'#ff0000'],
                        ] as $rs)
                        <a href="#"
                           class="d-flex align-items-center justify-content-center rounded-circle text-white"
                           style="width:40px;height:40px;background:{{ $rs['color'] }};font-size:1rem;">
                            <i class="bi {{ $rs['icon'] }}"></i>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection