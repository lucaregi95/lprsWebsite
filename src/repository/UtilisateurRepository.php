<?php
class UtilisateurRepository{

    private $connexionbdd;

    public function __construct(){
        $this->connexionbdd = (new Bdd())->getConnexionBdd();
    }

    public function getUtilisateur($id_utilisateur){
        $sql = "SELECT * FROM utilisateur WHERE id_utilisateur = :id_utilisateur";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':id_utilisateur', $id_utilisateur);
        $req->execute();
        $result = $req->fetch();
    }

    public function getAllUtilisateur(){
        $sql = "SELECT * FROM utilisateur";
        $req = $this->connexionbdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $tabUtilisateur = array();
        return $tabUtilisateur;
        }


        public function ajoutUtilisateur(Utilisateur $utilisateur){
        $sql="INSERT INTO utilisateur VALUES (:nom,:prenom,:mail,:mdp,:statut_validation)";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(":nom",$utilisateur-> getNom());
        $req->bindValue(":prenom",$utilisateur-> getPrenom());
        $req->bindValue(":mail",$utilisateur-> getEmail());
        $req->bindValue(":mdp",$utilisateur-> getMdp());
        $req->bindValue(":statut_validation",$utilisateur-> getStatutValidation());
        $req->execute();
        return (int) $this->connexionbdd->lastInsertId();
        }

        public function modifierUtilisateur(Utilisateur $utilisateur){
        $sql="UPDATE utilisateur SET nom = :nom, prenom =:prenom, mail=:mail, mdp=:mdp, statut_validation=:statut_validation WHERE id_utilisateur = :id_utilisateur";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':id_utilisateur', $utilisateur-> getIdUtilisateur());
        $req->bindValue(':nom',$utilisateur-> getNom());
        $req->bindValue(':prenom',$utilisateur-> getPrenom());
        $req->bindValue(':mail',$utilisateur-> getEmail());
        $req->bindValue(':mdp',$utilisateur-> getMdp());
        $req->bindValue(':statut_validation',$utilisateur-> getStatutValidation());
        $req->bindValue(':id_utilisateur',$utilisateur-> getIdUtilisateur());
        $req->execute();

        }

    public function supprimerUtilisateur($id_utilisateur){
        $sql="DELETE FROM utilisateur WHERE id_utilisateur = :id_utilisateur";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':id_utilisateur', $id_utilisateur);
        $req->execute();
    }









}