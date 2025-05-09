<?php
session_start();

require_once "../bdd/Bdd.php";
require_once "../modele/User.php";
require_once "../repository/UserRepository.php";


if (!isset($_SESSION['userConnecte']) || $_SESSION['userConnecte']['role'] !== 'admin') {
    header('Location: ../../index.php?error=access_denied');
    exit();
}

$repository = new UserRepository();
$users = $repository->getAllUsers();

$_SESSION['users_list'] = $users;

header('Location: ../../vue/admin/users.php');
exit();