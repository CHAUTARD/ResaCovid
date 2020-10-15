<?php
/** adm_creneau.php
 *  @version : 1.0.4
 *  @date : 2020-10-15
 *  
 * Administration des creneaux
 */

$tpl->assign( 'titre', '<i class="far fa-calendar-alt"></i> Les creneaux');

$jour = array( 1 => 'Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi', 'Dimanche');

// // Recherche tous les enregistrements existent
$database->query("SELECT * FROM `res_creneaux` ORDER BY `Jour` ASC, `Heure_Debut`");
$result = $database->resultSet();

$ret = array();

foreach($result as $r)
{
    $ret[] = array(
        'id_creneau' => $r['id_creneau'],
        'Nom' => $r['Nom'],
        'Salle' => $r['Salle'],
        'nJour' => $r['Jour'],
        'Jour' => $jour[ $r['Jour'] ],
        'Heure_Debut' => formatHeure($r['Heure_Debut']),
        'Heure_Fin' => formatHeure($r['Heure_Fin']),
        'Libre' => $r['Libre'],
        'id_ouvreur' => $r['id_ouvreur'],
        'Ouvreur' => GetNomByNumLicence($r['id_ouvreur'], 1),
        'Nbr_Place' => $r['Nbr_Place'],
        'Ord' => $r['Ord'],
        'Actif' => $r['Actif']
    );
}

$tpl->assign('ouvreurs', GetOuvreurs());
$tpl->assign('creneaux', $ret );

//draw the template
$tpl->draw('adm_creneau');
?>