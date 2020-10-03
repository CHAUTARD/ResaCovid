<?php
/*   a d d _ j o u e u r . p h p   
 * 
 * Ajouter un joueur dans les reservation 
 * 
 * Appel à partir de jquery en Ajax :
 *      AddJoueur( {$dayofyear}, {$idCreneau.1})
 *      
 * Champ de la table à remplir :
 *      id_reservation  -> Automatique
 *      id_creneau      -> Paramétre
 *      iDate           -> Paramétre
 *      id_licencier    -> $_SESSION
 *      Ouvreur         -> 'Oui'
 * 
 */

// Suppression si l'enregistrement si il existe déjà
$database->query("DELETE FROM `res_reservations` WHERE `id_creneau` = :id_creneau AND `iDate` = :iDate AND id_licencier = :id_licencier AND ouvreur = 'Non';");
$database->bind(':id_creneau', $_GET['iCreneau']);
$database->bind(':iDate', $_GET['iDate']);
$database->bind(':id_licencier', $_SESSION['id_licencier']);
$database->execute();

// Ajout d'un enregistrement
$database->query("INSERT INTO `res_reservations` (`id_creneau`, `iDate`, `id_licencier`, `ouvreur`) VALUES ( :id_creneau, :iDate, :id_licence, 'Non');");
$database->bind(':id_creneau', $_GET['iCreneau']);
$database->bind(':iDate', $_GET['iDate']);
$database->bind(':id_licence', $_SESSION['id_licencier']);
$database->execute();

die (json_encode(array('success' => 'Oui', 'data' => "Ajout du joueur effectué !")) );
?>