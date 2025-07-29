<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Notification d'Immatriculation</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 650px;
            margin: 30px auto;
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 30px;
        }

        .email-header {
            text-align: center;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 10px;
        }

        .email-header img {
            width: 120px;
        }

        .email-body {
            padding: 20px 0;
            font-size: 16px;
            color: #343a40;
        }

        .email-footer {
            margin-top: 30px;
            font-size: 13px;
            color: #6c757d;
            text-align: center;
            border-top: 1px solid #dee2e6;
            padding-top: 15px;
        }

        .highlight {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px 16px;
            border-radius: 5px;
            border: 1px solid #f5c6cb;
            margin-top: 10px;
        }

        .btn {
            display: inline-block;
            background-color: #004085;
            color: white;
            padding: 10px 18px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            {{-- Remplace ce lien par celui de ton logo --}}
            <img src="https://upload.wikimedia.org/wikipedia/commons/5/5b/Logo_DGI_Cameroun.png" alt="Logo DGI">
            <h2>Direction Générale des Impôts</h2>
        </div>

        <div class="email-body">
            <p>Bonjour, Mr/Mlle <strong>{{ $nom }}</strong></p>

            <p class="highlight">
                Votre immatriculation effectuée le <strong>{{ \Carbon\Carbon::parse($created_at)->format('d/m/Y') }}</strong>
                n’a pas été approuvée <br>
                <strong>Motif :</strong> défaut de carte d'identité.
            </p>

            <p>
                Vous devez soumettre à nouveau vos pièces d'identité à la Direction Générale des Impôts
                <strong>au plus tard dans les 10 jours ouvrables</strong>.
            </p>

            <p>Merci de votre compréhension.</p>

            <a href="#" class="btn">Soumettre à nouveau</a>
        </div>

        <div class="email-footer">
            Ceci est un message automatique. Ne répondez pas à cet email.<br>
            © {{ date('Y') }} Direction Générale des Impôts. Tous droits réservés.
        </div>
    </div>
</body>
</html>
