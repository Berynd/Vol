<?php
session_start();

$formData = $_SESSION['form_data'] ?? [
    'nom' => '',
    'prenom' => '',
    'email' => ''
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
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
    <h1>Créer un compte</h1>
    
    <?php if (isset($_SESSION['inscription_errors']) && !empty($_SESSION['inscription_errors'])): ?>
        <div class="error-message">
            <?php foreach ($_SESSION['inscription_errors'] as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
        <?php unset($_SESSION['inscription_errors']); ?>
    <?php endif; ?>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="error-message">
            <?php if ($_GET['error'] === 'email_exists'): ?>
                <p>Cette adresse email est déjà utilisée par un autre utilisateur.</p>
            <?php elseif ($_GET['error'] === 'unknown'): ?>
                <p>Une erreur inconnue s'est produite. Veuillez réessayer.</p>
            <?php elseif ($_GET['error'] === 'exception'): ?>
                <p>Erreur: <?= htmlspecialchars($_GET['message'] ?? 'Erreur inconnue') ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['success']) && $_GET['success'] === 'inscription'): ?>
        <div class="success-message">
            <p>Votre compte a été créé avec succès. Vous pouvez maintenant vous connecter.</p>
        </div>
    <?php endif; ?>
    
    <form action="../src/traitement/traitInscription.php" method="post">
        <div class="form-group">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($formData['nom']) ?>" required>
        </div>

        <div class="form-group">
            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($formData['prenom']) ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Adresse email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($formData['email']) ?>" required>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password"
                   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                   title="8 caractères minimum avec au moins 1 majuscule, 1 minuscule et 1 chiffre" required>
            <small style="display: block; margin-top: 5px; color: #666;">8 caractères minimum avec au moins 1 majuscule, 1 minuscule et 1 chiffre</small>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirmer le mot de passe:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>

        <button type="submit">S'inscrire</button>
    </form>

    <p class="login-link">Déjà inscrit? <a href="connexion.php">Se connecter</a></p>
</div>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirm_password').value;
    
    if (password !== confirmPassword) {
        e.preventDefault();
        alert('Les mots de passe ne correspondent pas.');
    }
    
    var passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
    if (!passwordRegex.test(password)) {
        e.preventDefault();
        alert('Le mot de passe doit contenir au moins 8 caractères, dont une majuscule, une minuscule et un chiffre.');
    }
});
</script>
</body>
</html>
