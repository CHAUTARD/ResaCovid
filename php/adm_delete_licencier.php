<?php
/* adm_delete_row.php
 *  Version : 1.0.1
 *  Date : 2020-10-15
 *
 * Supprime physiquement ou logiquement un licencié
 * 
 * $_GET['id'] = id_licencier
 */

$idLicencier = intval($_GET['id']);

// Si l'identifiant n'existe pas dans res_reservations
$database->query('SELECT COUNT(*) as Nbr FROM res_reservations WHERE id_licencier = ' . $idLicencier);
$result = $database->single();

if($result === false)
    die (false);

$database->query("DELETE FROM `res_prioritaires` WHERE `id_licencier` = :id");
$database->bind(':id', $idLicencier);
$database->execute();

if($result['Nbr'] == 0)
{
    // Suppression dans  res_prioritaire et res_licenciers   
    $database->query("DELETE FROM `res_licenciers` WHERE `id_licencier` = :id");
    $database->bind(':id', $idLicencier);
    $database->execute();
}
else 
{
    // sinon
    // res_licenciers Actif = Non et Suppression dans res_prioritaire   
    $database->query("UPDATE `res_licenciers` SET `Actif` = 'Non' WHERE `id_licencier` = :id");
    $database->bind(':id', $idLicencier);
    $database->execute();
}

die(true);
?>