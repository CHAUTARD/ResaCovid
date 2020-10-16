<?php
/* adm_save_prioritaire.php
 *      @version : 1.0.0
 *      @date : 2020-10-16
 * 
 * Sauve les créneaux prioritaires pour le licencié sauver dans la session
 * $_SESSION['id_licencier_prioritaire']
 */

// Effacer tous les créneaux prioritaire pour ce licencié
$database->query('DELETE FROM `res_prioritaires` WHERE `id_licencier` = ' . $_SESSION['id_licencier_prioritaire']);
$database->execute();

/* var_dump($_GET);
 * array (size=4)
  'page' => string 'save_prioritaire' (length=16)
  'check3' => string 'on' (length=2)
  'check6' => string 'on' (length=2)
  'check15' => string 'on' (length=2)
 */

// Ajouter les créneaux passé en paramètres
foreach($_GET as $key => $value)
{
    if(substr($key, 0, 5) == 'check')
    {
        $database->query("INSERT INTO `res_prioritaires` (`id_prioritaire`, `id_creneau`, `id_licencier`) VALUES ( NULL, :id_creneau, :id_licencier);");
        $database->bind(':id_creneau', substr($key, 5));
        $database->bind(':id_licencier', $_SESSION['id_licencier_prioritaire']);
        $database->execute();
    }
}

die(json_encode(array(
    'title' => 'Priorité(s) mise(s) à jour !',
    'content' => "Les prioritées pour le licencié ont été mise à jour."
)));
?>