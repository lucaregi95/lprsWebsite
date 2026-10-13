<?php

class Post{
    private $id_post;
    private $contenu;
    private $date_sujet;
    private $titre;
    private $ref_utilisateur;
    private $categorie_sujet;

    /**
     * @param $id_post
     * @param $contenu
     * @param $date_sujet
     * @param $titre
     * @param $ref_utilisateur
     * @param $categorie_sujet
     */
    public function __construct($id_post, $contenu, $date_sujet, $titre, $ref_utilisateur, $categorie_sujet)
    {
        $this->id_post = $id_post;
        $this->contenu = $contenu;
        $this->date_sujet = $date_sujet;
        $this->titre = $titre;
        $this->ref_utilisateur = $ref_utilisateur;
        $this->categorie_sujet = $categorie_sujet;
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
    public function getDateSujet()
    {
        return $this->date_sujet;
    }

    /**
     * @param mixed $date_sujet
     */
    public function setDateSujet($date_sujet)
    {
        $this->date_sujet = $date_sujet;
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
    public function getCategorieSujet()
    {
        return $this->categorie_sujet;
    }

    /**
     * @param mixed $categorie_sujet
     */
    public function setCategorieSujet($categorie_sujet)
    {
        $this->categorie_sujet = $categorie_sujet;
    }




}