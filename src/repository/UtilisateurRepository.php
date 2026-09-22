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
        $result = $req->fetch();;
    }

    public function getUtilisateurs()
    {
        $sql = "SELECT * FROM utilisateur";
        $req = $this->connexionbdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $tabUtilisateur = array();
    }


        public function ajoutUtilisateur(Utilisateur $utilisateur){
        $sql="INSERT INTO utilisateur VALUES (:id_utilisateur,:nom,:prenom,:email,:mdp, :date_inscription, :statut_validation)";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':id_utilisateur', $utilisateur-> getIdUtilisateur());;
        $req->bindValue(":nom",$utilisateur-> getNom());
        $req->bindValue(":prenom",$utilisateur-> getPrenom());
        $req->bindValue(":email",$utilisateur-> getEmail());
        $req->bindValue(":mdp",$utilisateur-> getMdp());
        $req->bindValue(":date_inscription",$utilisateur-> getDateInscription());
        $req->bindValue(":statut_validation",$utilisateur-> getStatutValidation());
        $req->execute();
        }

        public function modifierUtilisateur(Utilisateur $utilisateur){
        $sql="UPDATE utilisateur SET nom = :nom, prenom =:prenom, email=:email, mdp=:mdp, date_inscription=:date_inscription, statut_validation=:statut_validation WHERE id_utilisateur = :id_utilisateur";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':id_utilisateur', $utilisateur-> getIdUtilisateur());
        $req->bindValue(':nom',$utilisateur-> getNom());
        $req->bindValue(':prenom',$utilisateur-> getPrenom());
        $req->bindValue(':email',$utilisateur-> getEmail());
        $req->bindValue(':mdp',$utilisateur-> getMdp());
        $req->bindValue(':date_inscription',$utilisateur-> getDateInscription());
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