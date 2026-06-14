@extends('layouts.public')

@section('title', 'Présentation – UFR SATIC')

@section('content')

{{-- Header --}}
<section class="py-5" style="background:var(--uadb-bleu);color:white;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="--bs-breadcrumb-divider-color:rgba(255,255,255,0.5);">
                <li class="breadcrumb-item">
                    <a href="{{ route('accueil') }}" style="color:rgba(255,255,255,0.7);">Accueil</a>
                </li>
                <li class="breadcrumb-item active" style="color:white;">Présentation</li>
            </ol>
        </nav>
        <h1 style="font-weight:800;">Présentation de l'UFR SATIC</h1>
        <p style="opacity:0.85;">Université Alioune Diop de Bambey</p>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <h3 style="color:var(--uadb-bleu);font-weight:700;">Mot du Directeur</h3>
                <div class="section-divider" style="margin:0.8rem 0 1.5rem;"></div>
                <p>
                    L'UFR SATIC (Sciences Appliquées et Technologies de l'Information
                    et de la Communication) est une composante majeure de l'Université
                    Alioune Diop de Bambey (UADB), dédiée à la formation et à la recherche
                    dans les domaines des sciences et technologies.
                </p>
                <p>
                    Notre mission est de former des cadres compétents, capables de
                    répondre aux défis technologiques et scientifiques du Sénégal et de l'Afrique.
                    Nous offrons des formations de qualité allant de la Licence au Doctorat,
                    dans un environnement propice à l'innovation et à l'excellence académique.
                </p>

                <h4 class="mt-4" style="color:var(--uadb-bleu);font-weight:700;">Notre Mission</h4>
                <ul style="color:var(--uadb-texte);line-height:2;">
                    <li>Former des experts en sciences appliquées et technologies</li>
                    <li>Conduire des recherches de haut niveau</li>
                    <li>Contribuer au développement socio-économique du Sénégal</li>
                    <li>Établir des partenariats académiques nationaux et internationaux</li>
                    <li>Promouvoir l'innovation et l'entrepreneuriat technologique</li>
                </ul>

                <h4 class="mt-4" style="color:var(--uadb-bleu);font-weight:700;">Nos Valeurs</h4>
                <div class="row g-3 mt-1">
                    @foreach([
                        ['icon'=>'bi-star-fill','titre'=>'Excellence','desc'=>'Viser l\'excellence dans l\'enseignement et la recherche'],
                        ['icon'=>'bi-people-fill','titre'=>'Inclusion','desc'=>'Accueillir tous les profils et favoriser la diversité'],
                        ['icon'=>'bi-lightbulb-fill','titre'=>'Innovation','desc'=>'Encourager la créativité et l\'esprit entrepreneurial'],
                        ['icon'=>'bi-shield-fill-check','titre'=>'Intégrité','desc'=>'Respecter l\'éthique et la déontologie académique'],
                    ] as $valeur)
                    <div class="col-md-6">
                        <div class="d-flex gap-3 p-3 rounded-3"
                             style="background:var(--uadb-bleu-light);">
                            <i class="bi {{ $valeur['icon'] }} fs-4 flex-shrink-0"
                               style="color:var(--uadb-bleu);"></i>
                            <div>
                                <div style="font-weight:700;color:var(--uadb-bleu);">
                                    {{ $valeur['titre'] }}
                                </div>
                                <div style="font-size:0.85rem;color:var(--uadb-texte);">
                                    {{ $valeur['desc'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card-uadb p-4 mb-4">
                    <h5 style="color:var(--uadb-bleu);font-weight:700;">
                        <i class="bi bi-info-circle me-2"></i>Infos pratiques
                    </h5>
                    <hr>
                    <ul class="list-unstyled" style="font-size:0.88rem;">
                        <li class="mb-3">
                            <i class="bi bi-geo-alt-fill me-2" style="color:var(--uadb-vert);"></i>
                            <strong>Adresse :</strong><br>
                            <span style="color:var(--uadb-texte);padding-left:1.5rem;">
                                Bambey, Sénégal
                            </span>
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-telephone-fill me-2" style="color:var(--uadb-vert);"></i>
                            <strong>Téléphone :</strong><br>
                            <span style="color:var(--uadb-texte);padding-left:1.5rem;">
                                +221 33 XXX XX XX
                            </span>
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-envelope-fill me-2" style="color:var(--uadb-vert);"></i>
                            <strong>Email :</strong><br>
                            <span style="color:var(--uadb-texte);padding-left:1.5rem;">
                                contact@uadb.edu.sn
                            </span>
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-clock-fill me-2" style="color:var(--uadb-vert);"></i>
                            <strong>Horaires :</strong><br>
                            <span style="color:var(--uadb-texte);padding-left:1.5rem;">
                                Lun – Ven : 08h00 – 17h00
                            </span>
                        </li>
                    </ul>
                </div>

                <div class="card-uadb p-4"
                     style="background:var(--uadb-bleu);color:white;">
                    <h5 style="font-weight:700;">Chiffres clés</h5>
                    <hr style="border-color:rgba(255,255,255,0.2);">
                    @foreach([
                        ['nb'=>'2000+','label'=>'Étudiants'],
                        ['nb'=>'80+','label'=>'Enseignants-chercheurs'],
                        ['nb'=>'4','label'=>'Départements'],
                        ['nb'=>'12+','label'=>'Filières de formation'],
                        ['nb'=>'15+','label'=>'Années d\'existence'],
                    ] as $chiffre)
                    <div class="d-flex justify-content-between py-2"
                         style="border-bottom:1px solid rgba(255,255,255,0.1);">
                        <span style="font-size:0.88rem;opacity:0.85;">{{ $chiffre['label'] }}</span>
                        <span style="font-weight:800;color:var(--uadb-accent);">{{ $chiffre['nb'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@endsection