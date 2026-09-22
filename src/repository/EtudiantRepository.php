<?php

class EtudiantRepository{

    private $connexionBdd;
    public function __construct()
    {
        $this->connexionBdd = (new Bdd())->getConnexionBdd();
    }

    public function getEtudiant($ref_utilisateur){
        $sql = "SELECT * FROM etudiant WHERE ref_utilisateur = :ref_utilisateur";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $ref_utilisateur);
        $req->execute();
        $result = $req->fetch();
        $etudiant = new Etudiant($result['ref_utilisateur'],$result['cv'],$result['ref_formation'],$result['ref_promotion']);
        return $etudiant;
    }

    public function getAllEtudiants(){
        $sql = "SELECT * FROM etudiant";
        $req = $this->connexionBdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $tabEtudiants = array();
        foreach ($result as $row) {
            $etudiant = new Etudiant($result['ref_utilisateur'],$result['cv'],$result['ref_formation'],$result['ref_promotion']);
        $tabEtudiants[] = $etudiant;
        }
        return $tabEtudiants;

    }

    public function ajouterEtudiant(Etudiant $ref_utilisateur){
        $sql = "INSERT INTO etudiant (ref_utilisateur,cv,ref_formation,ref_promotion) Values (:ref_utilisateur, :cv, :ref_formation, :ref_promotion)";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $ref_utilisateur);
        $req->bindValue(':cv', $_POST['cv']);
        $req->bindValue(':ref_formation', $_POST['ref_formation']);
        $req->bindValue(':ref_promotion', $_POST['ref_promotion']);
        $req->execute();
    }

    public function supprimerEtudiant($ref_utilisateur){
        $sql = "DELETE FROM etudiant WHERE ref_utilisateur = :ref_utilisateur";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $ref_utilisateur);
        $req->execute();
    }

    public function modifierEtudiant(Etudiant $etudiant){
        $sql ="UPDATE etudiant SET cv=:cv , ref_formation=:ref_formation, ref_promotion=:ref_promotion WHERE ref_utilisateur=:ref_utilisateur";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $etudiant->getRefUtilisateur());
        $req->bindValue(':cv', $etudiant->getCv());
        $req->bindValue(':ref_formation', $etudiant->getRefFormation());
        $req->bindValue(':ref_promotion', $etudiant->getRefPromotion());
        $req-> execute();
    }


}