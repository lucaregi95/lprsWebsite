<?php

class Evenement{
    private $id_evenement;
    private $titre;
    private $description;
    private $lieu;
    private $nbr_places;
    private $lat;
    private $lng;

    /**
     * @param $id_evenement
     * @param $titre
     * @param $description
     * @param $lieu
     * @param $nbr_places
     */
    public function __construct($id_evenement, $titre, $description, $lieu, $nbr_places,$lat,$lng){
        $this->id_evenement = $id_evenement;
        $this->titre = $titre;
        $this->description = $description;
        $this->lieu = $lieu;
        $this->nbr_places = $nbr_places;
        $this->lat = $lat;
        $this->lng = $lng;
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

    /**
     * @return mixed
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param mixed $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return mixed
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @param mixed $lng
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    }




}