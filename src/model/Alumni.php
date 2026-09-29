<?php
    class Alumni extends Utilisateur{

        protected $ref_utilisateur;
        protected $cv;

        protected $poste_occupe;
    public function __construct($ref_utilisateur,$cv, $poste_occupe ,$id_utilisateur,$nom, $prenom, $mail, $mdp, $date_inscription, $statut_validation) {
        parent::__construct($id_utilisateur,$nom, $prenom, $mail, $mdp, $date_inscription, $statut_validation);
    $this->ref_utilisateur = $ref_utilisateur;
    $this->cv = $cv;
    $this->poste_occupe = $poste_occupe;}




    }

?>
