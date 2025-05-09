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
    } elseif (!in_array($_POST['role'], ['user', 'admin'])) {
        $errors[] = "Le rôle n'est pas valide";
    }
    
    if (empty($_POST['password'])) {
        $errors[] = "Le mot de passe est obligatoire";
    } elseif (strlen($_POST['password']) < 8) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères";
    } elseif (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $_POST['password'])) {
        $errors[] = "Le mot de passe doit contenir au moins une majuscule, une minuscule et un chiffre";
    }
    
    if (empty($_POST['password_confirm'])) {
        $errors[] = "La confirmation du mot de passe est obligatoire";
    } elseif ($_POST['password'] !== $_POST['password_confirm']) {
        $errors[] = "Les mots de passe ne correspondent pas";
    }
    
    if (empty($errors)) {
        $user = new User([
            "nom" => htmlspecialchars($_POST['nom']),
            "prenom" => htmlspecialchars($_POST['prenom']),
            "email" => htmlspecialchars($_POST['email']),
            "mdp" => $_POST['password'], // La classe User utilise mdp en interne, mais le repository le convertira en password pour la BDD
            "role" => htmlspecialchars($_POST['role'])
        ]);
        
        $repository = new UserRepository();
        $result = $repository->inscription($user);
        
        if ($result === "email_exists") {
            header('Location: ../../vue/admin/add_user.php?error=email_exists');
            exit();
        } elseif ($result === "success") {
            header('Location: ../../vue/admin/users.php?success=user_added');
            exit();
        } else {
            header('Location: ../../vue/admin/add_user.php?error=unknown');
            exit();
        }
    } else {
        $_SESSION['add_user_errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header('Location: ../../vue/admin/add_user.php');
        exit();
    }
} else {
    header('Location: ../../vue/admin/add_user.php');
    exit();
}