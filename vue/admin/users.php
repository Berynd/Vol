<?php
session_start();

// Vérifier si l'utilisateur est connecté et a le rôle d'administrateur
if (!isset($_SESSION['userConnecte']) || $_SESSION['userConnecte']['role'] !== 'admin') {
    header('Location: ../../index.php?error=access_denied');
    exit();
}

// Inclure les fichiers nécessaires
require_once "../../src/bdd/Bdd.php";
require_once "../../src/modele/User.php";
require_once "../../src/repository/UserRepository.php";

// Récupérer la liste des utilisateurs
$repository = new UserRepository();
$users = $repository->getAllUsers();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration des utilisateurs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Administration des utilisateurs</h1>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                <?php if ($_GET['success'] === 'user_deleted'): ?>
                    <p>L'utilisateur a été supprimé avec succès.</p>
                <?php elseif ($_GET['success'] === 'user_updated'): ?>
                    <p>L'utilisateur a été mis à jour avec succès.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <?php if ($_GET['error'] === 'missing_id'): ?>
                    <p>ID utilisateur manquant.</p>
                <?php elseif ($_GET['error'] === 'user_not_found'): ?>
                    <p>Utilisateur non trouvé.</p>
                <?php elseif ($_GET['error'] === 'delete_failed'): ?>
                    <p>Échec de la suppression de l'utilisateur.</p>
                <?php elseif ($_GET['error'] === 'cannot_delete_self'): ?>
                    <p>Vous ne pouvez pas supprimer votre propre compte.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <div class="mb-3">
            <a href="../../index.php" class="btn btn-secondary">Retour à l'accueil</a>
            <a href="../profil.php" class="btn btn-info">Mon profil</a>
        </div>
        
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Liste des utilisateurs</h5>
                <a href="add_user.php" class="btn btn-primary btn-sm">Ajouter un utilisateur</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Rôle</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($users)): ?>
                                <tr>
                                    <td colspan="6" class="text-center">Aucun utilisateur trouvé</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= $user->getIdUser() ?></td>
                                        <td><?= htmlspecialchars($user->getNom()) ?></td>
                                        <td><?= htmlspecialchars($user->getPrenom()) ?></td>
                                        <td><?= htmlspecialchars($user->getEmail()) ?></td>
                                        <td>
                                            <?php if ($user->getRole() === 'admin'): ?>
                                                <span class="badge badge-danger">Admin</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">Utilisateur</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="../../src/traitement/traitGetUser.php?id=<?= $user->getIdUser() ?>" class="btn btn-sm btn-info">Modifier</a>
                                            
                                            <?php if ($user->getIdUser() != $_SESSION['userConnecte']['idUtilisateur']): ?>
                                                <a href="../../src/traitement/traitSuppressionUser.php?id=<?= $user->getIdUser() ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">Supprimer</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>