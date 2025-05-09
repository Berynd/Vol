<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../bdd/Bdd.php";
require_once "../modele/User.php";

$logFile = fopen("inscription_simple_log.txt", "a");
fwrite($logFile, "Début du traitement d'inscription: " . date('Y-m-d H:i:s') . "\n");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    fwrite($logFile, "Méthode POST détectée\n");
    fwrite($logFile, "Données reçues: " . print_r($_POST, true) . "\n");
    

    
    if (empty($_POST['nom'])) {
        $errors[] = "Le nom est obligatoire";
    }
    
    if (empty($_POST['prenom'])) {
        $errors[] = "Le prénom est obligatoire";
    }
    
    if (empty($_POST['email'])) {
        $errors[] = "L'email est obligatoire";
    } 
    elseif (strpos($_POST['email'], '@') === false) {
        $errors[] = "L'email doit contenir un @ (exemple: utilisateur@domaine)";
    }
    
    if (empty($_POST['password'])) {
        $errors[] = "Le mot de passe est obligatoire";
    } elseif (strlen($_POST['password']) < 8) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères";
    }
    
    if (empty($_POST['password_confirm'])) {
        $errors[] = "La confirmation du mot de passe est obligatoire";
    } elseif ($_POST['password'] !== $_POST['password_confirm']) {
        $errors[] = "Les mots de passe ne correspondent pas";
    }
    
    fwrite($logFile, "Erreurs de validation: " . print_r($errors, true) . "\n");
    
    if (empty($errors)) {
        fwrite($logFile, "Aucune erreur de validation, création de l'utilisateur\n");
        
        try {
            $bdd = new bdd\Bdd();
            fwrite($logFile, "Connexion à la base de données réussie\n");
            
            try {
                $bdd->getBdd()->query("SELECT 1 FROM user LIMIT 1");
                fwrite($logFile, "Table 'user' existe déjà\n");
            } catch (PDOException $e) {
                fwrite($logFile, "Table 'user' non trouvée, création...\n");
                
                $createTable = "CREATE TABLE user (
                    id_user INT AUTO_INCREMENT PRIMARY KEY,
                    nom VARCHAR(50) NOT NULL,
                    prenom VARCHAR(50) NOT NULL,
                    email VARCHAR(100) NOT NULL,
                    password VARCHAR(255) NOT NULL,
                    role VARCHAR(20) DEFAULT 'user',
                    token VARCHAR(255) DEFAULT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
                
                $bdd->getBdd()->exec($createTable);
                fwrite($logFile, "Table 'user' créée avec succès\n");
            }
            
            $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
            
            $sql = 'INSERT INTO user(nom, prenom, email, password, role) 
                VALUES (:nom, :prenom, :email, :password, :role)';
            $req = $bdd->getBdd()->prepare($sql);
            
            $params = [
                'nom' => htmlspecialchars($_POST['nom']),
                'prenom' => htmlspecialchars($_POST['prenom']),
                'email' => htmlspecialchars($_POST['email']),
                'password' => $hashedPassword,
                'role' => 'user'
            ];
            
            fwrite($logFile, "Paramètres d'insertion: " . print_r($params, true) . "\n");
            
            $res = $req->execute($params);
            
            if ($res) {
                fwrite($logFile, "Utilisateur inséré avec succès\n");
                
                header('Location: ../../vue/connexion.php?success=inscription');
                exit();
            } else {
                $errorInfo = $req->errorInfo();
                fwrite($logFile, "Erreur SQL lors de l'insertion: " . print_r($errorInfo, true) . "\n");
                
                header('Location: ../../vue/inscription.php?error=unknown&details=' . urlencode($errorInfo[2]));
                exit();
            }
        } catch (PDOException $e) {
            fwrite($logFile, "Exception PDO: " . $e->getMessage() . "\n");
            header('Location: ../../vue/inscription.php?error=exception&message=' . urlencode($e->getMessage()));
            exit();
        } catch (Exception $e) {
            fwrite($logFile, "Exception: " . $e->getMessage() . "\n");
            header('Location: ../../vue/inscription.php?error=exception&message=' . urlencode($e->getMessage()));
            exit();
        }
    } else {
        fwrite($logFile, "Redirection avec erreurs\n");
        $_SESSION['inscription_errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        
        $errorString = urlencode(implode(', ', $errors));
        header('Location: ../../vue/inscription.php?debug_errors=' . $errorString);
        exit();
    }
} else {
    fwrite($logFile, "Méthode non-POST, redirection\n");
    header('Location: ../../vue/inscription.php');
    exit();
}

