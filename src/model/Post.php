<?php

class Post{
    private $id_post;
    private $contenu;
    private $date_post;
    private $titre;
    private $ref_utilisateur;
    private $categorie_post;

    /**
     * @param $id_post
     * @param $contenu
     * @param $date_post
     * @param $titre
     * @param $categorie_post
     * @param $ref_utilisateur
 */
    public function __construct($id_post, $contenu, $date_post, $titre, $categorie_post, $ref_utilisateur)
    {
        $this->id_post = $id_post;
        $this->contenu = $contenu;
        $this->date_post = $date_post;
        $this->titre = $titre;
        $this->categorie_post = $categorie_post;
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
    public function setIdPost($id_post)
    {
        $this->id_post = $id_post;
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
    public function getDatePost()
    {
        return $this->date_post;
    }

    /**
     * @param mixed $date_post
     */
    public function setDatePost($date_post)
    {
        $this->date_post = $date_post;
    }

    /**
     * @return mixed
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param mixed $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
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
    public function getCategoriePost()
    {
        return $this->categorie_post;
    }

    /**
     * @param mixed $categorie_post
     */
    public function setCategoriePost($categorie_post)
    {
        $this->categorie_post = $categorie_post;
    }




}