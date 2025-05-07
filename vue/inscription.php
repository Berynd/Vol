<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../assets/css/insStyles.css">
</head>
<body>
<div class="container">
    <h1>Créer un compte</h1>
    <form action="../src/traitement/traitInscription.php" method="post">
        <div class="form-group">
            <label for="pseudo">Nom:</label>
            <input type="text" id="nom" name="nom" required>
        </div>

        <div class="form-group">
            <label for="pseudo">Prénom:</label>
            <input type="text" id="prenom" name="prenom" required>
        </div>

        <div class="form-group">
            <label for="email">Adresse email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password"
                   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                   title="8 caractères minimum avec au moins 1 majuscule, 1 minuscule et 1 chiffre" required>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirmer le mot de passe:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>

        <button type="submit">S'inscrire</button>
    </form>

    <p class="login-link">Déjà inscrit? <a href="connexion.php">Se connecter</a></p>
</div>
</body>
</html>