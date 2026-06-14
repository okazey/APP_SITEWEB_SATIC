<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Attestation d'inscription</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            padding: 40px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #003E7E;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #003E7E;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .header h2 {
            color: #00A86B;
            font-size: 13px;
            margin-top: 5px;
        }
        .titre-doc {
            text-align: center;
            margin: 30px 0;
        }
        .titre-doc h3 {
            font-size: 18px;
            color: #003E7E;
            text-transform: uppercase;
            text-decoration: underline;
            letter-spacing: 3px;
        }
        .numero {
            text-align: center;
            font-size: 11px;
            color: #666;
            margin-bottom: 30px;
        }
        .corps {
            line-height: 2;
            text-align: justify;
            margin: 20px 0;
        }
        .corps strong {
            color: #003E7E;
        }
        .info-box {
            background: #f5f7fa;
            border-left: 4px solid #003E7E;
            padding: 15px 20px;
            margin: 20px 0;
        }
        .info-box table {
            width: 100%;
        }
        .info-box td {
            padding: 5px 0;
        }
        .info-box td:first-child {
            color: #666;
            width: 40%;
        }
        .info-box td:last-child {
            font-weight: bold;
            color: #003E7E;
        }
        .signature {
            margin-top: 60px;
            text-align: right;
        }
        .signature p {
            margin-bottom: 5px;
        }
        .signature .date {
            color: #666;
            font-size: 11px;
        }
        .signature .signataire {
            font-weight: bold;
            color: #003E7E;
            margin-top: 10px;
        }
        .footer {
            position: fixed;
            bottom: 20px;
            left: 40px;
            right: 40px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
            font-size: 10px;
            color: #999;
            text-align: center;
        }
        .cachet {
            margin-top: 40px;
            text-align: center;
        }
        .cachet-box {
            display: inline-block;
            border: 2px dashed #003E7E;
            padding: 20px 40px;
            color: #003E7E;
            font-size: 11px;
        }
    </style>
</head>
<body>

    {{-- En-tête --}}
    <div class="header">
        <h1>Université Alioune Diop de Bambey</h1>
        <h2>UFR Sciences Appliquées et Technologies de l'Information et de la Communication</h2>
        <p style="color:#666;font-size:11px;margin-top:5px;">
            Bambey, Sénégal | contact@uadb.edu.sn
        </p>
    </div>

    {{-- Titre --}}
    <div class="titre-doc">
        <h3>Attestation d'Inscription</h3>
    </div>
    <div class="numero">
        N° {{ str_pad($demande->id, 5, '0', STR_PAD_LEFT) }}/UFR-SATIC/{{ date('Y') }}
    </div>

    {{-- Corps --}}
    <div class="corps">
        <p>
            Le Directeur de l'UFR Sciences Appliquées et Technologies
            de l'Information et de la Communication (SATIC) de l'Université
            Alioune Diop de Bambey certifie que :
        </p>
    </div>

    {{-- Informations étudiant --}}
    <div class="info-box">
        <table>
            <tr>
                <td>Nom et Prénom(s) :</td>
                <td>{{ strtoupper($demande->etudiant->user->nom) }} {{ $demande->etudiant->user->prenom }}</td>
            </tr>
            <tr>
                <td>Numéro Matricule :</td>
                <td>{{ $demande->etudiant->matricule }}</td>
            </tr>
            <tr>
                <td>Formation :</td>
                <td>{{ $demande->etudiant->formation->nom ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Niveau :</td>
                <td>{{ $demande->etudiant->niveau }}</td>
            </tr>
            <tr>
                <td>Département :</td>
                <td>{{ $demande->etudiant->formation->departement->nom ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Année académique :</td>
                <td>{{ date('Y') }}-{{ date('Y') + 1 }}</td>
            </tr>
        </table>
    </div>

    <div class="corps">
        <p>
            est régulièrement inscrit(e) dans notre établissement pour l'année
            académique <strong>{{ date('Y') }}-{{ date('Y') + 1 }}</strong>
            en <strong>{{ $demande->etudiant->formation->nom ?? 'N/A' }}</strong>,
            niveau <strong>{{ $demande->etudiant->niveau }}</strong>.
        </p>
        <br>
        <p>
            La présente attestation est délivrée à l'intéressé(e) pour servir
            et valoir ce que de droit.
        </p>
    </div>

    {{-- Signature --}}
    <div class="signature">
        <p class="date">Fait à Bambey, le {{ now()->locale('fr')->isoFormat('D MMMM YYYY') }}</p>
        <br><br><br>
        <p class="signataire">Le Directeur de l'UFR SATIC</p>
        <p style="color:#666;font-size:11px;">Université Alioune Diop de Bambey</p>
    </div>

    {{-- Cachet --}}
    <div class="cachet">
        <div class="cachet-box">
            CACHET OFFICIEL<br>UFR SATIC – UADB
        </div>
    </div>

    {{-- Footer --}}
    <div class="footer">
        UFR SATIC – Université Alioune Diop de Bambey | Bambey, Sénégal |
        Document généré le {{ now()->format('d/m/Y à H:i') }}
    </div>

</body>
</html>