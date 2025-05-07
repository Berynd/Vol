<?php
class UserRepository
{
    private $bdd;

    public function __construct()
    {
        $this->bdd = new Bdd();
    }

    public function inscription(User $user)
    {
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

            $sql = 'INSERT INTO user(nom, prenom, email, mdp) 
                VALUES (:nom, :prenom, :email, :mdp)';
            $req = $this->bdd->getBdd()->prepare($sql);
            $res = $req->execute([
                'nom' => $user->getNom(),
                'prenom' => $user->getPrenom(),
                'email' => $user->getEmail(),
                'mdp' => $hashedPassword, // Utiliser le hash
            ]);
            header('Location: ../../vue/connexion.php');
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
        if($donne && password_verify($user->getMdp(), $donne['mdp'])) {
            $user->setNom($donne['nom']);
            $user->setPrenom($donne['prenom']);
            $user->setEmail($donne['email']);
            $user->setMdp($donne['mdp']);
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
        $sqlmodification = "UPDATE user SET nom = :nom, prenom = :prenom, email = :email, mdp = :mdp WHERE id_user = :id_user";
        $reqmodification = $this->bdd->getBdd()->prepare($sqlmodification);
        $resmodification = $reqmodification->execute(array(
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'email' => $user->getEmail(),
            'mdp' => $user->getMdp(),
            'id_user' => $user->getIdUser()
        ));
        header("Location: ../../vue/profil.php");
        return $resmodification ? "Modification réussie" : "Échec de la modification";
    }


    public function suppression(User $user)
    {
        $sqlsuppression = 'DELETE FROM utilisateur WHERE id_user = :id_user';
        $reqsuppression = $this->bdd->getBdd()->prepare($sqlsuppression);
        $ressuppression = $reqsuppression->execute(array(
            'id_user' => $user->getIdUser()
        ));

        return $ressuppression ? "Suppression réussie" : "Échec de la suppression";
    }
    public function afficherUtilisateur(User $user)
    {
        $affiche = "SELECT * FROM utilisateur WHERE id_user=:idUser";
        $req = $this->bdd->getBdd()->prepare($affiche);
        $req->execute(array(
            'idUser' => $user->getIdUser()));
        return $req->fetch();
    }
}

