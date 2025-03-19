<?php

class Vol
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
private $idVol;

    /**
     * @return mixed
     */
    public function getIdVol()
    {
        return $this->idVol;
    }

    /**
     * @param mixed $idVol
     */
    public function setIdVol($idVol)
    {
        $this->idVol = $idVol;
    }

    /**
     * @return mixed
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param mixed $destination
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
    }

    /**
     * @return mixed
     */
    public function getHeureDepart()
    {
        return $this->heureDepart;
    }

    /**
     * @param mixed $heureDepart
     */
    public function setHeureDepart($heureDepart)
    {
        $this->heureDepart = $heureDepart;
    }

    /**
     * @return mixed
     */
    public function getHeureArriver()
    {
        return $this->heureArriver;
    }

    /**
     * @param mixed $heureArriver
     */
    public function setHeureArriver($heureArriver)
    {
        $this->heureArriver = $heureArriver;
    }

    /**
     * @return mixed
     */
    public function getRefAvion()
    {
        return $this->refAvion;
    }

    /**
     * @param mixed $refAvion
     */
    public function setRefAvion($refAvion)
    {
        $this->refAvion = $refAvion;
    }
private $destination;
private $heureDepart;
private $heureArriver;
private $refAvion;
}