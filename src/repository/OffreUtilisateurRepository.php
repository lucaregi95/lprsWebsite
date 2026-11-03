<?php

Class OffreUtilisateurRepository{
    private $connexionBdd;
    public function __construct()
    {
        $this->connexionBdd = (new Bdd())->getConnexionBdd();
    }

    public function getOffreUtilisateur($id){
        $sql = "SELECT * FROM offreutilisateur WHERE ref_utilisateur = :ref_utilisateur and ref_offre=:ref_offre ";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $id);
        $req->execute();
        $result = $req->fetch();
        $oU = new OffreUtilisateur($result['ref_offre'],$result['ref_utilisateur']);
        return $oU;

    }

    public function getAllOffreUtilisateur(){
        $sql = "SELECT * FROM offreutilisateur";
        $req = $this->connexionBdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $tabOu=array();
        foreach($result as $results){
            $oU = new OffreUtilisateur($results['ref_offre'],$results['ref_utilisateur']);
        $tabOu[]= $oU;
        }
        return $tabOu;
    }

    public function ajouterOffreUtilisateur(OffreUtilisateur $oU){
        $sql = "INSERT INTO offreutilisateur (ref_offre,ref_utilisateur) VALUES (:ref_offre,:ref_utilisateur)";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':ref_offre', $oU->getIdOffre());
        $req->bindValue(':ref_utilisateur', $oU->getIdOffre());
        $req -> execute();
    }

    public function supprimerOffreUtilisateur($oU){
        $sql = "DELETE FROM offreutilisateur WHERE ref_offre = :ref_offre AND ref_utilisateur = :ref_utilisateur";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':ref_offre', $oU);
        $req->bindValue(':ref_utilisateur',$oU);
        $req->execute();
    }





}
