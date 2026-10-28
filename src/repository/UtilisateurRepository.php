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


    public function getUtilisateurParEmail($email){
        $sql = "SELECT * FROM v_utilisateurwithrole WHERE email = :email";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':email', $email);
        $req->execute();
        $result = $req->fetch();
        return $result;
    }


//    public function getAllUtilisateurs() {
//        $sql = "SELECT * FROM utilisateur";
//        $req = $this->connexionbdd->prepare($sql);
//        $req->execute();
//        $results = $req->fetchAll();
//        $tabUtilisateur = array();
//        foreach ($results as $result) {
//            $tabUtilisateur[] = new Utilisateur($result["id_acteur"],$result["nom"],$result["prenom"],$result["email"], $result["mdp"],$result["date_naissance"],$result["tel"],$result["rue"],$result["ville"],$result["cp"],$result["role"],$result["etat"]);
//        }
//        return $tabUtilisateur;
//    }

    //Utilisateur est abract donc pas d'instanciation


    public function ajoutUtilisateur(Utilisateur $utilisateur){
        $sql="INSERT INTO utilisateur(nom,prenom,email,mdp,date_inscription,statut_validation) VALUES (:nom,:prenom,:email,:mdp,:date_inscription,:statut_validation)";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(":nom",$utilisateur-> getNom());
        $req->bindValue(":prenom",$utilisateur-> getPrenom());
        $req->bindValue(":email",$utilisateur-> getEmail());
        $req->bindValue(":mdp",$utilisateur-> getMdp());
        $req->bindValue(":date_inscription",$utilisateur-> getDateInscription());
        $req->bindValue(":statut_validation",$utilisateur-> getStatutValidation());
        $req->execute();
        return (int) $this->connexionbdd->lastInsertId();
    }

    public function modifierUtilisateur(Utilisateur $utilisateur){
        $sql="UPDATE utilisateur SET nom = :nom, prenom =:prenom, email=:email, mdp=:mdp, statut_validation=:statut_validation WHERE id_utilisateur = :id_utilisateur";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':id_utilisateur', $utilisateur-> getIdUtilisateur());
        $req->bindValue(':nom',$utilisateur-> getNom());
        $req->bindValue(':prenom',$utilisateur-> getPrenom());
        $req->bindValue(':email',$utilisateur-> getEmail());
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

    public function connecterUtilisateur($email, $mdp){
        $sql = "SELECT * FROM utilisateur WHERE email = :email AND mdp = :mdp";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':email', $email);
        $req->bindValue(':mdp', $mdp);
        $req->execute();
        $result = $req->fetch();
        return $result;
    }
}