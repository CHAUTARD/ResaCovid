<?php
/* adm_delete_prioritaire.php
 *      @version : 1.0.0
 *      @date : 2020-10-16
 *      
 * Supprime physiquement un enregistrement prioritaire
 * 
 * $_GET['id_prioritaire'] = id_prioritaire
 */

// Suppression dans  res_prioritaire et res_licenciers
$database->query("DELETE FROM `res_prioritaires` WHERE `id_prioritaire` = :id");
$database->bind(':id', intval($_GET['id_prioritaire']));
$database->execute();

die(true);
?>