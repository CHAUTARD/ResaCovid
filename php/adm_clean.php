<?php
/* adm_clean.php 
 * Version : 1.0.0
 * Date : 2020-10-02
 */

/*--------------------------------------------------------
 *   Sauvegarde des tables avec suffixe YYYYMMDDHHMMSS
 *--------------------------------------------------------*/

$dt = date("YmdHis");

$sqls = array();

// Licenciés
$sqls[] = sprintf("CREATE TABLE res_licenciers_%s LIKE res_licenciers;", $dt);
$sqls[] = sprintf("INSERT res_licenciers_%s SELECT * FROM res_licenciers;",  $dt);

// Prioritaires
$sqls[] = sprintf("CREATE TABLE res_prioritaires_%s LIKE res_prioritaires;", $dt);
$sqls[] = sprintf("INSERT res_prioritaires_%s SELECT * FROM res_prioritaires;",  $dt);

// Réservations
$sqls[] = sprintf("CREATE TABLE res_reservations_%s LIKE res_reservations;", $dt);
$sqls[] = sprintf("INSERT res_reservations_%s SELECT * FROM res_reservations;",  $dt);

// Créneaux
$sqls[] = sprintf("CREATE TABLE res_creneaux_%s LIKE res_creneaux;", $dt);
$sqls[] = sprintf("INSERT res_creneaux_%s SELECT * FROM res_creneaux;",  $dt);

/*------------------------------
 * Vidage des tables
 * -----------------------------*/

// Licenciés
$sqls[] = "TRUNCATE `res_licenciers`";

// Prioritaires
$sqls[] = "TRUNCATE `res_creneaux`";
// Réservations
$sqls[] = "TRUNCATE `res_reservations`";
// Créneaux
$sqls[] = "TRUNCATE `res_prioritaires`";

$database->transaction($sqls);

//draw the template
$tpl->draw('adm_menu');
?>