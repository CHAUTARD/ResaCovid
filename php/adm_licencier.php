<?php
/*
 * adm_licencier.php
 */

$tpl->assign( 'titre', '<i class="fas fa-users"></i> Les licenciers');

// Recherche de tous les créneaux qi sont dirigés
$database->query("SELECT `id_creneau`, `Salle`, `Jour`, `Heure_Debut`, `Heure_Fin` FROM `res_creneaux` WHERE `Libre` = 'Non' ORDER BY `Jour`, `Heure_Debut`");
$result = $database->resultSet();

/*
 * 
id_creneau	 Salle	  Jour 	Heure_Debut Heure_Fin
    2 	     Coppée 	1 	20:00:00 	21:00:00
    3 	     Coppée 	1 	21:00:00 	22:30:00
	5 	    Coppée 	    2 	20:30:00 	22:30:00
	6 	    Coppée 	    3 	19:00:00 	20:30:00
	7 	    Coppée 	    3 	20:30:00 	22:00:00
   15 	    Coppée 	    6 	10:00:00 	11:30:00
 */

$jour = array('Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi');

$data = array();
foreach($result as $r)
{
    $data[$r['id_creneau']] = sprintf( "%s %s de %s à %s", $r['Salle'], $jour[$r['Jour']], formatHeure($r['Heure_Debut']), formatHeure($r['Heure_Fin']));
}

$tpl->assign('creneaux', $data);

//draw the template
$tpl->draw('adm_licencier');
?>