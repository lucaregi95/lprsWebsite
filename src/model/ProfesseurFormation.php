<?php

class ProfesseurFormation{

    protected $ref_professeur;
    protected  $ref_formation;

    public function __construct($ref_formation,$ref_professeur){
        $this->ref_formation = $ref_formation;
        $this->ref_professeur = $ref_professeur;
    }

    /**
     * @return mixed
     */
    public function getRefProfesseur()
    {
        return $this->ref_professeur;
    }

    /**
     * @param mixed $ref_professeur
     */
    public function setRefProfesseur($ref_professeur)
    {
        $this->ref_professeur = $ref_professeur;
    }

    /**
     * @return mixed
     */
    public function getRefFormation()
    {
        return $this->ref_formation;
    }

    /**
     * @param mixed $ref_formation
     */
    public function setRefFormation($ref_formation)
    {
        $this->ref_formation = $ref_formation;
    }

    

}

?>