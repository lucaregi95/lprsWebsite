<?php

class Professeur extends Utilisateur{

    protected $id_utilisateur;
    protected $nom;
    protected $prenom;
    protected $email;
    protected $mdp;
    protected $date_inscription;
    protected $statut_validation;
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

    /**
     * @return mixed
     */
    public function getIdUtilisateur()
    {
        return $this->id_utilisateur;
    }

    /**
     * @param mixed $id_utilisateur
     */
    public function setIdUtilisateur($id_utilisateur)
    {
        $this->id_utilisateur = $id_utilisateur;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getMdp()
    {
        return $this->mdp;
    }

    /**
     * @param mixed $mdp
     */
    public function setMdp($mdp)
    {
        $this->mdp = $mdp;
    }

    /**
     * @return mixed
     */
    public function getDateInscription()
    {
        return $this->date_inscription;
    }

    /**
     * @param mixed $date_inscription
     */
    public function setDateInscription($date_inscription)
    {
        $this->date_inscription = $date_inscription;
    }

    /**
     * @return mixed
     */
    public function getStatutValidation()
    {
        return $this->statut_validation;
    }

    /**
     * @param mixed $statut_validation
     */
    public function setStatutValidation($statut_validation)
    {
        $this->statut_validation = $statut_validation;
    }

    



}