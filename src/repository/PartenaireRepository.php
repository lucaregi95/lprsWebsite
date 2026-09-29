<?php
class PartenaireRepository{

    private $connexionBdd;

    public function __construct(){
        $this->connexionBdd = (new Bdd())->getConnexionBdd();
    }

    public function getPartenaire($ref_utilisateur){
        $sql = "SELECT u.* , p. ref_professeur FROM utilisateur u INNER JOIN  professeur p ON id_utilisateur = ref_utilisateur";
        $reqProfesseur = $this->connexionBdd->prepare($sql);
        $reqProfesseur->execute();
        $professeur = $reqProfesseur->fetchAll();
        return $professeur;
    }

    public function getParenaire() {
        $sql = "SELECT u.*, p.* FROM utilisateur u INNER JOIN professeur p ON u.id_utilisateur = p.ref_utilisateur";
        $req = $this->connexionBdd->query($sql);
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }



    public function ajoutOffre(Partenaire $partenaire){
        $sql="INSERT INTO partenaire VALUES (:ref_utilisateur,:poste_occupe, :motif_inscription, :ref_entreprise)";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $partenaire-> getRefPartenaire());;
        $req->bindValue(":poste_occupe",$partenaire-> getPosteOccupe());
        $req->bindValue(":motif_inscription",$partenaire-> getMotifInscription());
        $req->bindValue(":ref_entreprise",$partenaire-> getRefEntreprise());
        $req->execute();
    }

    public function modifierOffre(Partenaire $partenaire){
        $sql="UPDATE partenaire SET ref_utilisateur = :ref_utilisateur, poste_occupe = :poste_occupe, motif_inscription = :motif_inscription, ref_entreprise = :ref_entreprise WHERE id_partenaire = :id_partenaire";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $partenaire-> getRefPartenaire());
        $req->bindValue(':poste_occupe', $partenaire-> getPosteOccupe());
        $req->bindValue(':motif_inscription', $partenaire-> getMotifInscription());
        $req->bindValue(':ref_entreprise', $partenaire-> getRefEntreprise());
        $req->execute();

    }
}