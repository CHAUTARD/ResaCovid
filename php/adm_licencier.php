<?php
/**
 * adm_licencier.php
 * 
 *      @version : 1.0.4
 *      @date : 2020-10-19
 */

$tpl->assign( 'titre', '<i class="fas fa-users"></i> Les licenciers');

// Recherche de tous les créneaux qui sont dirigés
// $database->query("SELECT cr.`id_creneau`, cr.`Salle`, cr.`Jour`, cr.`Heure_Debut`, cr.`Heure_Fin` FROM `res_creneaux` cr LEFT JOIN `res_creneaux_date` crd USING(id_creneau) WHERE :date BETWEEN crd.Date_Debut AND crd.Date_Fin AND `Libre` = 'Non' ORDER BY cr.`Jour`, cr.`Heure_Debut`");
$database->query("SELECT `id_creneau`, `Salle`, `Jour`, `Heure_Debut`, `Heure_Fin` FROM `res_creneaux` WHERE `Libre` = 'Non' AND `Actif` = 'Oui' ORDER BY `Jour`, `Heure_Debut`");
//$database->bind(':date', date('Y-m-d'));
$result = $database->resultSet();

/*
id_creneau	 Salle	  Jour 	Heure_Debut Heure_Fin
    2 	     Coppée 	1 	20:00:00 	21:00:00
    3 	     Coppée 	1 	21:00:00 	22:30:00
	5 	    Coppée 	    2 	20:30:00 	22:30:00
	6 	    Coppée 	    3 	19:00:00 	20:30:00
	7 	    Coppée 	    3 	20:30:00 	22:00:00
   15 	    Coppée 	    6 	10:00:00 	11:30:00
 */

$data = array();

foreach($result as $r)
    $data[$r['id_creneau']] = sprintf( "%s %s de %s à %s", $r['Salle'], $JOUR_FR[$r['Jour']], formatHeure($r['Heure_Debut']), formatHeure($r['Heure_Fin']));

$tpl->assign('creneaux', $data);

//draw the template
$tpl->draw('adm_licencier');
?>