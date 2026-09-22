<?php

if( isset($_POST["poste_occupe"]) && isset($_POST["motif_inscription"])&& isset($_POST["ref_entreprise"])){
   $ref_utilisateur=(isset($_POST["ref_utilisateur"]))?$_POST["ref_utilisateur"]:"";

    $partenaire = new Partenaire($ref_utilisateur,$_POST["poste_occupe"], $_POST["motif_inscription"], $_POST["ref_entreprise"]);
}