<?php

Class ParticipeRepository{

    private $connexionBdd;
    public function __construct()
    {
        $this->connexionBdd = (new Bdd())->getConnexionBdd();
    }

    public function getParticipe($id_participe, $id_evenement){
        $sql ="SELECT * FROM participe WHERE ref_utilisateur = :ref_utilisateur and ref_evenement=:ref_evenement";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $id_participe);
        $req->bindValue(':ref_evenement', $id_evenement);
        $req->execute();
        $result = $req->fetch();


        if($result==false){
            return null;
        }else{
            $participe = new Participe($result['est_orga'],$result['ref_utilisateur'],$result['ref_evenement']);
            return $participe;
        }
    }

    public function getAllParticipes(){
        $sql ="SELECT * FROM participe";
        $req = $this->connexionBdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $tabParticipes = array();
        foreach ($result as $results) {
            $participes = new Participe($results['est_orga'],$results['ref_utilisateur'],$results['ref_evenement']);
        $tabParticipes[] = $participes;
        }
        return $tabParticipes;
    }


    public function ajouterParticipe(Participe $participe){
        $sql = "INSERT INTO participe (est_orga,ref_utilisateur,ref_evenement) VALUES (:est_orga,:ref_utilisateur,:ref_evenement) ";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':est_orga',$participe->getEstOrga());
        $req->bindValue(':ref_utilisateur',$participe->getRefUtilisateur());
        $req->bindValue(':ref_evenement',$participe->getRefEvenement());
        $req->execute();
    }

    public function supprimerParticipe($id_participe,$id_evenement){
        $sql = "DELETE FROM participe WHERE ref_utilisateur = :ref_utilisateur and ref_evenement=:ref_evenement";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $id_participe);
        $req->bindValue(':ref_evenement', $id_evenement);
        $req->execute();
    }

    public function supprimerAllParticipesByEvenement($id_evenement) {
        $sql = "DELETE FROM participe WHERE ref_evenement = :ref_evenement";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':ref_evenement', $id_evenement, PDO::PARAM_INT);
        return $req->execute();
    }

    public function modifierParticipe(Participe $participe){
        $sql = "UPDATE participe SET est_orga=:est_orga,ref_utilisateur=:ref_utilisateur,ref_evenement=:ref_evenement WHERE ref_utilisateur = :ref_utilisateur and ref_evenement=:ref_evenement";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':est_orga',$participe->getEstOrga());
        $req->bindValue(':ref_utilisateur',$participe->getRefUtilisateur());
        $req->bindValue(':ref_evenement',$participe->getRefEvenement());
        $req->execute();
    }


}