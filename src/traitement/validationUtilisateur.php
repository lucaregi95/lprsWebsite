<?php
session_start();
switch ($_POST['role']) {
    case 'etudiant':
        require_once "../../src/model/Etudiant.php";
        require_once "../../src/repository/EtudiantRepository.php";


        $rep = new EtudiantRepository();
        $etudiant=$rep->getEtudiant($_POST["id"]);
        $etudiant->setStatutValidation("actif");
        $rep -> modifierEtudiant($etudiant);
        header("Location: ../../public/admin.php");
        exit();

    case 'alumni':
        require_once "../../src/model/Alumni.php";
        require_once "../../src/repository/AlumniRepository.php";

        $rep = new AlumniRepository();
        $alumni=$rep->getAlumni($_POST["id"]);
        $alumni->setStatutValidation("actif");
        $rep -> modifierAlumni($alumni);
        header("Location: ../../public/admin.php");
        exit();
        break;




    case 'professeur':
        require_once "../../src/model/Professeur.php";
        require_once "../../src/repository/ProfesseurRepository.php";


        $rep = new ProfesseurRepository();
        $professeur=$rep->getProfesseur($_POST["id"]);
        $professeur->setStatutValidation("actif");
        $rep -> modifierProfesseur($professeur);
        header("Location: ../../public/admin.php");
        exit();



    case 'partenaire':
        require_once "../../src/model/Partenaire.php";
        require_once "../../src/repository/PartenaireRepository.php";


        $rep = new PartenaireRepository();
        $partenaire=$rep->getPartenaire($_POST["id"]);
        $partenaire->setStatutValidation("actif");
        $rep -> modifierPartenaire($partenaire);
        header("Location: ../../public/admin.php");
        exit();
        break;
}