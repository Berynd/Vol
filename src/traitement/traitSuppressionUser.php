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

if ($userId === intval($_SESSION['userConnecte']['idUtilisateur'])) {
    header('Location: ../../vue/admin/users.php?error=cannot_delete_self');
    exit();
}

$repository = new UserRepository();
$result = $repository->suppression($userId);

if ($result === "success") {
    header('Location: ../../vue/admin/users.php?success=user_deleted');
    exit();
} else {
    header('Location: ../../vue/admin/users.php?error=delete_failed');
    exit();
}