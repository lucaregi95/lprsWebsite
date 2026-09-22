<?php

class Professeur extends Utilisateur{


    private $specialite;

    /**
     * @param $id_utilisateur
     * @param $nom
     * @param $prenom
     * @param $email
     * @param $mdp
     * @param $date_inscription
     * @param $statut_validation
     * @param $specialite
     */
    public function __construct($id_utilisateur, $nom, $prenom, $email, $mdp, $date_inscription, $statut_validation, $specialite)
    {
        parent::__construct($id_utilisateur, $nom, $prenom, $email, $mdp, $date_inscription, $statut_validation);
        $this->specialite = $specialite;
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