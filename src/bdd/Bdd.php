<?php

namespace bdd;

use PDO;
use PDOException;

class Bdd
{
    private $bdd;

    public function __construct()
    {
        try {
            $dbname = "ProVol";
            $user = "root";
            $password = "root";
            $host = "localhost";
            $port = "8889";

            $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";

            $this->bdd = new PDO($dsn, $user, $password);
            $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion à la BDD : " . $e->getMessage());
        }
    }

    public function getBdd(): PDO
    {
        return $this->bdd;
    }
}