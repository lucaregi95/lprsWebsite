<?php

class Etudiant extends Utilisateur{

    private $ref_utilisateur;
    private $cv;
    private $ref_promotion;
    private $ref_formation;

    /**
     * @param $ref_utilisateur
     * @param $cv
     * @param $ref_promotion
     * @param $ref_formation
     */
    public function __construct($id_utilisateur,$nom,$prenom,$email,$mdp,$date_inscription,$statut_validation, $ref_utilisateur, $cv, $ref_formation, $ref_promotion){
        parent::__construct($id_utilisateur,$nom,$prenom,$email,$mdp,$date_inscription,$statut_validation);
        $this->ref_utilisateur = $ref_utilisateur;
        $this->cv = $cv;
        $this->ref_formation = $ref_formation;
        $this->ref_promotion = $ref_promotion;
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
    public function getCv()
    {
        return $this->cv;
    }

    /**
     * @param mixed $cv
     */
    public function setCv($cv)
    {
        $this->cv = $cv;
    }

    /**
     * @return mixed
     */
    public function getRefPromotion()
    {
        return $this->ref_promotion;
    }

    /**
     * @param mixed $ref_promotion
     */
    public function setRefPromotion($ref_promotion)
    {
        $this->ref_promotion = $ref_promotion;
    }

    /**
     * @return mixed
     */
    public function getRefFormation()
    {
        return $this->ref_formation;
    }

    /**
     * @param mixed $ref_formation
     */
    public function setRefFormation($ref_formation)
    {
        $this->ref_formation = $ref_formation;
    }





}