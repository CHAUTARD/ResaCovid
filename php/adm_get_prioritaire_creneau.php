<?php
/** adm_get_prioritaire_creneau.php
 * 
 *      @version : 1.0.1
 *      @date : 2020-10-15
 * 
 *  Recherche des prioritaire pour un créneau donné
 *
 *  $_GET['id'] = Numéro de créneau concerné
 */

// Recherche si des enregistrements existent
$database->query("SELECT l.id_licencier, CONCAT( l.`Prenom`, ' ', l.`Nom`) as Nom FROM `res_prioritaires` p LEFT JOIN `res_licenciers` l USING (id_licencier) WHERE `id_creneau` = :id ORDER BY l.Nom, l.Prenom");
$database->bind(':id', $_GET['id'], PDO::PARAM_INT);
$result = $database->resultSet();

$ret = array();
foreach($result as $r)
{   
    // Le licencié est-il l'ouvreur
    if( IsOuvreur( $_GET['id'], $r['id_licencier']) )
        $ret[] = array( 'cls' => 'key', 'nom' => $r['Nom']);
    else
        $ret[] = array( 'cls' => 'user-clock', 'nom' => $r['Nom']);
}

die(json_encode( $ret ));
?>