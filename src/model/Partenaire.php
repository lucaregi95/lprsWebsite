<?php

class Partenaire extends Utilisateur{

    private $ref_partenaire;
    private $poste_occupe;
    private $motif_inscription;
    private $ref_entreprise;

    /**
     * @param $ref_partenaire
     * @param $poste_occupe
     * @param $motif_inscription
     * @param $ref_entreprise
     */
    public function __construct($id_utilisateur,$titre,$description,$mission,$salaire,$type_offre,$etat, $ref_partenaire, $poste_occupe, $motif_inscription, $ref_entreprise){
        parent::__construct($id_utilisateur,$titre,$description,$mission,$salaire,$type_offre,$etat);
        $this->ref_partenaire = $ref_partenaire;
        $this->poste_occupe = $poste_occupe;
        $this->motif_inscription = $motif_inscription;
        $this->ref_entreprise = $ref_entreprise;
    }

    /**
     * @return mixed
     */
    public function getRefPartenaire()
    {
        return $this->ref_partenaire;
    }

    /**
     * @param mixed $ref_partenaire
     */
    public function setRefPartenaire($ref_partenaire)
    {
        $this->ref_partenaire = $ref_partenaire;
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