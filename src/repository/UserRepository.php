<?php

namespace repository;

use bdd\Bdd;

class UserRepository
{
    private $bdd;
    public function __construct(){
        $this->bdd = new BDD();
    }

}