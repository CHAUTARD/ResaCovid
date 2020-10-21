<?php
/**   adm_delete_reservation.php  
 * 
 *  @version : 1.0.0
 *  @date : 2020-10-10
 * 
 * Supprimer une reservations
 * 
 * Appel à partir de jquery en Ajax :
 *      DelReservation( {$idReservation} )
 *      
 * Champs de la table utilisés :
 *      id_reservation  -> Paramétre
 * 
 */

// Suppression si l'enregistrement existe déjà
$database->query("DELETE FROM `res_reservations` WHERE `id_reservation` = :id_reservation;");
$database->bind(':id_reservation', $_GET['idReservation']);
$database->execute();

die (true);
?>