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
        
        if (empty($_POST["email"])) {
            $errors[] = "L'email est obligatoire";
        }
        
        if (empty($_POST["password"])) {
            $errors[] = "Le mot de passe est obligatoire";
        }
        
        if (empty($errors)) {
            $user = new User(array(
                'email' => $_POST['email'],
                'mdp' => $_POST['password'],
            ));
            
            $repository = new UserRepository();
            $resultat = $repository->connexion($user);
            
            if ($resultat != null) {
                $_SESSION['userConnecte'] = [
                    "nom" => $resultat->getNom(),
                    "prenom" => $resultat->getPrenom(),
                    "email" => $resultat->getEmail(),
                    "id" => $resultat->getIdUser(),
                    "role" => $resultat->getRole()
                ];
                
                header("Location: ../../index.php");
                exit();
            } else {
                $_SESSION['connexion_errors'] = ["Email ou mot de passe incorrect"];
                $_SESSION['form_data'] = ['email' => $_POST['email']];
                header("Location: ../../vue/connexion.php?error=invalid_credentials");
                exit();
            }
        } else {
            $_SESSION['connexion_errors'] = $errors;
            $_SESSION['form_data'] = ['email' => $_POST['email'] ?? ''];
            
            header('Location: ../../vue/connexion.php');
            exit();
        }
    } else {
        header('Location: ../../vue/connexion.php');
        exit();
    }
} catch (Exception $e) {
    error_log("Erreur de connexion: " . $e->getMessage());
    
    $_SESSION['connexion_errors'] = ["Une erreur est survenue: " . $e->getMessage()];
    
    header('Location: ../../vue/connexion.php?error=unknown');
    exit();
}