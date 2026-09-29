<?php
    class Alumni extends Utilisateur
    {

        protected $ref_utilisateur;
        protected $cv;
        protected $poste_occupe;
        protected $ref_promotion;
        protected $ref_entreprise;


            public function __construct($ref_utilisateur, $cv, $poste_occupe, $id_utilisateur, $nom, $prenom, $mail, $mdp, $date_inscription, $statut_validation, $ref_promotion, $ref_entreprise)
            {
                parent::__construct($id_utilisateur, $nom, $prenom, $mail, $mdp, $date_inscription, $statut_validation);
                $this->cv = $cv;
                $this->poste_occupe = $poste_occupe;
                $this->ref_promotion = $ref_promotion;
                $this->ref_entreprise = $ref_entreprise;
                $this->ref_utilisateur = $ref_utilisateur;
            }

            /**
             * @return mixed
             */
            public
            function getCv()
            {
                return $this->cv;
            }

            /**
             * @param mixed $cv
             */
            public
            function setCv($cv)
            {
                $this->cv = $cv;
            }

            /**
             * @return mixed
             */
            public
            function getRefUtilisateur()
            {
                return $this->ref_utilisateur;
            }

            /**
             * @param mixed $ref_utilisateur
             */
            public
            function setRefUtilisateur($ref_utilisateur)
            {
                $this->ref_utilisateur = $ref_utilisateur;
            }

            /**
             * @return mixed
             */
            public
            function getRefEntreprise()
            {
                return $this->ref_entreprise;
            }

            /**
             * @param mixed $ref_entreprise
             */
            public
            function setRefEntreprise($ref_entreprise)
            {
                $this->ref_entreprise = $ref_entreprise;
            }

            /**
             * @return mixed
             */
            public
            function getRefPromotion()
            {
                return $this->ref_promotion;
            }

            /**
             * @param mixed $ref_promotion
             */
            public
            function setRefPromotion($ref_promotion)
            {
                $this->ref_promotion = $ref_promotion;
            }

            /**
             * @return mixed
             */
            public
            function getPosteOccupe()
            {
                return $this->poste_occupe;
            }

            /**
             * @param mixed $poste_occupe
             */
            public
            function setPosteOccupe($poste_occupe)
            {
                $this->poste_occupe = $poste_occupe;
            }


        }

?>
