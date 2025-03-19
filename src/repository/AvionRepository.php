<?php

namespace repository;

use bdd\Bdd;

class AvionRepository
{
    private $bdd;
    public function __construct(){
        $this->bdd = new BDD();
    }

}