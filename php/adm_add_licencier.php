<?php
/*  adm_add_licencier.php
 *      @version : 1.0.4
 *      @date : 2020.10-19
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
$database->query("SELECT id_licencier, Ouvreur, Admin, Actif FROM `res_licencies` WHERE `id_licencier` = :id");
$database->bind(':id', $_GET['addLicence']);
$result = $database->single();

// Mise en forme des Nom, Surnom et Prénom
$civiliteMr = ($_GET['addCivilite'] == 'Mr');
$nom = strtoupper($_GET['addNom']);
$surnom = strtoupper($_GET['addSurnom']);
$prenom = ucfirst(strtolower($_GET['addPrenom']));

// Non -> Création
if($result === false) {
    $database->query('INSERT INTO `res_licencies` (`id_licencier`, `Civilite`, `Nom`, `Surnom`, `Prenom`, `Equipe`, `Telephone`, `Email`, `Ouvreur`, `Admin`, `Actif`) VALUES (:id_licencier, :Civilite, :Nom, :Surnom, :Prenom, :Equipe, :Telephone, :Email, :Ouvreur, :Admin, :Actif);');
    if($civiliteMr)
    {
        $title = "Licencié créé !";
        $content = sprintf("Le licencié %s %s a été créé.", $prenom, $nom);
    }
    else
    {
        $title = "Licenciée créée !";
        $content = sprintf("La licenciée %s %s a été créé.", $prenom, $nom);
    }
} else {
    // Oui -> Update
    $database->query('UPDATE `res_licencies` SET `Civilite` = :Civilite, `Nom` = :Nom, `Surnom` = :Surnom, `Prenom` = :Prenom, `Equipe` = :Equipe, `Telephone` = :Telephone, `Email` = :Email, `Ouvreur` = :Ouvreur, `Admin` = :Admin, `Actif` = :Actif WHERE `id_licencier` = :id_licencier');
    if($civiliteMr)
    {
        $title = "Licencié modifié !";
        $content = sprintf("Le licencié %s %s a été modifié.", $prenom, $nom);
    }
    else 
    {
        $title = "Licenciée modifiée !";
        $content = sprintf("La licenciée %s %s a été modifié.", $prenom, $nom);
    }
}

$Ouvreur = isset($_GET['addOuvreur']) ? $_GET['addOuvreur']: $result['Ouvreur'];
$Admin = isset($_GET['addAdmin']) ? $_GET['addAdmin'] : $result['Admin'];
$Actif = isset($_GET['addActif']) ? $_GET['addActif']: $result['Actif'];

$database->bind(':id_licencier', $_GET['addLicence'], PDO::PARAM_INT);
$database->bind(':Civilite', $_GET['addCivilite']);
$database->bind(':Nom', $nom);
$database->bind(':Surnom', $surnom); 
$database->bind(':Prenom', $prenom);
$database->bind(':Equipe', $_GET['addEquipe'], PDO::PARAM_INT);
$database->bind(':Telephone', $_GET['addTelephone'], PDO::PARAM_STR); 
$database->bind(':Email', $_GET['addEmail']);
$database->bind(':Ouvreur', $Ouvreur);
$database->bind(':Admin', $Admin, PDO::PARAM_STR);
$database->bind(':Actif', $Actif);

$database->execute();

die(json_encode(array(
    'title' => $title,
    'content' => $content
)));
?>