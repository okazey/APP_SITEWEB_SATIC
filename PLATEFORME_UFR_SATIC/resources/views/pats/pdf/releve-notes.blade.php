<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Relevé de notes</title>
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
        .table-notes {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .table-notes th {
            background: #003E7E;
            color: white;
            padding: 10px;
            text-align: left;
        }
        .table-notes td {
            padding: 8px 10px;
            border-bottom: 1px solid #eee;
        }
        .table-notes tr:nth-child(even) { background: #f9f9f9; }
        .note { text-align: center; font-weight: bold; color: #003E7E; }
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
        .notice {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 11px;
            color: #856404;
            margin: 15px 0;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Université Alioune Diop de Bambey</h1>
        <h2>UFR Sciences Appliquées et Technologies de l'Information et de la Communication</h2>
    </div>

    <div class="titre-doc">
        <h3>Relevé de Notes</h3>
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
            <tr>
                <td>Année académique :</td>
                <td>{{ date('Y') }}-{{ date('Y') + 1 }}</td>
            </tr>
        </table>
    </div>

    <div class="notice">
        ⚠️ Ce relevé est un document provisoire. Les notes définitives
        sont disponibles après délibération du jury.
    </div>

    <table class="table-notes">
        <thead>
            <tr>
                <th>Module / Matière</th>
                <th>Semestre</th>
                <th style="text-align:center;">Note /20</th>
                <th style="text-align:center;">Crédits</th>
                <th style="text-align:center;">Résultat</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="5" style="text-align:center;color:#999;padding:20px;">
                    Les notes seront saisies par le service de scolarité
                </td>
            </tr>
        </tbody>
    </table>

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