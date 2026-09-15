<?php

class Promotion{
    private $id_promotion;
    private $annee;

    /**
     * @param $id_promotion
     * @param $annee
     */
    public function __construct($id_promotion, $annee)
    {
        $this->id_promotion = $id_promotion;
        $this->annee = $annee;
    }

    /**
     * @return mixed
     */
    public function getIdPromotion()
    {
        return $this->id_promotion;
    }

    /**
     * @param mixed $id_promotion
     */
    public function setIdPromotion($id_promotion)
    {
        $this->id_promotion = $id_promotion;
    }

    /**
     * @return mixed
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * @param mixed $annee
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;
    }


}