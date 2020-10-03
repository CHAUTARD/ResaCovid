<?php
/*   a d m _ d e l e t e _ c r e n e a u . p h p  
 * 
 *  Version : 1.0.0
 * 
 * Supprimer un joueur dans les reservation 
 * 
 * Appel à partir de jquery en Ajax :
 *      DelCreneau( {$dayofyear}, {$idCreneau.1})
 *      
 * Champs de la table utilisés :
 *      id_creneau      -> Paramétre
 *      iDate           -> Paramétre
 *      id_licencier    -> $_SESSION
 *      Ouvreur         -> 'Oui'
 * 
 */

// Suppression si l'enregistrement existe déjà
$database->query("DELETE FROM `res_reservations` WHERE `id_creneau` = :id_creneau AND `iDate` = :iDate AND id_licencier = :id_licencier AND ouvreur = 'Non';");
$database->bind(':id_creneau', $_GET['iCreneau']);
$database->bind(':iDate', $_GET['iDate']);
$database->bind(':id_licencier', $_SESSION['id_licencier']);
$database->execute();

die (json_encode(array('success' => 'Oui', 'data' => "Suppression de la réservation !")) );
?>