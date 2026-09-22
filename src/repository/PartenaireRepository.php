<?php
class PartenaireRepository{

    private $connexionbdd;

    public function __construct(){
        $this->connexionbdd = (new Bdd())->getConnexionBdd();
    }

    public function getPartenaire($ref_utilisateur){
        $sql = "SELECT * FROM partenaire WHERE ref_utilisateur = :ref_utilisateur";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':ref_utisateur', $ref_utilisateur);
        $req->execute();
        $result = $req->fetch();
        $partenaire = new Partenaire($result["ref_utilisateur"],$result["poste_occupe"], $result["motif_inscription"], $result["ref_entreprise"]);
        return $partenaire;
    }

    public function getPartenaires(){ // a verifier pluriel ou pas dans tous les fichies
        $sql = "SELECT * FROM partenaire";
        $req = $this->connexionbdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $tabPartenaire = array();
        foreach ($result as $results) {
            $tabPartenaire[] = new Partenaire($results["ref_utilisateur]"],$results["poste_occupe"], $result["motif_inscription"], $result["ref_entreprise"]);
        }
        return $tabPartenaire;
    }


    public function ajoutOffre(Partenaire $partenaire){
        $sql="INSERT INTO partenaire VALUES (:ref_utilisateur,:poste_occupe, :motif_inscription, :ref_entreprise)";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $partenaire-> getRefPartenaire());;
        $req->bindValue(":poste_occupe",$partenaire-> getPosteOccupe());
        $req->bindValue(":motif_inscription",$partenaire-> getMotifInscription());
        $req->bindValue(":ref_entreprise",$partenaire-> getRefEntreprise());
        $req->execute();
    }

    public function modifierOffre(Partenaire $partenaire){
        $sql="UPDATE partenaire SET ref_utilisateur = :ref_utilisateur, poste_occupe = :poste_occupe, motif_inscription = :motif_inscription, ref_entreprise = :ref_entreprise WHERE ref_utilisateur = :ref_utisateur";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $partenaire-> getRefPartenaire());
        $req->bindValue(':poste_occupe', $partenaire-> getPosteOccupe());
        $req->bindValue(':motif_inscription', $partenaire-> getMotifInscription());
        $req->bindValue(':ref_entreprise', $partenaire-> getRefEntreprise());
        $req->execute();

    }
}