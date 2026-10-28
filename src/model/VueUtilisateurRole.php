<?php
require_once __DIR__ . "/../../src/model/Utilisateur.php";

class VueUtilisateurRole extends Utilisateur{


    protected $role;

    /**
     * @param $id_utilisateur
     * @param $nom
     * @param $prenom
     * @param $email
     * @param $mdp
     * @param $date_inscription
     * @param $statut_validation
     * @param $role
     */
    public function __construct($id_utilisateur, $nom, $prenom, $email, $mdp, $date_inscription, $statut_validation, $role)
    {
        parent::__construct($id_utilisateur, $nom, $prenom, $email, $mdp, $date_inscription, $statut_validation);
        $this->role = $role;
    }



    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }










}