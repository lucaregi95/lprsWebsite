<?php

class Formation{

    private $id_formation;
    private $nom_formation;

    /**
     * @param $id_formation
     * @param $nom_formation
     */
    public function __construct($id_formation, $nom_formation)
    {
        $this->id_formation = $id_formation;
        $this->nom_formation = $nom_formation;
    }

    /**
     * @return mixed
     */
    public function getIdFormation()
    {
        return $this->id_formation;
    }

    /**
     * @param mixed $id_formation
     */
    public function setIdFormation($id_formation)
    {
        $this->id_formation = $id_formation;
    }

    /**
     * @return mixed
     */
    public function getNomFormation()
    {
        return $this->nom_formation;
    }

    /**
     * @param mixed $nom_formation
     */
    public function setNomFormation($nom_formation)
    {
        $this->nom_formation = $nom_formation;
    }



}