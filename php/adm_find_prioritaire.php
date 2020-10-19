<?php
/* adm_find_prioritaire.php 
 *      @version : 1.0.1
 *      @date : 2020-10-19
 *
 *  Recherche des créneaux prioritaire pour un licencié donné
 *  
 *  $_GET

    array (size=3)
      'page' => string 'find_prioritaire' (length=16)
      'LicNom' => string 'chau' (length=4)
      'id_creneau' => string '2' (length=1)
 */

$LicNom = trim($_GET['LicNom']);

// LicNom numérique ou caractère
if(is_numeric($LicNom)) {
    // Recherche sur le numéro de licence
    $database->query("SELECT Nom, Prenom FROM `res_licenciers` WHERE `id_licencier` = :id" );
    $database->bind(':id', $LicNom, PDO::PARAM_INT);
    $resultNP = $database->single();
    
    if($resultNP === false) {
        $data = array(
            'title' => "Licencié non trouvé !",
            'content' => 'Ce numéro de licence ne correspond à aucun joueur du club.'
       );
    } else  {      
        // Le licencier est t'il déjà prioritaire sur ce créneau
        $database->query("SELECT id_prioritaire FROM  `res_prioritaires` WHERE pr.id_creneau = :id_creneau AND `id_licencier` = :id_licencier");
        $database->bind(':id_creneau', $_GET['id_creneau'], PDO::PARAM_INT);
        $database->bind(':id_licencier', $LicNom, PDO::PARAM_INT);
        $result = $database->resultSet();
        
        if($result === false || count($result == 0)) {
            $database->query("INSERT INTO `res_prioritaires` (`id_prioritaire`, `id_creneau`, `id_licencier`) VALUES ( NULL, :id_creneau, :id_licencier);");
            $database->bind(':id_creneau', $_GET['id_creneau'], PDO::PARAM_INT);
            $database->bind(':id_licencier', $LicNom, PDO::PARAM_INT);
            $database->execute();
            
            $data = array(
                'title' => "Licencié trouvé !",
                'content' => sprintf( "%s %s ajouté !", $resultNP['Prenom'], $resultNP['Nom'])
            );
        }
        else
        {
            $data = array(
                'title' => "Licencié existe déjà !",
                'content' => sprintf( "%s %s est déjà inscrit comme prioritaire pour ce créneau !", $resultNP['Prenom'], $resultNP['Nom'])
            );
        }
    }
    die(json_encode($data));
}

// Recherche sur le nom du licence
$database->query("SELECT id_licencier, Nom, Prenom FROM `res_licenciers` WHERE `Nom` LIKE :nom OR `SurNom` LIKE :nom ORDER BY Nom, Prenom");
$database->bind(':nom', '%' . strtoupper($LicNom) . '%');
    
$resultNP = $database->resultSet();
      
if($resultNP === false) {
    $data = array(
        'title' => "Licencié non trouvé !",
        'content' => 'Aucun licencié ne correspond à ce nom où surnom (' . strtoupper($LicNom) . ').'
    );
    die(json_encode($data));
} 

// Combien d'enregistrement trouvé ?
switch (count($resultNP) ) {
    case 0 :
        $data = array(
            'title' => "Licencié non trouvé !",
            'content' => 'Aucun licencié ne correspond à ce nom, surnom.'
        );
        break;
        
    case 1 :  
        $idLicencier = $resultNP[0]['id_licencier'];
        $Nom = $resultNP[0]['Nom'];
        $Prenom = $resultNP[0]['Prenom'];
        
        // Le licencier est t'il déjà prioritaire sur ce créneau
        $database->query("SELECT id_prioritaire FROM  `res_prioritaires` WHERE pr.id_creneau = :id_creneau AND `id_licencier` = :id_licencier");
        $database->bind(':id_creneau', $_GET['id_creneau'], PDO::PARAM_INT);  
        $database->bind(':id_licencier', $idLicencier, PDO::PARAM_INT);   
        $result = $database->resultSet();
        
        if($result === false || count($result == 0)) {
            $database->query("INSERT INTO `res_prioritaires` (`id_prioritaire`, `id_creneau`, `id_licencier`) VALUES ( NULL, :id_creneau, :id_licencier);");
            $database->bind(':id_creneau', $_GET['id_creneau'], PDO::PARAM_INT);
            $database->bind(':id_licencier', $idLicencier, PDO::PARAM_INT);
            $database->execute();
            
            $data = array(
                'title' => "Licencié trouvé !",
                'content' => sprintf( "%s %s ajouté !", $Prenom, $Nom)
            );
        }
        else 
        {
            $data = array(
                'title' => "Licencié existe déjà !",
                'content' => sprintf( "%s %s est déjà inscrit comme prioritaire pour ce créneau !", $Prenom, $Nom)
            );
        }
        break;
        
    default:
        $msg = "Plusieurs licenciés correspondent :<br /><ul>";
        foreach($resultNP as $r) {
            $msg .= sprintf( "<li> Lic : %d\t=>\t%s %s</li>", $r['id_licencier'], $r['Prenom'], $r['Nom']) ;
        }
        $msg .= '</ul>';
        
        $data = array(
            'title' => "Licenciés trouvés !",
            'content' => $msg
        );
}

die(json_encode($data));
?>