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

$LicNom = $_GET['LicNom'];

// LicNom numérique ou caractère
if(is_numeric($LicNom)) {
    // Recherche sur le numéro de licence
    $database->query("SELECT Nom, Prenom FROM `res_licenciers` WHERE `id_licencier` = :id");
    $database->bind(':id', $LicNom);
    $resultNP = $database->single();
    
    if($resultNP === false) {
        $data = array(
            'title' => "Licencié non trouvé !",
            'content' => 'Ce numéro de licence ne correspond à aucun joueur du club.'
       );
    } else  {
        // Existe déjà comme prioritaire
        $database->query("SELECT id_prioritaire FROM `res_prioritaires` WHERE `id_licencier` = :id AND `id_creneau` = :id_creneau");
        $database->bind(':id', $LicNom);
        $database->bind(':id_creneau', $_GET['id_creneau']);
        $result = $database->single();
        
        if($result === false) 
        {
            $database->query("INSERT INTO `res_prioritaires` (`id_prioritaire`, `id_creneau`, `id_licencier`) VALUES ( NULL, :id_creneau, :id_licencier);");
            $database->bind(':id_creneau', $_GET['id_creneau']);
            $database->bind(':id_licencier', $LicNom);
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
                'content' => sprintf( "%s %s est déjà inscrit !", $resultNP['Prenom'], $resultNP['Nom'])
            );
        }
    }  
} else {
    // Recherche sur le numéro de licence
    $database->query("SELECT li.id_licencier, li.Nom, li.Prenom FROM `res_licenciers` li LEFT JOIN  `res_prioritaires` pr USING(id_licencier)" .
        "WHERE ( li.`Nom` LIKE :nom OR li.`SurNom` LIKE :nom ) AND ISNULL(pr.`id_prioritaire`) ORDER BY Nom, Prenom");
    $database->bind(':nom', '%' . strtoupper($LicNom) . '%');
        
    $resultNP = $database->resultSet();
    
    if($resultNP === false) {
        $data = array(
            'title' => "Licencié non trouvé ou déjà présent!",
            'content' => 'Aucun licencié ne correspond à ce nom où surnom.'
        );
    } else  {
        // Combien d'enregistrement trouvé ?
        switch (count($resultNP) ) {
            case 0 :
                $data = array(
                    'title' => "Licencié non trouvé où déjà présent !",
                    'content' => 'Aucun licencié ne correspond à ce nom, surnom.'
                );
                break;
                
            case 1 :   
                // Existe déjà comme prioritaire
                $database->query("SELECT id_prioritaire FROM `res_prioritaires` WHERE `id_licencier` = :id AND `id_creneau` = :id_creneau");
                $database->bind(':id', $result['id_licencier']);
                $database->bind(':id_creneau', $_GET['id_creneau']);
                $result = $database->single();
                
                if($result === false)
                {               
                    $database->query("INSERT INTO `res_prioritaires` (`id_prioritaire`, `id_creneau`, `id_licencier`) VALUES ( NULL, :id_creneau, :id_licencier);");
                    $database->bind(':id_creneau', $_GET['id_creneau']);
                    $database->bind(':id_licencier', $result['id_licencier']);
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
                        'content' => sprintf( "%s %s est déjà inscrit !", $resultNP['Prenom'], $resultNP['Nom'])
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
    } 
}

die(json_encode($data));
?>