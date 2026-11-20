<?php

require_once __DIR__ . "/../../bdd/bdd.php";
require_once __DIR__ . "/../model/OffreUtilisateur.php";
Class OffreUtilisateurRepository{
    private $connexionBdd;
    public function __construct()
    {
        $this->connexionBdd = (new Bdd())->getConnexionBdd();
    }

    public function getOffreUtilisateur($ref_utilisateur, $ref_offre){
        $sql = "SELECT * FROM offreutilisateur WHERE ref_utilisateur = :ref_utilisateur AND ref_offre = :ref_offre";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $ref_utilisateur);
        $req->bindValue(':ref_offre', $ref_offre);
        $req->execute();
        $result = $req->fetch(PDO::FETCH_ASSOC);

        if ($result === false) {
            return null; // aucune candidature / aucun lien pour cette offre
        }

        return new OffreUtilisateur($result['ref_offre'], $result['ref_utilisateur'], $result['est_orga']);
    }

    public function getAllOffreUtilisateur(){
        $sql = "SELECT * FROM offreutilisateur";
        $req = $this->connexionBdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $tabOu=array();
        foreach($result as $results){
            $oU = new OffreUtilisateur($results['ref_offre'],$results['ref_utilisateur'],$results['est_orga']);
        $tabOu[]= $oU;
        }
        return $tabOu;
    }

    public function ajouterOffreUtilisateur(OffreUtilisateur $oU){
        $sql = "INSERT INTO offreutilisateur (ref_offre,ref_utilisateur,est_orga) VALUES (:ref_offre,:ref_utilisateur,:est_orga)";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':ref_offre', $oU->getIdOffre());
        $req->bindValue(':ref_utilisateur', $oU->getIdOffre());
        $req->bindValue(':est_orga', $oU->getEstOrga());
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
