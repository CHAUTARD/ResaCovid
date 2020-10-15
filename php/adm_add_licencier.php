<?php
/*  adm_add_licencier.php
 * Version : 1.0.2
 * Date : 2020.10-15
 *  
 *  Ajout, Modification d'un licencié
 *  
 *  array (size=11)
  'page' => string 'add_licencier' (length=13)
  'addLicence' => string '111' (length=3)
  'addCivilite' => string 'Mr' (length=2)
  'addNom' => string 'nom' (length=3)
  'addSurnom' => string 'surnom' (length=6)
  'addPrenom' => string 'prenom' (length=6)
  'addEquipe' => string '9' (length=1)
  'addTelephone' => string '12' (length=2)
  'addEmail' => string 'email@f' (length=7)
  'addOuvreur' => string 'Oui' (length=3)
  'addAdmin' => string '' (length=0)
  'addActif' => string 'Oui' (length=3)
  
  si les données arrive de la mise à jour de sa fiche par le licencié alors les deux derniers champs ne sont pas rempli.
 */

// Recherche si l'enregistrement existe
$database->query("SELECT id_licencier, Ouvreur, Admin, Actif FROM `res_licenciers` WHERE `id_licencier` = :id");
$database->bind(':id', $_GET['addLicence']);
$result = $database->single();

// Non -> Création
if($result === false) {
    $database->query('INSERT INTO `res_licenciers` (`id_licencier`, `Civilite`, `Nom`, `Surnom`, `Prenom`, `Equipe`, `Telephone`, `Email`, `Ouvreur`, `Admin`, `Actif`) VALUES (:id_licencier, :Civilite, :Nom, :Surnom, :Prenom, :Equipe, :Telephone, :Email, :Ouvreur, :Admin);');
    $msg = "Licencié(e) créé(e) !";
} else {
    // Oui -> Update
    $database->query('UPDATE `res_licenciers` SET `Civilite` = :Civilite, `Nom` = :Nom, `Surnom` = :Surnom, `Prenom` = :Prenom, `Equipe` = :Equipe, `Telephone` = :Telephone, `Email` = :Email, `Ouvreur` = :Ouvreur, `Admin` = :Admin, `Actif` = :Actif WHERE `id_licencier` = :id_licencier');
    $msg = "Licencié(e) modifié(e) !";
}

$Ouvreur = isset($_GET['addOuvreur']) ? $_GET['addOuvreur']: $result['Ouvreur'];
$Admin = isset($_GET['addAdmin']) ? $_GET['addAdmin'] : $result['Admin'];
$Actif = isset($_GET['addActif']) ? $_GET['addActif']: $result['Actif'];

$database->bind(':id_licencier', $_GET['addLicence'], PDO::PARAM_INT);
$database->bind(':Civilite', $_GET['addCivilite']);
$database->bind(':Nom', strtoupper($_GET['addNom']));
$database->bind(':Surnom', strtoupper($_GET['addSurnom'])); 
$database->bind(':Prenom', ucfirst($_GET['addPrenom']));
$database->bind(':Equipe', $_GET['addEquipe'], PDO::PARAM_INT);
$database->bind(':Telephone', $_GET['addTelephone'], PDO::PARAM_STR); 
$database->bind(':Email', $_GET['addEmail']);
$database->bind(':Ouvreur', $Ouvreur);
$database->bind(':Admin', $Admin, PDO::PARAM_STR);
$database->bind(':Actif', $Actif);

$database->execute();

//$database->Dump().

Die($msg);
?>