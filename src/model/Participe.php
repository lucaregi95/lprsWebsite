<?php

class Participe{

    private $id_participe;
    private $est_orga;
    private $ref_utilisateur;
    private $ref_evenement;

    /**
     * @param $id_participe
     * @param $est_orga
     * @param $ref_utilisateur
     * @param $ref_evenement
     */
    public function __construct($id_participe, $est_orga, $ref_utilisateur, $ref_evenement){
        $this->id_participe = $id_participe;
        $this->est_orga = $est_orga;
        $this->ref_utilisateur = $ref_utilisateur;
        $this->ref_evenement = $ref_evenement;
    }

    /**
     * @return mixed
     */
    public function getIdParticipe()
    {
        return $this->id_participe;
    }

    /**
     * @param mixed $id_participe
     */
    public function setIdParticipe($id_participe)
    {
        $this->id_participe = $id_participe;
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

    /**
     * @return mixed
     */
    public function getRefUtilisateur()
    {
        return $this->ref_utilisateur;
    }

    /**
     * @param mixed $ref_utilisateur
     */
    public function setRefUtilisateur($ref_utilisateur)
    {
        $this->ref_utilisateur = $ref_utilisateur;
    }

    /**
     * @return mixed
     */
    public function getRefEvenement()
    {
        return $this->ref_evenement;
    }

    /**
     * @param mixed $ref_evenement
     */
    public function setRefEvenement($ref_evenement)
    {
        $this->ref_evenement = $ref_evenement;
    }






}