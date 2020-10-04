<?php
/* adm_clean_prioritaire.php
 * Version : 1.0.1
 * Date : 2020-10-04
 */

/*--------------------------------------------------------
 *   Sauvegarde des tables avec suffixe YYYYMMDDHHMMSS
 *--------------------------------------------------------*/

$dt = date("YmdHis");

$sqls = array();

// Prioritaires
$sqls[] = sprintf("CREATE TABLE res_prioritaires_%s LIKE res_prioritaires;", $dt);
$sqls[] = sprintf("INSERT res_prioritaires_%s SELECT * FROM res_prioritaires;",  $dt);

/*------------------------------
 * Vidage des tables
 * -----------------------------*/

// Prioritaires
$sqls[] = "TRUNCATE `res_prioritaires`";

$database->transaction($sqls);

// Affichage d'une fenêtre modale d'information
$tpl->assign('information', 'Vidage de la table prioritaires terminée');

// Retour au menu
$tpl->draw('adm_menu');
?>