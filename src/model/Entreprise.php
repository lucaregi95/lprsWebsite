<?php

class Entreprise{

    private $id_entreprise;
    private $adresse;
    private $nom_entreprise;

    private $site_web;

    /**
     * @param $id_entreprise
     * @param $adresse
     * @param $nom_entreprise
     * @param $site_web
     */
    public function __construct($id_entreprise, $adresse, $nom_entreprise, $site_web)
    {
        $this->id_entreprise = $id_entreprise;
        $this->adresse = $adresse;
        $this->nom_entreprise = $nom_entreprise;
        $this->site_web = $site_web;
    }

    /**
     * @return mixed
     */
    public function getIdEntreprise()
    {
        return $this->id_entreprise;
    }

    /**
     * @param mixed $id_entreprise
     */
    public function setIdEntreprise($id_entreprise)
    {
        $this->id_entreprise = $id_entreprise;
    }

    /**
     * @return mixed
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param mixed $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return mixed
     */
    public function getNomEntreprise()
    {
        return $this->nom_entreprise;
    }

    /**
     * @param mixed $nom_entreprise
     */
    public function setNomEntreprise($nom_entreprise)
    {
        $this->nom_entreprise = $nom_entreprise;
    }

    /**
     * @return mixed
     */
    public function getSiteWeb()
    {
        return $this->site_web;
    }

    /**
     * @param mixed $site_web
     */
    public function setSiteWeb($site_web)
    {
        $this->site_web = $site_web;
    }




}