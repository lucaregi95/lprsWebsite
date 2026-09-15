<?php

class Professeur extends Utilisateur{

    private $ref_professeur;

    private $specialite;

    /**
     * @param $ref_professeur
     * @param $specialite
     */
    public function __construct($id_utilisateur,$titre,$description,$missions,$salaire,$type_offre,$etat,$ref_professeur, $specialite){
        parent::__construct($id_utilisateur,$titre,$description,$missions,$salaire,$type_offre,$etat);

        $this->ref_professeur = $ref_professeur;
        $this->specialite = $specialite;
    }

    /**
     * @return mixed
     */
    public function getRefProfesseur()
    {
        return $this->ref_professeur;
    }

    /**
     * @param mixed $ref_professeur
     */
    public function setIdProfesseur($ref_professeur)
    {
        $this->ref_professeur = $ref_professeur;
    }

    /**
     * @return mixed
     */
    public function getSpecialite()
    {
        return $this->specialite;
    }

    /**
     * @param mixed $specialite
     */
    public function setSpecialite($specialite)
    {
        $this->specialite = $specialite;
    }




}