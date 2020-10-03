<?php
/* adm_exportation_table.php
 * 
 */

$entete  = "-- ----------------------\n";
$entete .= "-- dump de la base " . $database->_DBNAME." au ".date("d-M-Y")."\n";
$entete .= "-- ----------------------\n\n\n";
$creations = "";
$insertions = "\n\n";

$database->query("show tables");
$resultset = $database->resultSet();

foreach( $resultset as $r)
{
    $table = $r['Tables_in_vsttreservation'];
     
    // structure ou la totalité de la BDD
    $creations .= "-- ---------------------------------------\n";
    $creations .= "-- Structure de la table ".$table."\n";
    $creations .= "-- ---------------------------------------\n";
    
    $database->query("show create table ".$table);
    $listeCreationsTables = $database->resultSet();
    
    foreach($listeCreationsTables as $creationTable)
        $creations .= $creationTable['Create Table'].";\n\n";

    // Totalité
    $database->query("SELECT * FROM ".$table);
    $donnees = $database->resultSet();
    
    $insertions .= "-- --------------------------------------\n";
    $insertions .= "-- Contenu de la table ".$table."\n";
    $insertions .= "-- --------------------------------------\n";
    foreach($donnees as $colonnes)
    {
        $insertions .= "INSERT INTO ".$table." VALUES(";
        
        $i=0;
        foreach($colonnes as $key => $col)
        {
            if($i != 0)
                $insertions .=  ", ";
            
            $insertions .=  "'" . addslashes($col) . "'";
            
            $i++;
        }

        $insertions .=  ");\n";
    }
    $insertions .= "\n";
}

$fichierDump = fopen("sql/vsttreservation-".date("Ymdhis").".sql", "wb");
fwrite($fichierDump, $entete);
fwrite($fichierDump, $creations);
fwrite($fichierDump, $insertions);
fclose($fichierDump);

echo "Sauvegarde terminée";
?>