<?php
/** adm_get_prioritaire_creneau.php
 * 
 *      @version : 1.0.2
 *      @date : 2020-10-20
 * 
 *  Recherche de l'ouvreur et des prioritaires pour un créneau donné
 *
 *  $_GET['id'] = Numéro de créneau concerné
 */

$ret = array();

// Recherche de l'ouvreur pour les créneaux dirigés
$database->query("SELECT l.id_licencier, CONCAT( l.`Prenom`, ' ', l.`Nom`) as Nom FROM `res_creneaux` c LEFT JOIN `res_licencies` l ON l.id_licencier = c.id_ouvreur WHERE c.Libre = 'Non' AND `id_creneau` = :id ORDER BY l.Nom, l.Prenom");
$database->bind(':id', $_GET['id'], PDO::PARAM_INT);
$result = $database->single();

$idOuvreur = 0;
if($result !== false) {
    $ret[] = array( 'cls' => 'key', 'nom' => $result['Nom']);
    $idOuvreur = $result['id_licencier'];
}

// Recherche si des enregistrements existent
$database->query("SELECT l.id_licencier, CONCAT( l.`Prenom`, ' ', l.`Nom`) as Nom FROM `res_prioritaires` p LEFT JOIN `res_licencies` l USING (id_licencier) WHERE `id_creneau` = :id ORDER BY l.Nom, l.Prenom");
$database->bind(':id', $_GET['id'], PDO::PARAM_INT);
$result = $database->resultSet();

foreach($result as $r)
{   
    // L'ouvreur est déjà inscrit
    if($r['id_licencier'] == $idOuvreur)
        continue;
    
    // Le licencié est-il l'ouvreur ou son remplacant
    if( IsOuvreur( $_GET['id'], $r['id_licencier']) )
        $ret[] = array( 'cls' => 'key', 'nom' => $r['Nom']);
    else
        $ret[] = array( 'cls' => 'user-clock', 'nom' => $r['Nom']);
}

die(json_encode( $ret ));
?>