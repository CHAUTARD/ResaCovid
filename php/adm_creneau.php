<?php
/** adm_creneau.php
 *  @version : 1.0.7
 *  @date : 2021-06-17
 *  
 * Administration des creneaux
 */

$tpl->assign( 'titre', '<i class="far fa-calendar-alt"></i> Les creneaux');

// Liste des salles
include_once 'get_salles.php';

// Recherche tous les enregistrements existent
$database->query("SELECT * FROM `res_creneaux` cr LEFT JOIN `res_salles` sa USING (id_salle) WHERE sa.Active = 'Oui' ORDER BY `Jour` ASC, `Heure_Debut`");
$result = $database->resultSet();

$ret = array();

foreach($result as $r)
{
    $ret[] = array(
        'id_creneau' => $r['id_creneau'],
        'Nom' => $r['Nom'],
        'id_salle' => $r['id_salle'],
        'Salle' => $r['Salle'],
        'nJour' => $r['Jour'],
        'Jour' => $JOUR_FR[ $r['Jour'] ],
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
$tpl->assign('salles', $salles );

//draw the template
$tpl->draw('adm_creneau');
?>