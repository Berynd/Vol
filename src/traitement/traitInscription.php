<?php

use bdd\Bdd;

include "../repository/RepositoryUtilisateur.php";
require_once "../bdd/Bdd.php";
require_once "../model/User.php";

$this->bdd = new Bdd();


$u = new User([
        "nom" => $_POST['nom'],
        "prenom" => $_POST['prenom'],
        "email" => $_POST['email'],
        "mdp" => $_POST['password'],
    ]
);
$r = new UserRepository();
$r ->inscription($u);




