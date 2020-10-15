<?php
/** adm_clean.php 
 *      @version : 1.0.4
 *      @date : 2020-10-15
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

/* Créneaux date
$sqls[] = sprintf("CREATE TABLE res_creneaux_date_%s LIKE res_creneaux_date;", $dt);
$sqls[] = sprintf("INSERT res_creneaux_date_%s SELECT * FROM res_creneaux_date;",  $dt);
*/

// Créneaux
$sqls[] = sprintf("CREATE TABLE res_creneaux_%s LIKE res_creneaux;", $dt);
$sqls[] = sprintf("INSERT res_creneaux_%s SELECT * FROM res_creneaux;",  $dt);

/*------------------------------
 * Vidage des tables
 * -----------------------------*/

/* Creneaux date
$sqls[] = "TRUNCATE `res_creneaux_date`";
*/

// Créneaux
$sqls[] = "TRUNCATE `res_creneaux`";

// Réservations
$sqls[] = "TRUNCATE `res_reservations`";

// Prioritaires
$sqls[] = "TRUNCATE `res_prioritaires`";

// Création d'un licencier administrateur pour ne pas être bloqué
$sqls[] = sprintf("INSERT INTO `res_licenciers` (`id_licencier`, `Civilite`, `Nom`, `Surnom`, `Prenom`, `Classement`, `Equipe`, `Telephone`, `Email`, `Ouvreur`, `Admin`, `Actif`) VALUES ('9399999', 'Mr', '%s', '', 'Toi', '5', '0', '01.01.01.01.01', 'pas.saisie@faux', 'Non', '%s', 'Oui');", USER_NAME, USER_PWD );

$database->transaction($sqls);

// Affichage d'une fenêtre modale d'information
$tpl->assign('information', 'Vidage des tables des licenciés, des créneaux,  des réservations et des prioritaires terminée');

//draw the template
$tpl->draw('adm_menu');
?>