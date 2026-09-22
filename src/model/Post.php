<?php


class Post{
    private $id_post;
    private $contenu;
    private $datetime;
    private $ref_utilisateur;

    /**
     * @param $id_post
     * @param $contenu
     * @param $datetime
     * @param $ref_utilisateur
     */
    public function __construct($id_post, $contenu, $datetime, $ref_utilisateur)
    {
        $this->id_post = $id_post;
        $this->contenu = $contenu;
        $this->datetime = $datetime;
        $this->ref_utilisateur = $ref_utilisateur;
    }

    /**
     * @return mixed
     */
    public function getIdPost()
    {
        return $this->id_post;
    }

    /**
     * @param mixed $id_post
     */
    public function setId($id_post)
    {
        $this->id = $id_post;
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
    public function getDateTime()
    {
        return $this->datetime;
    }

    /**
     * @param mixed $dateTime
     */
    public function setDateTime($datetime)
    {
        $this->datetime = $datetime;
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