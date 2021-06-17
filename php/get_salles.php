<?php
/** get_salles.php
 *  @version : 1.0.0
 *  @date : 2021-06-15
 *
 * Recherche de toutes les salles Actives
 */

// Recherche tous les enregistrements existent
$database->query("SELECT * FROM `res_salles` WHERE Active = 'Oui' ORDER BY `Ord`");
$salles = $database->resultSet();
?>