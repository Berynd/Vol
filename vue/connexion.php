<?php
session_start();

// Récupérer les données du formulaire en cas d'erreur
$formData = $_SESSION['form_data'] ?? [
    'email' => ''
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../assets/css/insStyles.css">
    <style>
        .error-message {
            color: red;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #ffeeee;
            border: 1px solid #ffcccc;
            border-radius: 5px;
        }
        .success-message {
            color: green;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #eeffee;
            border: 1px solid #ccffcc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Se connecter</h1>
    
    <?php if (isset($_SESSION['connexion_errors']) && !empty($_SESSION['connexion_errors'])): ?>
        <div class="error-message">
            <?php foreach ($_SESSION['connexion_errors'] as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
        <?php unset($_SESSION['connexion_errors']); ?>
    <?php endif; ?>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="error-message">
            <?php if ($_GET['error'] === 'invalid_credentials'): ?>
                <p>Email ou mot de passe incorrect.</p>
            <?php elseif ($_GET['error'] === 'unknown'): ?>
                <p>Une erreur inconnue s'est produite. Veuillez réessayer.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['success']) && $_GET['success'] === 'inscription'): ?>
        <div class="success-message">
            <p>Votre compte a été créé avec succès. Vous pouvez maintenant vous connecter.</p>
        </div>
    <?php endif; ?>
    
    <form action="../src/traitement/traitConnexion.php" method="post">
        <div class="form-group">
            <label for="email">Adresse email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($formData['email']) ?>" required>
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
