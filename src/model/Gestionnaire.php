<?php
require_once __DIR__ . "/../../src/model/Utilisateur.php";
class Gestionnaire extends Utilisateur{

    protected $ref_utilisateur;

    public function __construct($id_utilisateur, $nom, $prenom, $mail, $mdp, $date_inscription, $statut_validation, $ref_utilisateur)
    {
        parent::__construct($id_utilisateur, $nom, $prenom, $mail, $mdp, $date_inscription, $statut_validation);
        $this->ref_utilisateur = $ref_utilisateur;

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


}
