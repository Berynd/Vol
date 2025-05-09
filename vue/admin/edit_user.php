global$user; global$user; <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un utilisateur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Modifier un utilisateur</h1>
        
        <?php if (isset($_SESSION['edit_user_errors']) && !empty($_SESSION['edit_user_errors'])): ?>
            <div class="alert alert-danger">
                <?php foreach ($_SESSION['edit_user_errors'] as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
            <?php unset($_SESSION['edit_user_errors']); ?>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <?php if ($_GET['error'] === 'email_exists'): ?>
                    <p>Cette adresse email est déjà utilisée par un autre utilisateur.</p>
                <?php elseif ($_GET['error'] === 'unknown'): ?>
                    <p>Une erreur inconnue s'est produite. Veuillez réessayer.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <div class="mb-3">
            <a href="users.php" class="btn btn-secondary">Retour à la liste</a>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Modifier l'utilisateur #<?= htmlspecialchars($user['id']) ?></h5>
            </div>
            <div class="card-body">
                <form action="../../src/traitement/traitModificationUser.php" method="post">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
                    
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($formData['nom']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="prenom">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($formData['prenom']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($formData['email']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="role">Rôle</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="user" <?= $formData['role'] === 'user' ? 'selected' : '' ?>>Utilisateur</option>
                            <option value="admin" <?= $formData['role'] === 'admin' ? 'selected' : '' ?>>Administrateur</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <small class="form-text text-muted">8 caractères minimum avec au moins 1 majuscule, 1 minuscule et 1 chiffre</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirm">Confirmer le nouveau mot de passe</label>
                        <input type="password" class="form-control" id="password_confirm" name="password_confirm">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
    // Validation côté client pour s'assurer que les mots de passe correspondent
    document.querySelector('form').addEventListener('submit', function(e) {
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('password_confirm').value;
        
        // Vérifier uniquement si un nouveau mot de passe est fourni
        if (password) {
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Les mots de passe ne correspondent pas.');
            }
            
            // Vérifier la complexité du mot de passe
            var passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
            if (!passwordRegex.test(password)) {
                e.preventDefault();
                alert('Le mot de passe doit contenir au moins 8 caractères, dont une majuscule, une minuscule et un chiffre.');
            }
        }
    });
    </script>
</body>
</html>

<?php
// Nettoyer les données de session après affichage
unset($_SESSION['form_data']);
?>