<?php
/* adm_get_licenciers.php 
 *
 * Renvoi la liste de tous les licenciers trié par numéro de licence
 * .
 */

// Liste des licenciers
$database->query("SELECT * FROM res_licenciers ORDER BY Nom, Prenom");
$result = $database->resultSet();

$ret = '{ "data": [';

$first = '';

foreach($result as $value)
{
    $ret .= sprintf('%s[ %d, "%s", "%s", "%s", "%s", %d, "%s", "%s", "%s", "%s"]',
        $first,
        $value['id_licencier'],
        $value['Civilite'],
        $value['Nom'],
        $value['Surnom'],
        $value['Prenom'],
        $value['Equipe'], 
        $value['Telephone'], 
        $value['Email'], 
        $value['Ouvreur'],
        $value['Admin']
     );
    $first = ',';
}

die ( $ret . '] }');
?>