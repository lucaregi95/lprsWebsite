<?php

class Partenaire extends Utilisateur{

    private $ref_utilisateur;
    private $poste_occupe;
    private $motif_inscription;
    private $ref_entreprise;

    /**
     * @param $ref_utilisateur
     * @param $poste_occupe
     * @param $motif_inscription
     * @param $ref_entreprise
     */
    public function __construct($id_utilisateur, $nom, $prenom, $email, $mdp, $date_inscription, $statut_validation, $ref_utilisateur, $poste_occupe, $motif_inscription, $ref_entreprise){
        parent::__construct($id_utilisateur,$nom,$prenom,$email,$mdp,$date_inscription,$statut_validation);
        $this->ref_utilisateur = $ref_utilisateur;
        $this->poste_occupe = $poste_occupe;
        $this->motif_inscription = $motif_inscription;
        $this->ref_entreprise = $ref_entreprise;
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
    public function getPosteOccupe()
    {
        return $this->poste_occupe;
    }

    /**
     * @param mixed $poste_occupe
     */
    public function setPosteOccupe($poste_occupe)
    {
        $this->poste_occupe = $poste_occupe;
    }

    /**
     * @return mixed
     */
    public function getMotifInscription()
    {
        return $this->motif_inscription;
    }

    /**
     * @param mixed $motif_inscription
     */
    public function setMotifInscription($motif_inscription)
    {
        $this->motif_inscription = $motif_inscription;
    }

    /**
     * @return mixed
     */
    public function getRefEntreprise()
    {
        return $this->ref_entreprise;
    }

    /**
     * @param mixed $ref_entreprise
     */
    public function setRefEntreprise($ref_entreprise)
    {
        $this->ref_entreprise = $ref_entreprise;
    }




}