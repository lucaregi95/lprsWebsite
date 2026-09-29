<?php

class Etudiant extends Utilisateur{

    private $ref_etudiant;
    private $cv;

    /**
     * @param $ref_etudiant
     * @param $cv
     */
    public function __construct($id_utilisateur,$titre,$description,$missions,$salaire,$type_offre,$etat, $ref_etudiant, $cv){
        parent::__construct($id_utilisateur,$titre,$description,$missions,$salaire,$type_offre,$etat);
        $this->ref_etudiant = $ref_etudiant;
        $this->cv = $cv;
    }

    /**
     * @return mixed
     */
    public function getRefEtudiant()
    {
        return $this->ref_etudiant;
    }

    /**
     * @param mixed $ref_etudiant
     */
    public function setRefEtudiant($ref_etudiant)
    {
        $this->ref_etudiant = $ref_etudiant;
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




}