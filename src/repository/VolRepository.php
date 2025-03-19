<?php

namespace repository;

use bdd\Bdd;

class VolRepository
{
    private $bdd;
    public function __construct(){
        $this->bdd = new BDD();
    }

}