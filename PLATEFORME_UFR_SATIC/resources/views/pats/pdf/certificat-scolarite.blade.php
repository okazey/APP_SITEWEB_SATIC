<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Certificat de scolarité</title>
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
        .header h1 { color: #003E7E; font-size: 16px; text-transform: uppercase; }
        .header h2 { color: #00A86B; font-size: 13px; margin-top: 5px; }
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
        .corps { line-height: 2; text-align: justify; margin: 20px 0; }
        .info-box {
            background: #f5f7fa;
            border-left: 4px solid #00A86B;
            padding: 15px 20px;
            margin: 20px 0;
        }
        .info-box table { width: 100%; }
        .info-box td { padding: 5px 0; }
        .info-box td:first-child { color: #666; width: 40%; }
        .info-box td:last-child { font-weight: bold; color: #003E7E; }
        .signature { margin-top: 60px; text-align: right; }
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
    </style>
</head>
<body>

    <div class="header">
        <h1>Université Alioune Diop de Bambey</h1>
        <h2>UFR Sciences Appliquées et Technologies de l'Information et de la Communication</h2>
    </div>

    <div class="titre-doc">
        <h3>Certificat de Scolarité</h3>
    </div>

    <div class="corps">
        <p>
            Je soussigné, Directeur de l'UFR SATIC de l'Université Alioune Diop
            de Bambey, certifie que l'étudiant(e) dont les informations suivent
            est bien inscrit(e) dans notre établissement :
        </p>
    </div>

    <div class="info-box">
        <table>
            <tr>
                <td>Nom et Prénom(s) :</td>
                <td>{{ strtoupper($demande->etudiant->user->nom) }} {{ $demande->etudiant->user->prenom }}</td>
            </tr>
            <tr>
                <td>Matricule :</td>
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
                <td>Année académique :</td>
                <td>{{ date('Y') }}-{{ date('Y') + 1 }}</td>
            </tr>
        </table>
    </div>

    <div class="corps">
        <p>
            Ce certificat est établi à la demande de l'intéressé(e)
            pour servir et valoir ce que de droit.
        </p>
    </div>

    <div class="signature">
        <p>Fait à Bambey, le {{ now()->locale('fr')->isoFormat('D MMMM YYYY') }}</p>
        <br><br><br>
        <p style="font-weight:bold;color:#003E7E;">Le Directeur de l'UFR SATIC</p>
    </div>

    <div class="footer">
        UFR SATIC – UADB | Document généré le {{ now()->format('d/m/Y à H:i') }}
    </div>

</body>
</html>