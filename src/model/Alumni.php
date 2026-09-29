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

        /**
         * @return mixed
         */
        public function getRefPromotion()
        {
            return $this->ref_promotion;
        }

        /**
         * @param mixed $ref_promotion
         */
        public function setRefPromotion($ref_promotion)
        {
            $this->ref_promotion = $ref_promotion;
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

        /**
         * @return mixed
         */
        public function getCV()
        {
            return $this->cv;
        }

        /**
         * @param mixed $cv
         */
        public function setCV($cv)
        {
            $this->cv = $cv;
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




    }

?>
