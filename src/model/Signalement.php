<?php

class signalement{

    private $id_signalement;
    private $date;
    private $contenu;
    private $titre;
    private $ref_signale;
    private $ref_signalant;

    /**
     * @param $id_signalement
     * @param $date
     * @param $contenu
     * @param $titre
     * @param $ref_signale
     * @param $ref_signalant
     */
    public function __construct($id_signalement, $date, $contenu, $titre, $ref_signale, $ref_signalant)
    {
        $this->id_signalement = $id_signalement;
        $this->date = $date;
        $this->contenu = $contenu;
        $this->titre = $titre;
        $this->ref_signale = $ref_signale;
        $this->ref_signalant = $ref_signalant;
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
    public function getIdSignalement()
    {
        return $this->id_signalement;
    }

    /**
     * @param mixed $id_signalement
     */
    public function setIdSignalement($id_signalement)
    {
        $this->id_signalement = $id_signalement;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
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
    public function getRefSignalant()
    {
        return $this->ref_signalant;
    }

    /**
     * @param mixed $ref_signalant
     */
    public function setRefSignalant($ref_signalant)
    {
        $this->ref_signalant = $ref_signalant;
    }

    /**
     * @return mixed
     */
    public function getRefSignale()
    {
        return $this->ref_signale;
    }

    /**
     * @param mixed $ref_signale
     */
    public function setRefSignale($ref_signale)
    {
        $this->ref_signale = $ref_signale;
    }








}