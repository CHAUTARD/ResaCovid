<?php
/** adm_prioritaire.php
 * 
 *      @version : 1.0.3
 *      @date : 2020-10-15
 * 
 * Administration des prioritaires
 */

$tpl->assign( 'titre', '<i class="fas fa-table-tennis"></i> Les prioritaires');

$JOUR_FR// // Recherche si l'enregistrement existe
//$database->query("SELECT cr.* FROM `res_creneaux` cr LEFT JOIN `res_creneaux_date` crd USING(id_creneau) WHERE :date BETWEEN crd.Date_Debut AND crd.Date_Fin AND `Libre` = 'Non' ORDER BY cr.`Jour`, cr.`Heure_Debut`");
$database->query("SELECT * FROM `res_creneaux` WHERE `Actif` = 'Oui' AND `Libre` = 'Non' ORDER BY `Jour`, `Heure_Debut`");
//$database->bind(':date', date('Y-m-d'));
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
        'Jour' => $JOUR_FR[ $r['Jour'] ],
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