<?php
/* adm_traite_xls.php
 * Version : 1.0.1
 * Date : 2020-10-05
 * 
 * Importation des licenciers à partir de SPID
 * 
 */

$tpl->assign( 'titre', 'Importation SPID');

$informations = '';

if( isset($_POST['page']) ) // si formulaire soumis
{   
    $content_dir = 'upload/'; // dossier où sera déplacé le fichier
    
    $tmp_file = $_FILES['upload']['tmp_name'];
    
    if( !is_uploaded_file($tmp_file) )
    {
        $informations .= "<p>Le fichier est introuvable</p>";
    }
    else 
    {
        // on vérifie maintenant l'extension
        $type_file = $_FILES['upload']['type'];
        
        if( !strstr($type_file, 'xls') && !strstr($type_file, 'application/vnd.ms-excel') )
        {
            $informations .= "<p>Le fichier n'est pas un fichier Excel !</p>";
        }
        else
        {        
            // on copie le fichier dans le dossier de destination
            $name_file = $_FILES['upload']['name'];
            
            if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
            {
                $informations .= "<p>Impossible de copier le fichier dans $content_dir</p>";
            }
            else 
            {
                $informations .= '<p>Le fichier a bien été uploadé</p>';
               
                $fic = fopen($content_dir . $name_file, 'r');
            
                $tab=fgetcsv($fic,1024, "\t");
                $champs = count($tab);
                
                $informations .= '<p>Nombre de champs : ' . $champs . '</p>';
                 
                if($champs < 30)
                    $informations .= "<p>Le fichier à traiter n'est pas le bon !</p>";
                else 
                {                                      
                    $ligne = 0; // compteur de ligne
                    $lignes = array();
                    
                    // Tabulation
                    while($tab=fgetcsv($fic,1024, "\t"))
                    {
                        $ligne++;
                        
                        // Nettoyage des champs commencant par ="
                        for($i=0, $iMax = count($tab); $i < $iMax; $i++)
                        {
                            if(substr($tab[$i], 0, 2) == '="')
                                $tab[$i] = substr($tab[$i], 2, -1);
                            
                            $tab[$i] =  trim( $tab[$i]);
                        }
                        
                        // Affichage de chaque champ de la ligne en question
                        $id_licencier = $tab[0];
                        $Civilite = ($tab[1] == 'MR' ? 'Mr': 'Mme');
                        $Nom  = utf8_encode(strtoupper($tab[2]));
                        $Prenom = utf8_encode(ucfirst($tab[3]));
                        $PhoneT = formatTel($tab[27]);
                        $PhoneP = formatTel($tab[28]);
                        if($PhoneP == "" && $PhoneT > '')
                            $PhoneP = $PhoneT;
                        
                        // Email
                        switch($tab[29])
                        {
                            case '' :
                            case 'licences.fftt@vstt.com':
                            case 'licence.fftt@vstt.com':
                                $Email = 'pas.saisie@faux';
                                break;
                                
                            default:
                                $Email = $tab[29]; 
                        }
                                                                
                        // Recherche si l'enregistrement existe
                        $database->query("SELECT `id_licencier`, `Telephone`,`Email` FROM `res_licenciers` WHERE `id_licencier` = :id_licencier");
                        $database->bind(':id_licencier', $id_licencier);
                        $result = $database->single();
                        
                        // Non -> Création
                        if($result === false) {
                            $database->query('INSERT INTO `res_licenciers` (`id_licencier`, `Civilite`, `Nom`, `Prenom`, `Telephone`, `Email`) VALUES (:id_licencier, :Civilite, :Nom, :Prenom, :Telephone, :Email);');
                            $msg = "Créé(e) !";
                        } else {
                            // Oui -> Update
                            
                            // Le téléphone est renseigné en local, mais pas chez SPID
                            if(strlen($PhoneP) == 0 && strlen($result['Telephone'] > 0) )
                                $PhoneP = $result['Telephone'];
                            
                            // L'Email est renseigné en local, mais pas chez SPID
                            if(strlen($Email) == 0 && strlen($result['Email'] > 0) )
                                $Email = $result['Email'];
                                            
                            $database->query('UPDATE `res_licenciers` SET `Civilite` = :Civilite, `Nom` = :Nom, `Prenom` = :Prenom, `Telephone` = :Telephone, `Email` = :Email WHERE `id_licencier` = :id_licencier');
                            $msg = "Modifié(e) !";
                        }
                        
                        $database->bind(':id_licencier', $id_licencier, PDO::PARAM_INT);
                        $database->bind(':Civilite', $Civilite);
                        $database->bind(':Nom', $Nom);
                        $database->bind(':Prenom', $Prenom);
                        $database->bind(':Telephone', $PhoneP, PDO::PARAM_STR);
                        $database->bind(':Email', $Email, PDO::PARAM_STR);
                        
                        $database->execute();                       
                        
                        $lignes[] =array(
                            'Index' => $ligne,
                            'Licence' => $id_licencier,
                            'Civilite' => $Civilite,
                            'Nom' => $Nom,
                            'Prenom' => $Prenom,
                            'Telephone' => $PhoneP,
                            'Email' => $Email,
                            'Action' => $msg
                        );
                    }
                
                    fclose($fic);
                }

                $informations .= '<p>' . $ligne . ' lignes traitées !</p>';
            }
        }
    }
}
else 
    $informations .= "<p>Fichier à chargé non trouvé !</p>";

   
$tpl->assign('informations', $informations );
$tpl->assign('lignes', $lignes);

//draw the template
$tpl->draw('adm_traite_xls');
?>