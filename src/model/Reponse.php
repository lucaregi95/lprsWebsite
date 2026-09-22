<?php

class Reponse{

    private $id_reponse;
    private $contenu;
    private $datetime_reponse;
    private $ref_utilisateur;
    private $ref_post;

    /**
     * @param $id_reponse
     * @param $contenu
     * @param $datetime_reponse
     * @param $ref_utilisateur
     * @param $ref_post
     */
    public function __construct($id_reponse, $contenu, $datetime_reponse, $ref_utilisateur, $ref_post)
    {
        $this->id_reponse = $id_reponse;
        $this->contenu = $contenu;
        $this->datetime_reponse = $datetime_reponse;
        $this->ref_utilisateur = $ref_utilisateur;
        $this->ref_post = $ref_post;
    }

    /**
     * @return mixed
     */
    public function getIdReponse()
    {
        return $this->id_reponse;
    }

    /**
     * @param mixed $id_reponse
     */
    public function setIdReponse($id_reponse)
    {
        $this->id_reponse = $id_reponse;
    }

    /**
     * @return mixed
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * @param mixed $contenu
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    }

    /**
     * @return mixed
     */
    public function getDatetimeReponse()
    {
        return $this->datetime_reponse;
    }

    /**
     * @param mixed $datetime_reponse
     */
    public function setDatetimeReponse($datetime_reponse)
    {
        $this->datetime_reponse = $datetime_reponse;
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

    /**
     * @return mixed
     */
    public function getRefPost()
    {
        return $this->ref_post;
    }

    /**
     * @param mixed $ref_post
     */
    public function setRefPost($ref_post)
    {
        $this->ref_post = $ref_post;
    }



}