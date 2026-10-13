<?php

class ProfesseurFormation
{

    protected $id_pF;
    protected $ref_professeur;
    protected $ref_formation;

    /**
     * @param $id_pF
     * @param $ref_professeur
     * @param $ref_formation
     */
    public function __construct($id_pF, $ref_professeur, $ref_formation)
    {
        $this->id_pF = $id_pF;
        $this->ref_professeur = $ref_professeur;
        $this->ref_formation = $ref_formation;
    }

    /**
     * @return mixed
     */
    public function getIdPf(){
        return $this->id_pF;
    }

    /**
     * @param mixed $id_pF
     */
    public function setIdPF($id_pF)
    {
        $this->id_pF = $id_pF;
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