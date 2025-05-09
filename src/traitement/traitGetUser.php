<?php
session_start();

require_once "../bdd/Bdd.php";
require_once "../modele/User.php";
require_once "../repository/UserRepository.php";

if (!isset($_SESSION['userConnecte']) || $_SESSION['userConnecte']['role'] !== 'admin') {
    header('Location: ../../index.php?error=access_denied');
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: ../../vue/admin/users.php?error=missing_id');
    exit();
}

$userId = intval($_GET['id']);

$repository = new UserRepository();
$user = $repository->getUserById($userId);

if ($user) {
    $_SESSION['edit_user'] = [
        'id' => $user->getIdUser(),
        'nom' => $user->getNom(),
        'prenom' => $user->getPrenom(),
        'email' => $user->getEmail(),
        'role' => $user->getRole()
    ];
    
    header('Location: ../../vue/admin/edit_user.php?id=' . $userId);
    exit();
} else {
    header('Location: ../../vue/admin/users.php?error=user_not_found');
    exit();
}