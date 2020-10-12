<?php
/* adm_prioritaire.php
 *      @version : 1.0.1
 *      @date : 2020-10-12
 * 
 * Administration des prioritaires
 */

$tpl->assign( 'titre', '<i class="fas fa-table-tennis"></i> Les prioritaires');

$jour = array( 1 =>'Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche');

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

$creneaux = array();

$actif = true;
foreach($result as $r)
{
    // Recherche des licenciers prioritaire pour ce créneau
    $database->query("SELECT p.`id_prioritaire`, l.id_licencier, l.Nom, l.Prenom FROM `res_prioritaires` p LEFT JOIN `res_licenciers` l USING(`id_licencier`) WHERE `id_creneau` = ".$r['id_creneau']." ORDER BY l.Nom, l.Prenom");
    $resultLic = $database->resultSet();
        
    if($resultLic === false)
        $NbrJoueur = 0;
    else 
        $NbrJoueur = count($resultLic);
    
    $creneaux[] = array(
        'id_creneau' => $r['id_creneau'],
        'Salle' => $r['Salle'],
        'Jour' => $jour[ $r['Jour'] ],
        'Heure_Debut' => formatHeure($r['Heure_Debut']),
        'Nbr_Place' => '(' . $NbrJoueur . '/' . $r['Nbr_Place'] . ')',
        'Disabled' => $NbrJoueur == 0 ? ' disabled' : '',
        'Licenciers' => $resultLic,
        'Active' => $actif ? ' active' : '',
        'ShowActive' => $actif ? ' show active' : ''
    );
    $actif = false;
}

$tpl->assign('creneaux', $creneaux );

//draw the template
$tpl->draw('adm_prioritaire');
?>