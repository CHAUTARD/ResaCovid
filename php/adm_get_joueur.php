<?php
/* adm_get_joueur.php
 *      @version : 1.0.1
 *      @date : 2020-10-12
 * 
 * Recherche des joueurs à une date donnée et un créneau donnée
 * 
 * array (size=3)
      'page' => string 'get_joueur' (length=10)
      'id_creneau' => string '6' (length=1)
      'iDate' => string '20267' (length=5)
  
 */

$ret = '[';

// Recherche de l'ouvreur
$database->query("SELECT l.Prenom as Prenom, l.Nom as Nom FROM `res_reservations` r LEFT JOIN `res_licencies` l USING(`id_licencier`) WHERE `id_creneau` = :id_creneau AND `iDate` = :iDate AND r.`Ouvreur` = 'Oui'");
$database->bind('id_creneau', $_GET['id_creneau']);
$database->bind('iDate', $_GET['iDate']);
$result = $database->single();

if($result !== false)
    $ret .= '{ "ouvreur": true, "nom": "' . $result['Prenom'] . ' ' . $result['Nom'] . '"}';

// Recherche des joueurs
$database->query("SELECT l.Prenom as Prenom, l.Nom as Nom FROM `res_reservations` r LEFT JOIN `res_licencies` l USING(`id_licencier`) WHERE `id_creneau` = :id_creneau AND `iDate` = :iDate AND r.`Ouvreur` = 'Non' ORDER BY Nom, Prenom");
$database->bind('id_creneau', $_GET['id_creneau']);
$database->bind('iDate', $_GET['iDate']);
$result = $database->resultSet();

if($result !== false)
{
    foreach($result as $r)
    {
        if(strlen($ret) > 10) $ret .= ',';
        $ret .= '{ "ouvreur": false, "nom": "' . $r['Prenom'] . ' ' . $r['Nom'] . '"}';
    }
}

die( $ret . ']');