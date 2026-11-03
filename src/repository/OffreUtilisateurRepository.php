<?php

Class OffreUtilisateurRepository{
    private $connexionBdd;
    public function __construct()
    {
        $this->connexionBdd = (new Bdd())->getConnexionBdd();
    }

    public function getOffreUtilisateur($id_oU){
        $sql = "SELECT * FROM offreutilisateur WHERE id_oU = :id_oU ";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':id_oU', $id_oU);
        $req->execute();
        $result = $req->fetch();
        $oU = new OffreUtilisateur($result['id_oU'],$result['ref_offre'],$result['ref_utilisateur']);
        return $oU;

    }

    public function getAllOffreUtilisateur(){
        $sql = "SELECT * FROM offreutilisateur";
        $req = $this->connexionBdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $tabOu=array();
        foreach($result as $results){
            $oU = new OffreUtilisateur($results['id_oU'],$results['ref_offre'],$results['ref_utilisateur']);
        $tabOu[]= $oU;
        }
        return $tabOu;
    }



}
