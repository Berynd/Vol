<?php

class Reservation
{
    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {

            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method)) {

                $this->$method($value);
            }
        }
    }
private $idReservation;


    /**
     * @return mixed
     */
    public function getIdReservation()
    {
        return $this->idReservation;
    }

    /**
     * @param mixed $idReservation
     */
    public function setIdReservation($idReservation)
    {
        $this->idReservation = $idReservation;
    }

    /**
     * @return mixed
     */
    public function getDateReservation()
    {
        return $this->dateReservation;
    }

    /**
     * @param mixed $dateReservation
     */
    public function setDateReservation($dateReservation)
    {
        $this->dateReservation = $dateReservation;
    }

    /**
     * @return mixed
     */
    public function getRefUser()
    {
        return $this->refUser;
    }

    /**
     * @param mixed $refUser
     */
    public function setRefUser($refUser)
    {
        $this->refUser = $refUser;
    }

    /**
     * @return mixed
     */
    public function getRefvol()
    {
        return $this->refvol;
    }

    /**
     * @param mixed $refvol
     */
    public function setRefvol($refvol)
    {
        $this->refvol = $refvol;
    }
private $dateReservation;
private $refUser;
private $refvol;
}