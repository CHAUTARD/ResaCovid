<?php
/* adm_traite_xls.php
 * Version : 1.0.0
 * Date : 2020-09-26
 * 
 * Importation des licenciers à partir de SPID
 * 
 */

include "php/templates/adm_header.html";

echo '<body>';

if( isset($_POST['page']) ) // si formulaire soumis
{   
    $content_dir = 'upload/'; // dossier où sera déplacé le fichier
    
    $tmp_file = $_FILES['upload']['tmp_name'];
    
    if( !is_uploaded_file($tmp_file) )
    {
        exit("Le fichier est introuvable");
    }
    
    // on vérifie maintenant l'extension
    $type_file = $_FILES['upload']['type'];
    
    if( !strstr($type_file, 'xls') && !strstr($type_file, 'application/vnd.ms-excel') )
    {
        exit("Le fichier n'est pas un fichier Excel !");
    }
    
    // on copie le fichier dans le dossier de destination
    $name_file = $_FILES['upload']['name'];
    
    if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
    {
        exit("Impossible de copier le fichier dans $content_dir");
    }
    
    echo '<div class="container"><div class="row"><div class="col">Le fichier a bien été uploadé</div>';
   
    $fic = fopen($content_dir . $name_file, 'r');

    $tab=fgetcsv($fic,1024, "\t");
    $champs = count($tab);
    
    echo '<div class="col">Nombre de champs : ' . $champs . '</div></div>';
     
    if($champs !== 30)
        exit("Le fichier à traiter n'est pas le bon !");
    
    /*
    echo '<div class="row"><div class="col">';
    //affichage de chaque champ de la ligne en question
    for($i=0; $i<$champs; $i ++)
        echo utf8_encode($tab[$i]) . " | ";
    echo '</div></div>';
    */
    
    echo '<br />';
    
    echo '<ul class="list-group ScrollYClass">';
        
    $ligne = 0; // compteur de ligne
    
    // Tabulation
    while($tab=fgetcsv($fic,1024, "\t"))
    {
        $ligne++;
        
        // Affichage de chaque champ de la ligne en question
        $id_licencier = substr($tab[0], 2, -1);
        $Civilite = (trim($tab[1]) == 'MR' ? 'Mr': 'Mme');
        $Nom  = utf8_encode(strtoupper(trim($tab[2])));
        $Prenom = utf8_encode(ucfirst(trim($tab[3])));
        $PhoneT = formatTel($tab[26]);
        $PhoneP = formatTel($tab[27]);
        if($PhoneP == "" && $PhoneT > '')
            $PhoneP = $PhoneT;
        
        $Email = trim($tab[28]); 
        if($Email == 'licence.fftt@vstt.com') $Email = 'pas.saisie@faux';
                        
        // Recherche si l'enregistrement existe
        $database->query("SELECT `id_licencier`, `Telephone`,`Email` FROM `res_licenciers` WHERE `id_licencier` = :id");
        $database->bind(':id', $id_licencier);
        $result = $database->single();
        
        // Non -> Création
        if($result === false) {
            $database->query('INSERT INTO `res_licenciers` (`id_licencier`, `Civilite`, `Nom`, `Prenom`, `Telephone`, `Email`) VALUES (:id_licencier, :Civilite, :Nom, :Prenom, :Telephone, :Email);');
            $msg = "Licence créé(e) !";
        } else {
            // Oui -> Update
            
            // Le téléphone est renseigné en local, mais pas chez SPID
            if(strlen($PhoneP) == 0 && strlen($result['Telephone'] > 0))
                $PhoneP = $result['Telephone'];
            
            // L'Email est renseigné en local, mais pas chez SPID
            if(strlen($Email) == 0 && strlen($result['Email'] > 0))
                $Email = $result['Email'];
                            
            $database->query('UPDATE `res_licenciers` SET `Civilite` = :Civilite, `Nom` = :Nom, `Prenom` = :Prenom, `Telephone` = :Telephone, `Email` = :Email WHERE `id_licencier` = :id_licencier');
            $msg = "Licence modifié(e) !";
        }
        
        $database->bind(':id_licencier', $id_licencier, PDO::PARAM_INT);
        $database->bind(':Civilite', $Civilite);
        $database->bind(':Nom', $Nom);
        $database->bind(':Prenom', $Prenom);
        $database->bind(':Telephone', $PhoneP, PDO::PARAM_STR);
        $database->bind(':Email', $Email);
        
        // $database->Dump();
        
        $database->execute();
        
        echo sprintf('<li class="list-group-item">%d) Lic : %d, %s %s %s Tel : %s, Email : %s (%s)</li>', $ligne, $id_licencier, $Civilite, $Nom, $Prenom, $PhoneP, $Email, $msg);
    }

    fclose($fic);
    echo "</ul>";
    echo $ligne . ' lignes traitées !';
}
else 
{
echo "Fichier chargé non trouvé !";
}
echo "</body></html>";
?>