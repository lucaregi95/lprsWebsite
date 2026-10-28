<?php

Class ParticipeRepository{

    private $connexionBdd;
    public function __construct()
    {
        $this->connexionBdd = (new Bdd())->getConnexionBdd();
    }

    public function getParticipe($id_participe){
        $sql ="SELECT * FROM participe WHERE id_participe = :id_participe";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':id_participe', $id_participe);
        $req->execute();
        $result = $req->fetch();
        $participe = new Participe($result['id_participe'],$result['est_orga'],$result['ref_utilisateur'],$result['ref_evenement']);
        return $participe;
    }

    public function getAllParticipes(){
        $sql ="SELECT * FROM participe";
        $req = $this->connexionBdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $tabParticipes = array();
        foreach ($result as $results) {
            $participes = new Participe($results['id_participe'],$results['est_orga'],$results['ref_utilisateur'],$results['ref_evenement']);
        $tabParticipes[] = $participes;
        }
        return $tabParticipes;
    }

    public function ajoutParticipe(Participe $participe){
        $sql = "INSERT INTO participe (est_orga,ref_utilisateur,ref_evenement) VALUES (:est_orga,:ref_utilisateur,:ref_evenement) ";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':est_orga',$participe->getEstOrga());
        $req->bindValue(':ref_utilisateur',$participe->getRefUtilisateur());
        $req->bindValue(':ref_evenement',$participe->getRefEvenement());
        $req->execute();
    }

    public function supprimerParticipe($id_participe){
        $sql = "DELETE FROM participe WHERE id_participe = :id_participe";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':id_participe', $id_participe);
        $req->execute();
    }

    public function modifierParticipe(Participe $participe){
        $sql = "UPDATE participe SET est_orga=:est_orga,ref_utilisateur=:ref_utilisateur,ref_evenement=:ref_evenement WHERE id_participe = :id_participe";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':id_participe',$participe->getIdParticipe());
        $req->bindValue(':est_orga',$participe->getEstOrga());
        $req->bindValue(':ref_utilisateur',$participe->getRefUtilisateur());
        $req->bindValue(':ref_evenement',$participe->getRefEvenement());
        $req->execute();
    }


}