<?php

namespace bdd;

use PDO;

class Bdd
{
    private $bdd;



    public function __construct()
    {
        $dbname = "ProVol";

        $dpmdp  = "root";

        $user = "root";

        $port = "8889";


        $this->bdd = new PDO('mysql:host=localhost:'.$port.'dbname=' . $dbname . ';charset=utf8',
            $user,
            $dpmdp);
    }
    public function getBdd()
    {
        return $this->bdd;
    }
}