<?php

Class OffreUtilisateur{

    private $id_oU;
    private $id_offre;
    private $id_utilisateur;

    /**
     * @param $id_oU
     * @param $id_offre
     * @param $id_utilisateur
     */
    public function __construct($id_oU, $id_offre, $id_utilisateur)
    {
        $this->id_oU = $id_oU;
        $this->id_offre = $id_offre;
        $this->id_utilisateur = $id_utilisateur;
    }

    /**
     * @return mixed
     */
    public function getIdOU()
    {
        return $this->id_oU;
    }

    /**
     * @param mixed $id_oU
     */
    public function setIdOU($id_oU)
    {
        $this->id_oU = $id_oU;
    }

    /**
     * @return mixed
     */
    public function getIdOffre()
    {
        return $this->id_offre;
    }

    /**
     * @param mixed $id_offre
     */
    public function setIdOffre($id_offre)
    {
        $this->id_offre = $id_offre;
    }

    /**
     * @return mixed
     */
    public function getIdUtilisateur()
    {
        return $this->id_utilisateur;
    }

    /**
     * @param mixed $id_utilisateur
     */
    public function setIdUtilisateur($id_utilisateur)
    {
        $this->id_utilisateur = $id_utilisateur;
    }




}