<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de rendez-vous</title>
</head>
<body>
    <p>Bonjour,</p>
    <p>Votre rendez-vous a été enregistré avec succès.</p>
    <p><strong>Date et heure :</strong> {{ $rendezVous->date_heure }}</p>
    <p><strong>Service :</strong> {{ $rendezVous->service->nom }}</p>
    <p><strong>Médecin :</strong> {{ $rendezVous->medecin->nom }}</p>
    <p>Merci de votre confiance.</p>
</body>
</html>
