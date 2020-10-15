<?php
/** adm_clean_creneau.php 
 * 
 * @version : 1.0.2
 * @date : 2020-10-14
 */

/*--------------------------------------------------------
 *   Sauvegarde des tables avec suffixe YYYYMMDDHHMMSS
 *--------------------------------------------------------*/

$dt = date("YmdHis");

$sqls = array();

// Prioritaires
$sqls[] = sprintf("CREATE TABLE res_prioritaires_%s LIKE res_prioritaires;", $dt);
$sqls[] = sprintf("INSERT res_prioritaires_%s SELECT * FROM res_prioritaires;",  $dt);

// Réservations
$sqls[] = sprintf("CREATE TABLE res_reservations_%s LIKE res_reservations;", $dt);
$sqls[] = sprintf("INSERT res_reservations_%s SELECT * FROM res_reservations;",  $dt);

// Créneaux
$sqls[] = sprintf("CREATE TABLE res_creneaux_%s LIKE res_creneaux;", $dt);
$sqls[] = sprintf("INSERT res_creneaux_%s SELECT * FROM res_creneaux;",  $dt);

// Créneaux date
$sqls[] = sprintf("CREATE TABLE res_creneaux_date_%s LIKE res_creneaux_date;", $dt);
$sqls[] = sprintf("INSERT res_creneaux_date_%s SELECT * FROM res_creneaux_date;",  $dt);

/*------------------------------
 * Vidage des tables
 * -----------------------------*/

// Creneaux date
$sqls[] = "TRUNCATE `res_creneaux_date`";

// Creneaux
$sqls[] = "TRUNCATE `res_creneaux`";

// Réservations
$sqls[] = "TRUNCATE `res_reservations`";

// Prioritaires
$sqls[] = "TRUNCATE `res_prioritaires`";

$database->transaction($sqls);

// Affichage d'une fenêtre modale d'information
$tpl->assign('information', 'Vidage des tables creneaux date, creneaux, reservations, prioritaires terminée');

//draw the template
$tpl->draw('adm_menu');
?>