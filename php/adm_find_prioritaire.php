<?php
/* adm_find_prioritaire.php 
 *      @version : 1.0.0
 *      @date : 2020-10-16
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
    $result = $database->single();
    
    if($result === false) {
        $data = array(
            'title' => "Licencié non trouvé !",
            'content' => 'Aucun licencié ne correspond à ce numéro de licence.'
       );
    } else  {
        $database->query("INSERT INTO `res_prioritaires` (`id_prioritaire`, `id_creneau`, `id_licencier`) VALUES ( NULL, :id_creneau, :id_licencier);");
        $database->bind(':id_creneau', $_GET['id_creneau']);
        $database->bind(':id_licencier', $LicNom);
        $database->execute();
        
        $data = array(
            'title' => "Licencié trouvé !",
            'content' => sprinf( "%s %s ajouté !", $result['Prenom'], $result['Nom'])
        );
    }  
} else {
    // Recherche sur le numéro de licence
    $database->query("SELECT id_licencier, Nom, Prenom FROM `res_licenciers` WHERE `Nom` LIKE :nom OR 'SurNom LIKE %nom' ORDER BY Nom, Prenom");
    $database->bind(':nom', '%' . $LicNom . '%');
    $result = $database->resultSet();
    
    if($result === false) {
        $data = array(
            'title' => "Licencié non trouvé !",
            'content' => 'Aucun licencié ne correspond à ce nom.'
        );
    } else  {
        // Combien d'enregistrement trouvé ?
        switch (count($result) ) {
            case 0 :
                $data = array(
                    'title' => "Licencié non trouvé !",
                    'content' => 'Aucun licencié ne correspond à ce nom.'
                );
                break;
                
            case 1 :         
                $database->query("INSERT INTO `res_prioritaires` (`id_prioritaire`, `id_creneau`, `id_licencier`) VALUES ( NULL, :id_creneau, :id_licencier);");
                $database->bind(':id_creneau', $_GET['id_creneau']);
                $database->bind(':id_licencier', $result['id_licencier']);
                $database->execute();
                
                $data = array(
                    'title' => "Licencié trouvé !",
                    'content' => sprintf( "%s %s ajouté !", $result['Prenom'], $result['Nom'])
                );
                break;
                
            default:
                $msg = "Plusieurs licenciés correspondent :<br /><ul>";
                foreach($result as $r) {
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