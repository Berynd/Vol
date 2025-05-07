<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../assets/css/insStyles.css">
</head>
<body>
<div class="container">
    <h1>Se connecter</h1>
    <form action="#" method="post">
        <div class="form-group">
            <label for="email">Adresse email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit">Se connecter</button>
    </form>

    <p class="login-link">Pas de compte ? <a href="inscription.php">S'inscrire</a></p>
</div>
</body>
</html>