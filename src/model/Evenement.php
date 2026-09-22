<?php

class Evenement{
    private $id_evenement;
    private $titre;
    private $description;
    private $lieu;
    private $element_requis;
    private $nbr_places;

    /**
     * @param $id_evenement
     * @param $titre
     * @param $description
     * @param $lieu
     * @param $element_requis
     * @param $nbr_places
     */
    public function __construct($id_evenement, $titre, $description, $lieu, $element_requis, $nbr_places)
    {
        $this->id_evenement = $id_evenement;
        $this->titre = $titre;
        $this->description = $description;
        $this->lieu = $lieu;
        $this->element_requis = $element_requis;
        $this->nbr_places = $nbr_places;
    }

    /**
     * @return mixed
     */
    public function getIdEvenement()
    {
        return $this->id_evenement;
    }

    /**
     * @param mixed $id_evenement
     */
    public function setIdEvenement($id_evenement)
    {
        $this->id_evenement = $id_evenement;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * @param mixed $lieu
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;
    }

    /**
     * @return mixed
     */
    public function getElementRequis()
    {
        return $this->element_requis;
    }

    /**
     * @param mixed $element_requis
     */
    public function setElementRequis($element_requis)
    {
        $this->element_requis = $element_requis;
    }

    /**
     * @return mixed
     */
    public function getNbrPlaces()
    {
        return $this->nbr_places;
    }

    /**
     * @param mixed $nbr_places
     */
    public function setNbrPlaces($nbr_places)
    {
        $this->nbr_places = $nbr_places;
    }




}