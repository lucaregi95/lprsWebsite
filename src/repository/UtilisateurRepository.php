<?php
class UtilisateurRepository{

    private $connexionbdd;

    public function __construct(){
        $this->connexionbdd = (new Bdd())->getConnexionBdd();
    }

    public function getUtilisateurs($id_utilisateur){
        $sql = "SELECT * FROM utilisateur WHERE id_utilisateur = :id_utilisateur";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':id_utilisateur', $id_utilisateur);
        $req->execute();
        $result = $req->fetch();
        $utilisateur = new Utilisateur($result["id_utilisateur]"],$result["nom"],$result['prenom'],$result['mail'],$result['mdp'],$result['date_inscription'],$result['statut_validation']);
        return $utilisateur;
    }

    public function getUtilisateur(){
        $sql = "SELECT * FROM utilisateur";
        $req = $this->connexionbdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $utilisateurs = array();
        foreach ($result as $results) {
            $tabUtilisateur[] = newUtilisateur($results["id_utilisateur]"],$results["nom"],$results['prenom'],$results['mail'],$results['mdp'],$results['date_inscription'],$results['statut_validation']);}
        return $utilisateurs;
        }


        public function ajoutUtilisateur(Utilisateur $utilisateur){
        $sql="INSERT INTO utilisateur VALUES (:id_utilisateur,:nom,:prenom,:mail,:mdp,:statut_validation)";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':id_utilisateur', $utilisateur-> getIdUtilisateur());;
        $req->bindValue(":nom",$utilisateur-> getNom());
        $req->bindValue(":prenom",$utilisateur-> getPrenom());
        $req->bindValue(":mail",$utilisateur-> getEmail());
        $req->bindValue(":mdp",$utilisateur-> getMdp());
        $req->bindValue(":statut_validation",$utilisateur-> getStatutValidation());
        $req->execute();
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











}