<?php
include "../repository/UserRepository.php";
require_once "../bdd/Bdd.php";
require_once "../modele/User.php";
if (empty($_POST["email"]) ||
    empty($_POST["mdp"]) )
{
    echo "agrougrouuuagrouu";
    header("Location: ../../vue/connexion.php");
} else {
    $user = new User(array(
        'email' => $_POST['email'],
        'mdp' => $_POST['mdp'],
    ));
    var_dump($user);
    $repository = new UserRepository();
    $resultat = $repository->connexion($user);
    var_dump($resultat);
    if ($resultat != null) {
        session_start();
        $_SESSION['userConnecte']=[
            "userPrenom" => $resultat->getPrenom(),
            "idUtilisateur" => $resultat->getIdUser(),
            "role" => $resultat->getRole()
        ];
        header("Location: ../../index.php");
    } else {
        header("Location: ../../index.php");
        echo "<h3>erreur";
    }

}