<?php
/**  adm_stat_prioritaire.php 
 *  @version : 1.0.1
 *  @date : 2020-10-15
 * 
 * Statistique sur le nombre de foix qu'une personne est prioritaire
 */

$tpl->assign( 'titre', '<i class="far fa-chart-bar"></i> Statistiques');

// Recherche du nombre total de licencié actif
$database->query("SELECT COUNT(*) count FROM `res_licencies` WHERE Actif = 'Oui'");
$result = $database->single();

$total = $result['count'];

// Recherche du nombre de licencié actif avec prioritaire = x (1, 2, 3, 4, 5, 6)
$database->query("SELECT COUNT(*) count FROM `res_prioritaires` GROUP BY id_licencier");
$result = $database->resultSet();

$ret = array( 0, 0, 0, 0, 0, 0, 0, 0);
$tRet = 0;

foreach($result as $r)
{
    // Maximum fixé à 6, normalement jamais atteind
    $i = $r['count'] < 6 ? $r['count'] : 6;
    $ret[$i] += 1;   
    $tRet++;
}
    
$ret[0] = $total - $tRet;

$tpl->assign('valeurs', implode(',', $ret) );

//draw the template
$tpl->draw('adm_stat_prioritaire');
?>