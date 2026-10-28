<?php
session_start();

require_once "../../bdd/bdd.php";
require_once "../../src/repository/UtilisateurRepository.php";
require_once "../../src/model/Utilisateur.php";

require_once "../../src/repository/EtudiantRepository.php";
require_once "../../src/model/Etudiant.php";

require_once "../../src/repository/AlumniRepository.php";
require_once "../../src/model/Alumni.php";

require_once "../../src/repository/ProfesseurRepository.php";
require_once "../../src/model/Professeur.php";



if (!isset($_SESSION['id_utilisateur'])) {
//    header("Location: connexion.php");
//    exit;
}

if (!isset($_POST['prenom'])) {
   header("Location: ../../public/profil.php");
   exit;
}

$utilisateurRepo = new EtudiantRepository();
switch ($_SESSION['role']) {
    case 'etudiant':
        $repo = new EtudiantRepository();
        $etudiant = $utilisateurRepo->getEtudiant($_POST['id_utilisateur']);
        $etudiant->setNom($_POST['nom']);
        $etudiant->setPrenom($_POST['prenom']);
        $etudiant->setEmail($_POST['email']);
        $repo->modifierEtudiant($etudiant);
        break;

    case 'alumni':
        $alumniRepo = new AlumniRepository();
        $alumni = $alumniRepo->getAlumni($_POST['id_utilisateur']);
        $alumni->setNom($_POST['nom']);
        $alumni->setPrenom($_POST['prenom']);
        $alumni->setEmail($_POST['email']);
        $alumni->setPosteOccupe($_POST['poste_occupe']);
        $alumniRepo->modifierAlumni($alumni);
        break;

    case 'professeur':
        $professeurRepo = new ProfesseurRepository();
        $professeur = $professeurRepo->getProfesseur($_POST['id_utilisateur']);
        $professeur->setSpecialite($_POST['specialite']);
        $professeurRepo->modifierProfesseur($professeur);
        break;
}


$utilisateurRepo->modifierEtudiant($etudiant);

//header("Location: ../../public/profil.php?succes=modifier");
//exit;