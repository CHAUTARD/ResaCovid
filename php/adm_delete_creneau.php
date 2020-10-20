<?php
/*   adm_delete_creneau.php  
 * 
 *  @version : 1.0.2
 *  @date : 2020-10-15
 * 
 * Supprimer un créneau
 * 
 * 	id_creneau : aRow[0],
 *	id_creneau_date : aRow[7]
 */

$idCreneau = intval($_GET['id']);

// Si l'identifiant n'existe pas dans res_reservations
$database->query('SELECT COUNT(*) as Nbr FROM res_reservations WHERE id_creneau = ' . $idCreneau);
$result = $database->single();

if($result === false || $result['Nbr'] == 0)
{
    // Suppression dans  res_prioritaire et res_licencies
    $database->query("DELETE FROM `res_creneaux` WHERE `id_creneau` = :id");
}
else
{
    // sinon
    // res_licencies Actif = Non et Suppression dans res_prioritaire
    $database->query("UPDATE `res_creneaux` SET `Actif` = 'Non' WHERE `id_creneau` = :id");
}
$database->bind(':id', $idCreneau);
$database->execute();

die(true);
?>