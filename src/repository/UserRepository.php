<?php
use bdd\Bdd;

class UserRepository
{
    private $bdd;

    public function __construct()
    {
        $this->bdd = new Bdd();
    }

    public function inscription(User $user)
    {
        try {
            // Vérifier si l'email existe déjà
            $req2 = $this->bdd->getBdd()->prepare('SELECT * FROM user WHERE email = :email');
            $req2->execute(array(
                'email' => $user->getEmail(),
            ));

            $res = $req2->fetch();

            if ($res) {
                header('Location: ../../vue/inscription.php?error=email_exists');
                exit();
            } else {
                $hashedPassword = password_hash($user->getMdp(), PASSWORD_DEFAULT);

                try {
                    $this->bdd->getBdd()->query("SELECT 1 FROM user LIMIT 1");
                    
                    try {
                        $columnInfo = $this->bdd->getBdd()->query("SHOW COLUMNS FROM user LIKE 'password'");
                        $column = $columnInfo->fetch(\PDO::FETCH_ASSOC);
                        
                        if ($column && strpos($column['Type'], 'varchar') !== false) {
                            $size = (int) filter_var($column['Type'], FILTER_SANITIZE_NUMBER_INT);
                            if ($size < 255) {
                                $this->bdd->getBdd()->exec("ALTER TABLE user MODIFY password VARCHAR(255) NOT NULL");
                            }
                        }
                    } catch (\PDOException $e) {
                    }
                } catch (\PDOException $e) {
                    $createTable = "CREATE TABLE user (
                        id_user INT AUTO_INCREMENT PRIMARY KEY,
                        nom VARCHAR(50) NOT NULL,
                        prenom VARCHAR(50) NOT NULL,
                        email VARCHAR(100) NOT NULL,
                        password VARCHAR(255) NOT NULL,
                        role VARCHAR(20) DEFAULT 'user',
                        token VARCHAR(255) DEFAULT NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
                    
                    $this->bdd->getBdd()->exec($createTable);
                }

                $sql = 'INSERT INTO user(nom, prenom, email, password, role) 
                    VALUES (:nom, :prenom, :email, :password, :role)';
                $req = $this->bdd->getBdd()->prepare($sql);
                $res = $req->execute([
                    'nom' => $user->getNom(),
                    'prenom' => $user->getPrenom(),
                    'email' => $user->getEmail(),
                    'password' => $hashedPassword,
                    'role' => $user->getRole() ?? 'user'
                ]);
                
                if ($res) {
                    header('Location: ../../vue/connexion.php?success=inscription');
                    exit();
                } else {
                    $errorInfo = $req->errorInfo();
                    header('Location: ../../vue/inscription.php?error=unknown&details=' . urlencode($errorInfo[2]));
                    exit();
                }
            }
        } catch (\PDOException $e) {
            error_log("Erreur d'inscription: " . $e->getMessage());
            header('Location: ../../vue/inscription.php?error=exception&message=' . urlencode($e->getMessage()));
            exit();
        } catch (\Exception $e) {
            error_log("Erreur d'inscription: " . $e->getMessage());
            header('Location: ../../vue/inscription.php?error=exception&message=' . urlencode($e->getMessage()));
            exit();
        }
    }
    public function connexion(user $user)
    {
        $sqlconnexion = 'SELECT * FROM user WHERE email = :email';
        $reqconnexion = $this->bdd->getBdd()->prepare($sqlconnexion);
        $reqconnexion->execute(array(
            'email' => $user->getEmail(),
        ));
        $donne = $reqconnexion->fetch();
        if($donne && password_verify($user->getMdp(), $donne['password'])) {
            $user->setNom($donne['nom']);
            $user->setPrenom($donne['prenom']);
            $user->setEmail($donne['email']);
            $user->setMdp($donne['password']);
            $user->setRole($donne['role']);
            $user->setIdUser($donne['id_user']);


            $_SESSION['role'] = $user->getRole();
            return $user;
        }
        else {
            return null;
        }

    }

    public function modification(user $user)
    {
        $sqlmodification = "UPDATE user SET nom = :nom, prenom = :prenom, email = :email, password = :password WHERE id_user = :id_user";
        $reqmodification = $this->bdd->getBdd()->prepare($sqlmodification);
        $resmodification = $reqmodification->execute(array(
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'email' => $user->getEmail(),
            'password' => $user->getMdp(),
            'id_user' => $user->getIdUser()
        ));
        header("Location: ../../vue/profil.php");
        return $resmodification ? "Modification réussie" : "Échec de la modification";
    }


    public function suppression(User $user)
    {
        $sqlsuppression = 'DELETE FROM user WHERE id_user = :id_user';
        $reqsuppression = $this->bdd->getBdd()->prepare($sqlsuppression);
        $ressuppression = $reqsuppression->execute(array(
            'id_user' => $user->getIdUser()
        ));

        return $ressuppression ? "Suppression réussie" : "Échec de la suppression";
    }
    public function afficherUtilisateur(User $user)
    {
        $affiche = "SELECT * FROM user WHERE id_user=:idUser";
        $req = $this->bdd->getBdd()->prepare($affiche);
        $req->execute(array(
            'idUser' => $user->getIdUser()));
        return $req->fetch();
    }
}

