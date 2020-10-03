<?php
/* adm_clean_prioritaire.php
 * Version : 1.0.0
 * Date : 2020-10-02
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

// Retour au menu
$tpl->draw('adm_menu');
?>