<?php
/*  adm_add_salle.php 
 * 
 *  @version : 1.0.0
 *  @date : 2021-06-22
 *  
 *  Ajout d'un creneau
 *  
 array (size=6)
  'page' => string 'add_salle' (length=9)
  'addIdSalle' => string '0' (length=1)
  'addSalle' => string 'essai' (length=5)
  'addColor' => string '#00ff00' (length=7)
  'addOrd' => string '1' (length=1)
  'addActive' => string 'Oui' (length=3)
*/
 
// 0 -> Création
if($_GET['addIdSalle'] == 0) {
    $database->query('INSERT INTO `res_salles` (`id_Salle`, `Salle`, `Color`, `Ord`, `Active`) VALUES (NULL, :Salle, :Color, :addOrd, :addActive);');
    $title = "Salle créée !";
    $content = "La nouvelle salle vient d'être créée";
    
} else {
    // Oui -> Update
    $database->query('UPDATE `res_salles` SET `Salle` = :Salle, `Color` = :Color, `Ord` = :addOrd, `Active` = :addActive WHERE `id_salle` = :id_salle');
    $database->bind(':id_creneau', $_GET['addCreneau']);
    $title = "Salle modifiée !";
    $content = "Les modifications ont été apportés a la salle.";
}

$database->bind(':id_salle', $_GET['addIdSalle']);
$database->bind(':Salle', $_GET['addSalle']);
$database->bind(':Color', $_GET['addColor']);
$database->bind(':addOrd', $_GET['addOrd'], PDO::PARAM_INT);
$database->bind(':addActive', $_GET['addActive']);
$database->execute();

Die(json_encode(array(
    'title' => $title,
    'content' => $content
)));
?>