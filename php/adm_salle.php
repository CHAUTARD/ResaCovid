<?php
/**
 * adm_salle.php
 * 
 *      @version : 1.0.0
 *      @date : 2021-06-20
 */

$tpl->assign( 'titre', '<i class="fa-solid fa-map-location-dot"></i> Les salles');

// Recherche de tous les créneaux qui sont dirigés
$database->query("SELECT * FROM `res_salles` ORDER BY Ord");
$result = $database->resultSet();

/*
id_salle 	Salle 	Color 	Ord 	Active 		
    1 	    Coppée 	99FF33 	  1 	 Oui 	
 */

$data = array();

foreach($result as $r)
{
    // La salle est utilisée combien de fois
    $database->query("SELECT COUNT(*) as count FROM `res_creneaux` WHERE id_salle = :id_salle");
    $database->bind('id_salle', $r['id_salle']);
    $resultNbr = $database->single();
    
    // Nombre de joueur sur le créneau
    $Nbr =  ($resultNbr === false ? 0 : $resultNbr['count']);
    
    $data[] = array(
        'id_salle' => $r['id_salle'],
        'Salle' => $r['Salle'],
        'Color' => $r['Color'],
        'Ord' => $r['Ord'],
        'Active' => $r['Active'],
        'Nbr' => $Nbr
    );
}

$tpl->assign('salles', $data);

//draw the template
$tpl->draw('adm_salle');
?>