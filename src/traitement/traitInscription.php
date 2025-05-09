<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once "../bdd/Bdd.php";
require_once "../modele/User.php";
require_once "../repository/UserRepository.php";

try {
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
        } elseif (strpos($_POST['email'], '@') === false) {
            $errors[] = "L'email doit contenir un @ (exemple: utilisateur@domaine)";
        }
        
        if (empty($_POST['password'])) {
            $errors[] = "Le mot de passe est obligatoire";
        } elseif (strlen($_POST['password']) < 8) {
            $errors[] = "Le mot de passe doit contenir au moins 8 caractères";
        }
        
        if (empty($_POST['confirm_password'])) {
            $errors[] = "La confirmation du mot de passe est obligatoire";
        } elseif ($_POST['password'] !== $_POST['confirm_password']) {
            $errors[] = "Les mots de passe ne correspondent pas";
        }
        
        if (empty($errors)) {
            $u = new User([
                "nom" => $_POST['nom'],
                "prenom" => $_POST['prenom'],
                "email" => $_POST['email'],
                "mdp" => $_POST['password'],
                "role" => "user"
            ]);
            
            $r = new UserRepository();
            $r->inscription($u);
            
        } else {
            $_SESSION['inscription_errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            
            header('Location: ../../vue/inscription.php');
            exit();
        }
    } else {
        header('Location: ../../vue/inscription.php');
        exit();
    }
} catch (Exception $e) {
    error_log("Erreur d'inscription: " . $e->getMessage());
    
    $_SESSION['inscription_errors'] = ["Une erreur est survenue: " . $e->getMessage()];
    
    header('Location: ../../vue/inscription.php');
    exit();
}

