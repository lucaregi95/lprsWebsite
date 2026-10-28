<?php
require_once __DIR__ . "/../../src/model/Utilisateur.php";

class Professeur extends Utilisateur{


    protected $role;

    /**
     * @param $id_utilisateur
     * @param $nom
     * @param $prenom
     * @param $email
     * @param $mdp
     * @param $date_inscription
     * @param $statut_validation
     * @param $specialite
     * @param $ref_utilisateur
     */
    public function __construct($id_utilisateur, $nom, $prenom, $email, $mdp, $date_inscription, $statut_validation, $ref_utilisateur, $specialite)
    {
        parent::__construct($id_utilisateur, $nom, $prenom, $email, $mdp, $date_inscription, $statut_validation);
        $this->specialite = $specialite;
        $this->ref_utilisateur = $ref_utilisateur;
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

    public function getRefProfesseur(){
        return $this->ref_utilisateur;
    }






}