<?php

class Reponse{

    private $id_reponse;
    private $contenu;
    private $date_reponse;
    private $ref_inscrit;
    private $ref_sujet;

    /**
     * @param $id_reponse
     * @param $contenu
     * @param $date_reponse
     * @param $ref_inscrit
     * @param $ref_sujet
     */
    public function __construct($id_reponse, $contenu, $date_reponse, $ref_inscrit, $ref_sujet)
    {
        $this->id_reponse = $id_reponse;
        $this->contenu = $contenu;
        $this->date_reponse = $date_reponse;
        $this->ref_inscrit = $ref_inscrit;
        $this->ref_sujet = $ref_sujet;
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
    public function getDateReponse()
    {
        return $this->date_reponse;
    }

    /**
     * @param mixed $date_reponse
     */
    public function setDateReponse($date_reponse)
    {
        $this->date_reponse = $date_reponse;
    }

    /**
     * @return mixed
     */
    public function getRefInscrit()
    {
        return $this->ref_inscrit;
    }

    /**
     * @param mixed $ref_inscrit
     */
    public function setRefInscrit($ref_inscrit)
    {
        $this->ref_inscrit = $ref_inscrit;
    }

    /**
     * @return mixed
     */
    public function getRefSujet()
    {
        return $this->ref_sujet;
    }

    /**
     * @param mixed $ref_sujet
     */
    public function setRefSujet($ref_sujet)
    {
        $this->ref_sujet = $ref_sujet;
    }




}