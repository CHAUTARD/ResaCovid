<?php
/* adm_get_prioritaire.php 
 *
 *  Recherche des créneaux prioritaire pour un licencié donné
 *  
 *  $_GET['id'] = Numéro de licence du joueur concerné
 */

$_SESSION['id_licencier_prioritaire'] = $_GET['id'];

// Recherche si l'enregistrement existe
$database->query("SELECT `id_creneau` FROM `res_prioritaires` WHERE `id_licencier` = :id");
$database->bind(':id', $_GET['id']);
$result = $database->resultSet();

/* Return */
$ret = '[';
foreach($result as $r)
{
   if(strlen($ret) > 1) $ret .= ',';
   $ret .= $r['id_creneau'];
}

die($ret . ']');
?>