<?php

class Offre{

    private $id_offre;
    private $titre;
    private $description;
    private $mission;
    private $salaire;
    private $type_offre;
    private $etat;

    /**
     * @param $id_offre
     * @param $titre
     * @param $description
     * @param $mission
     * @param $salaire
     * @param $type_offre
     * @param $etat
     */
    public function __construct($id_offre, $titre, $description, $mission, $salaire, $type_offre, $etat, $ref_entreprise)
    {
        $this->id_offre = $id_offre;
        $this->titre = $titre;
        $this->description = $description;
        $this->mission = $mission;
        $this->salaire = $salaire;
        $this->type_offre = $type_offre;
        $this->etat = $etat;
        $this->ref_entreprise = $ref_entreprise;
    }

    /**
     * @return mixed
     */
    public function getIdOffre()
    {
        return $this->id_offre;
    }

    /**
     * @param mixed $id_offre
     */
    public function setIdOffre($id_offre)
    {
        $this->id_offre = $id_offre;
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
    public function getMission()
    {
        return $this->mission;
    }

    /**
     * @param mixed $mission
     */
    public function setMission($mission)
    {
        $this->mission = $mission;
    }

    /**
     * @return mixed
     */
    public function getSalaire()
    {
        return $this->salaire;
    }

    /**
     * @param mixed $salaire
     */
    public function setSalaire($salaire)
    {
        $this->salaire = $salaire;
    }

    /**
     * @return mixed
     */
    public function getTypeOffre()
    {
        return $this->type_offre;
    }

    /**
     * @param mixed $type_offre
     */
    public function setTypeOffre($type_offre)
    {
        $this->type_offre = $type_offre;
    }

    /**
     * @return mixed
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param mixed $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return mixed
     */
    public function getRefEntreprise()
    {
        return $this->ref_entreprise;
    }

    /**
     * @param mixed $ref_entreprise
     */
    public function setRefEntreprise($ref_entreprise)
    {
        $this->ref_entreprise = $ref_entreprise;
    }




}