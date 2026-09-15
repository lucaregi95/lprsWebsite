<?php
class Utilisateur{
    protected $id_utilisateur;
    protected $nom;
    protected $prenom;

    protected $mail;
    protected $mdp;

protected $date_inscription;

protected $statut_validation;


public function __construct($id_utilisateur,$nom,$prenom,$mail,$mdp,$date_inscription,$statut_validation){
    $this->id_utilisateur = $id_utilisateur;
    $this->nom = $nom;
    $this->prenom = $prenom;
    $this->mail = $mail;
    $this->mdp = $mdp;
    $this->date_inscription = $date_inscription;
    $this->statut_validation = $statut_validation;
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

?>
