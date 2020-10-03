<?php
/*   a d d _ o u v r e u r . p h p  
 *  
 * Ajouter un ouvreur dans les reservations 
 * 
 * Appel à partir de jquery en Ajax :
 *      AddOuvreur( {$dayofyear}, {$idCreneau.1})
 *      
 * Champ de la table à remplir :
 *      id_reservation  -> Automatique
 *      id_creneau      -> Paramètre
 *      iDate           -> Paramètre
 *      id_licencier    -> $_SESSION
 *      Ouvreur         -> 'Oui'
 * 
 */

// Suppression si l'enregistrement existe déjà
$database->query("DELETE FROM `res_reservations` WHERE `id_creneau` = :id_creneau AND `iDate` = :iDate AND Ouvreur = 'Oui';");
$database->bind(':id_creneau', $_GET['iCreneau']);
$database->bind(':iDate', $_GET['iDate']);
$database->execute();


// Ajout d'un enregistrement
$database->query("INSERT INTO `res_reservations` ( `id_creneau`, `iDate`, `id_licencier`, `Ouvreur`) VALUES ( :id_creneau, :iDate, :id_licence, 'Oui');");
$database->bind(':id_creneau', $_GET['iCreneau']);
$database->bind(':iDate', $_GET['iDate']);
$database->bind(':id_licence', $_SESSION['id_licencier']);
$database->execute();

die (json_encode(array('success' => 'Oui', 'data' => "Ajout/Modification de l'ouvreur effectué !")) );
?>