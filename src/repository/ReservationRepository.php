<?php

namespace repository;

use bdd\Bdd;

class ReservationRepository
{
    private $bdd;
    public function __construct(){
        $this->bdd = new BDD();
    }

}