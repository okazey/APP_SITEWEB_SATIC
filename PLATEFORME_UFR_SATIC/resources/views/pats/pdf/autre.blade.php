<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Document Administratif</title>
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
        .titre-doc { text-align: center; margin: 30px 0; }
        .titre-doc h3 {
            font-size: 18px;
            color: #003E7E;
            text-transform: uppercase;
            text-decoration: underline;
        }
        .info-box {
            background: #f5f7fa;
            border-left: 4px solid #003E7E;
            padding: 15px 20px;
            margin: 20px 0;
        }
        .info-box table { width: 100%; }
        .info-box td { padding: 5px 0; }
        .info-box td:first-child { color: #666; width: 40%; }
        .info-box td:last-child { font-weight: bold; color: #003E7E; }
        .corps { line-height: 2; margin: 20px 0; }
        .signature { margin-top: 60px; text-align: right; }
        .footer {
            position: fixed;
            bottom: 20px;
            font-size: 10px;
            color: #999;
            text-align: center;
            left: 40px;
            right: 40px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Université Alioune Diop de Bambey</h1>
        <h2>UFR Sciences Appliquées et Technologies de l'Information et de la Communication</h2>
    </div>

    <div class="titre-doc">
        <h3>Document Administratif</h3>
    </div>

    <div class="info-box">
        <table>
            <tr>
                <td>Étudiant(e) :</td>
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
        </table>
    </div>

    <div class="corps">
        <p>
            Ce document est délivré à la demande de l'étudiant(e)
            pour servir et valoir ce que de droit.
        </p>
        @if($demande->commentaire_etudiant)
        <br>
        <p><strong>Motif de la demande :</strong></p>
        <p>{{ $demande->commentaire_etudiant }}</p>
        @endif
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