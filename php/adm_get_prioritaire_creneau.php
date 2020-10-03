<?php
/* adm_get_prioritaire_creneau.php
 * 
 *  Recherche des prioritaire pour un créneau donné
 *
 *  $_GET['id'] = Numéro de créneau concerné
 */

// Recherche si l'enregistrement existe
$database->query("SELECT l.`Nom` as nom, l.`Prenom` as pre, l.id_licencier as lic FROM `res_prioritaires` p LEFT JOIN `res_licenciers` l USING (id_licencier) WHERE `id_creneau` = :id ORDER BY 2, 1");
$database->bind(':id', $_GET['id']);
$result = $database->resultSet();

$ret = array();
foreach($result as $r)
{   
    // Le licencié est-il l'ouvreur
    if( IsOuvreur( $database, $_GET['id'], $r['lic']) )
        $ret[] = array( 'cls' => 'fa-key', 'nom' => $r['pre'] . ' ' . $r['nom']);
    else
        $ret[] = array( 'cls' => 'fa-user-clock', 'nom' => $r['pre'] . ' ' . $r['nom']);
}

die(json_encode( $ret ));
?>