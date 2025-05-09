<?php
session_start();

require_once "../bdd/Bdd.php";
require_once "../modele/User.php";
require_once "../repository/UserRepository.php";

if (!isset($_SESSION['userConnecte']) || $_SESSION['userConnecte']['role'] !== 'admin') {
    header('Location: ../../index.php?error=access_denied');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        $errors[] = "ID utilisateur manquant";
    }
    
    if (empty($_POST['nom'])) {
        $errors[] = "Le nom est obligatoire";
    }
    
    if (empty($_POST['prenom'])) {
        $errors[] = "Le prénom est obligatoire";
    }
    
    if (empty($_POST['email'])) {
        $errors[] = "L'email est obligatoire";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email n'est pas valide";
    }
    
    if (empty($_POST['role'])) {
        $errors[] = "Le rôle est obligatoire";
    }
    
    if (!empty($_POST['password'])) {
        if (strlen($_POST['password']) < 6) {
            $errors[] = "Le mot de passe doit contenir au moins 6 caractères";
        }
        
        if ($_POST['password'] !== $_POST['password_confirm']) {
            $errors[] = "Les mots de passe ne correspondent pas";
        }
    }
    
    if (empty($errors)) {
        $userData = [
            "id" => intval($_POST['id']),
            "nom" => htmlspecialchars($_POST['nom']),
            "prenom" => htmlspecialchars($_POST['prenom']),
            "email" => htmlspecialchars($_POST['email']),
            "role" => htmlspecialchars($_POST['role'])
        ];
        
        if (!empty($_POST['password'])) {
            $userData['mdp'] = $_POST['password'];
        }
        
        $user = new User($userData);
        
        $repository = new UserRepository();
        $result = $repository->modification($user);
        
        if ($result === "email_exists") {
            header('Location: ../../vue/admin/edit_user.php?id=' . $_POST['id'] . '&error=email_exists');
            exit();
        } elseif ($result === "success") {
            header('Location: ../../vue/admin/users.php?success=user_updated');
            exit();
        } else {
            header('Location: ../../vue/admin/edit_user.php?id=' . $_POST['id'] . '&error=unknown');
            exit();
        }
    } else {
        $_SESSION['edit_user_errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header('Location: ../../vue/admin/edit_user.php?id=' . $_POST['id']);
        exit();
    }
} else {
    header('Location: ../../vue/admin/users.php');
    exit();
}