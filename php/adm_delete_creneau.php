<?php
/*   adm_delete_creneau.php  
 * 
 *  @version : 1.0.0
 *  @date : 2020-10-10
 * 
 * Supprimer un ou des créneaux
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
$database->query("DELETE FROM `res_reservations` WHERE `id_creneau` = :id_creneau AND `iDate` = :iDate AND id_licencier = :id_licencier AND Ouvreur = 'Non';");
$database->bind(':id_creneau', $_GET['iCreneau']);
$database->bind(':iDate', $_GET['iDate']);
$database->bind(':id_licencier', $_SESSION['id_licencier']);
$database->execute();

die (json_encode(array('success' => 'Oui', 'data' => "Suppression de la réservation !")) );
?>