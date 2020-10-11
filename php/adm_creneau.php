<?php
/* adm_creneau.php
 *  Version : 1.0.1
 *  Date : 2020-10-11
 *  
 * Administration des creneaux
 */

$tpl->assign( 'titre', '<i class="far fa-calendar-alt"></i> Les creneaux');

$jour = array( 1 => 'Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi', 'Dimanche');

// // Recherche si l'enregistrement existe
$database->query("SELECT * FROM `res_creneaux` ORDER BY `Jour` ASC, `Heure_Debut`");
$result = $database->resultSet();

/*
 Index  Nom 	    Index		Type
  1 	id_creneau	Primaire 	int(11)
  2 	Nom 					varchar(35)
  3 	Salle 					enum('Coppée', 'Tcheuméo')
  4 	Jour 					tinyint(4)
  5 	Heure_Debut 			time
  6 	Heure_Fin 				time
  7 	Libre 					enum('Oui', 'Non')
  8 	id_ouvreur	Index 		int(11)
  9 	Nbr_Place 				int(11)
 10 	Ord 					int(11)
 */

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
        'Ouvreur' => GetNomByNumLicence( $database, $r['id_ouvreur']),
        'Nbr_Place' => $r['Nbr_Place'],
        'Ord' => $r['Ord']
    );
}

$tpl->assign('ouvreurs', GetOuvreurs($database));
$tpl->assign('creneaux', $ret );

//draw the template
$tpl->draw('adm_creneau');
?>