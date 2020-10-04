<?php
/* adm_clean_reservation.php
 * Version : 1.0.1
 * Date : 2020-10-04
 */

/*--------------------------------------------------------
 *   Sauvegarde des tables avec suffixe YYYYMMDDHHMMSS
 *--------------------------------------------------------*/

$dt = date("YmdHis");

$sqls = array();

// Réservations
$sqls[] = sprintf("CREATE TABLE res_reservations_%s LIKE res_reservations;", $dt);
$sqls[] = sprintf("INSERT res_reservations_%s SELECT * FROM res_reservations;",  $dt);

/*------------------------------
 * Vidage des tables
 * -----------------------------*/

// Réservations
$sqls[] = "TRUNCATE `res_reservations`";

$database->transaction($sqls);

// Affichage d'une fenêtre modale d'information
$tpl->assign('information', 'Vidage de la table reservations prioritaires terminée');

//draw the template
$tpl->draw('adm_menu');
?>