<?php
/*  adm_add_creneau.php 
 *  Ajout d'un creneau
 *  
    array (size=11)
      'page' => string 'add_creneau' (length=11)
      'id_creneau' => string '0' (length=1)
      'addNom' => string 'Mardi avant les grands' (length=22)
      'addSalle' => string 'Copée' (length=6)
      'addJour' => string '2' (length=1)
      'addHeureDebut' => string '19:00' (length=5)
      'addHeureFin' => string '20:30' (length=5)
      'addLibre' => string 'Oui' (length=3)
      'addOuvreur' => string '9317315' (length=7)
      'addNbrPlace' => string '10' (length=2)
      'addOrd' => string '0' (length=1)
 */

$result = false;

// Recherche si l'enregistrement existe
if($_GET['id_creneau'] > 0)
{
    $database->query("SELECT `id_creneau` FROM `res_creneaux` WHERE `id_creneau` = :id");
    $database->bind(':id', $_GET['addLicence']);
    $result = $database->single();
}    

// Non -> Création
if($result === false) {
    $database->query('INSERT INTO `res_creneaux` (`id_creneau`, `Nom`, `Salle`, `Jour`, `Heure_Debut`, `Heure_Fin`, `Libre`, `id_ouvreur`, `Nbr_Place`, `Ord`) VALUES (NULL, ":Nom", ":Salle", :Jour, ":HeureDebut", ":HeureFin", "", ":Libre", :LicenceOuvreur, :NbrPlace, :addOrd);');
    $msg = "Créneau créé !";
    
} else {
    // Oui -> Update
    $database->query('UPDATE `res_creneaux` SET `id_creneau` = ":id_creneau", `Nom` = ":Salle", `Jour` = ":Jour", `Heure_Debut` = ":HeureDebut", `Heure_Fin` = :HeureFin, `Libre` = ":Libre", `id_ouvreur` = ":LicenceOuvreur", `Nbr_Place` = ":NbrPlace", `Ord` = ":addOrd" WHERE `id_creneau` = :id_creneau');
    $database->bind(':id_creneau', $_GET['id_creneau']);
    $msg = "Licencié modifié !";
}

$database->bind(':Nom', $_GET['addNom']);
$database->bind(':Salle', $_GET['addSalle']);
$database->bind(':Jour', $_GET['addJour']); 
$database->bind(':HeureDebut', $_GET['addHeureDebut']);
$database->bind(':HeureFin', $_GET['addHeureFin']);
$database->bind(':Libre', $_GET['addLibre']); 
$database->bind(':LicenceOuvreur', $_GET['addOuvreur']);
$database->bind(':NbrPlace', $_GET['addNbrPlace']);
$database->bind(':addOrd', $_GET['addOrd']);

// $database->Dump();

$database->execute();

Die($msg);
?>