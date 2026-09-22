<?php
    class Alumni extends Utilisateur{

        protected $ref_promotion;
        private $ref_entreprise;
        protected $cv;

        protected $poste_occupe;
    public function __construct($id_utilisateur,$nom, $prenom, $mail, $mdp, $date_inscription, $statut_validation,$cv, $poste_occupe, $ref_promotion, $ref_entreprise) {
        parent::__construct($id_utilisateur,$nom, $prenom, $mail, $mdp, $date_inscription, $statut_validation);
    $this->ref_promotion = $ref_promotion;
    $this->ref_entreprise = $ref_entreprise;
    $this->cv = $cv;
    $this->poste_occupe = $poste_occupe;}




    }

?>
