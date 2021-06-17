<?php
/*  adm_add_creneau.php 
 * 
 *  @version : 1.0.3
 *  @date : 2021-06-17
 *  
 *  Ajout d'un creneau
 *  
    array (size=11)
      'page' => string 'add_creneau' (length=11)
      'addCreneau' => string '0' (length=1)
      'addNom' => string 'Mardi avant les grands' (length=22)
      'addSalle' => string 'Copée' (length=6)
      'addJour' => string '2' (length=1)
      'addHeureDebut' => string '19:00' (length=5)
      'addHeureFin' => string '20:30' (length=5)
      'addLibre' => string 'Oui' (length=3)
      'addOuvreur' => string '9317315' (length=7)
      'addNbrPlace' => string '10' (length=2)
      'addOrd' => string '0' (length=1)
      'addActif' => string 'Oui' (length=3)
      
        page      add_creneau
        addCreneau    2
        addNom  	Loisir
        addSalle        1
        addJour     	1
        addHeureDebut   20:00
        addHeureFin 	21:00
        addLibre    	Non
        addOuvreur      93396
        addNbrPlace 	12
        addOrd      	1
        addActif    	Non
*/
 
// 0 -> Création
if($_GET['addCreneau'] == 0) {
    $database->query('INSERT INTO `res_creneaux` (`id_creneau`, `Nom`, `id_salle`, `Jour`, `Heure_Debut`, `Heure_Fin`, `Libre`, `id_ouvreur`, `Nbr_Place`, `Ord`, `Actif`) VALUES (NULL, :Nom, :id_salle, :Jour, :HeureDebut, :HeureFin, :Libre, :LicenceOuvreur, :NbrPlace, :addOrd, :addActif);');
    $title = "Créneau créé !";
    $content = "Le nouveau créneau vient d'être créé";
    
} else {
    // Oui -> Update
    $database->query('UPDATE `res_creneaux` SET `Nom` = :Nom, `id_salle` = :id_salle, `Jour` = :Jour, `Heure_Debut` = :HeureDebut, `Heure_Fin` = :HeureFin, `Libre` = :Libre, `id_ouvreur` = :LicenceOuvreur, `Nbr_Place` = :NbrPlace, `Ord` = :addOrd, `Actif` = :addActif WHERE `id_creneau` = :id_creneau');
    $database->bind(':id_creneau', $_GET['addCreneau']);
    $title = "Créneau modifié !";
    $content = "Les modifications ont été apportés au créneau.";
}

$database->bind(':Nom', $_GET['addNom']);
$database->bind(':id_salle', $_GET['addSalle']);
$database->bind(':Jour', $_GET['addJour'], PDO::PARAM_INT); 
$database->bind(':HeureDebut', $_GET['addHeureDebut']);
$database->bind(':HeureFin', $_GET['addHeureFin']);
$database->bind(':Libre', $_GET['addLibre']); 
$database->bind(':LicenceOuvreur', $_GET['addOuvreur'], PDO::PARAM_INT);
$database->bind(':NbrPlace', $_GET['addNbrPlace'], PDO::PARAM_INT);
$database->bind(':addOrd', $_GET['addOrd'], PDO::PARAM_INT);
$database->bind(':addActif', $_GET['addActif']);
$database->execute();

Die(json_encode(array(
    'title' => $title,
    'content' => $content
)));
?>