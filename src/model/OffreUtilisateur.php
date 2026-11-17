<?php

Class OffreUtilisateur{

    private $id_offre;
    private $id_utilisateur;

    private $est_orga;

    /**
     * @param $id_offre
     * @param $id_utilisateur
     */
    public function __construct( $id_offre, $id_utilisateur,$est_orga)
    {
        $this->id_offre = $id_offre;
        $this->id_utilisateur = $id_utilisateur;
        $this->est_orga=$est_orga;
    }

    /**
     * @return mixed
     */


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

    /**
     * @return mixed
     */
    public function getEstOrga()
    {
        return $this->est_orga;
    }

    /**
     * @param mixed $est_orga
     */
    public function setEstOrga($est_orga)
    {
        $this->est_orga = $est_orga;
    }





}