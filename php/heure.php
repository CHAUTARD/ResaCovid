<?php
/** heure.php
 * @version 1.0.1
 * @date : 2020-10-10
 */

// $_GET
//   'jour' => string '2020-09-16' (length=10)

// Recherche des informations sur le joueur connecté
$database->query("SELECT Nom, Prenom, Ouvreur FROM res_licenciers WHERE id_licencier = :id_licencier");
$database->bind('id_licencier', $_SESSION['id_licencier'], PDO::PARAM_INT);
$result = $database->single();

// Pas de résultat
// Le code ne correspond pas !
if( $result === false)
{
    header("Location: index.php?alert=Y");
    exit;
}

$joueur = sprintf('%s %s', $result['Prenom'], $result['Nom']);
$tpl->assign('joueur', $joueur);
$tpl->assign('nom', $result['Nom']);
$tpl->assign('id_licencier', $_SESSION['id_licencier']);

// Couleur du bouton pour le créneau
$btColor = array( 1 => 'btn-primary', 'btn-primary', 'btn-primary', 'btn-primary', 'btn-primary', 'btn-primary');

// Expand, colapse
$expand = array( 1 => 'true', 'true', 'true', 'true', 'true', 'true');

// Le licencié est-il un ouvreur potentiel
$isOuvreur = array( 1 => 'Non','Non','Non','Non','Non','Non');

if($result['Ouvreur'] == 'Oui')
    $isOuvreur = array( 1 => 'Oui','Oui','Oui','Oui','Oui','Oui');

// Date choisie dans l'écran précédant
$tpl->assign('datechoisie', strftime('%A %d %B', strtotime($_GET['jour'])));

// Date du jour
$dateNow = date_create();

// Exemple : 20256 -> 256 éme jours de 2020
$YearNumNow = date_format( $dateNow, 'yz');

$date = date_create($_GET['jour']);

// Exemple : 20256 -> 256 éme jours de 2020
$iDate = date_format( $date, 'yz');
$tpl->assign('dayofyear', $iDate);

// Jour de la semaine au format numérique
// 0 (pour dimanche) à 6 (pour samedi)
$dJour = date_format( $date, 'w');
// Dimanche = 7
if($dJour == 0) $dJour=7;

// Recherche des créneaux pour le jour choisi
$sql = sprintf('SELECT `id_creneau`, `Salle`, `Heure_Debut`,`Heure_Fin`, `id_ouvreur`, `Nbr_Place`, `Libre`, `Ord`  FROM `res_creneaux` WHERE `Jour` = %d ORDER BY Heure_Debut;', $dJour);
$database->query($sql);
$result = $database->resultSet();

// les creneaux
$idCreneau = array();

// Les ouvreurs
$ouvreur = array();

// Possible pour ce joueur
$isLibre = array();

// Les horaires
$horaire = array();

// Les inscripts
$inscript = array();

/* Recherche des creneaux de la journée */
$i = 1;
foreach($result as $r)
{
    // Nombre de places disponibles
    $nbrPlace = $r['Nbr_Place'];

    // Identifiant du créneau
    $idCreneau[$i] = $r['id_creneau'];
    
    // Un ouvreur déjà inscript pour ce créneau
    $database->query("SELECT `id_licencier` FROM `res_reservations` WHERE `id_creneau` = :id_creneau AND `iDate` = :iDate AND Ouvreur = 'Oui';");
    $database->bind(':id_creneau', $r['id_creneau']);
    $database->bind(':iDate', $iDate);
    $resultOuvreur = $database->single();
    
    // Si pas de résultat
    if( $resultOuvreur === false)
    {
        // Par défaut pas d'ouvreur
        $ouvreur[$i] = "Pas d'ouvreur présent";
        $btColor[$i] = 'btn-warning';
    }
    else
    {
        // Image plus le nom de l'ouvreur
        $ouvreur[$i] = '<img src="img/clefs.png" alt="Ouvreur" class="img-thumbnail" style="border:none;background:none;"  width="36"> ' . GetNomByNumLicence( $database, $resultOuvreur['id_licencier'] );
        
        // Déjà inscript comme ouvreur pour ce créneau
        if($_SESSION['id_licencier'] == $resultOuvreur['id_licencier'])
            $isOuvreur[$i] = 'Non';
    }
      
    // Recherche des numeros de licence des inscripts pour ce créneau
    $database->query("SELECT l.id_licencier, l.Nom, l.Prenom  FROM `res_reservations` r LEFT JOIN `res_licenciers` l ON r.id_licencier = l.id_licencier WHERE `id_creneau` = :id_creneau AND `iDate` = :iDate AND r.Ouvreur = 'Non';");
    $database->bind(':id_creneau', $r['id_creneau']);
    $database->bind(':iDate', $iDate);
    $resultJoueur = $database->resultSet();
    
    $nbrJoueur = count($resultJoueur);
    
    if($nbrJoueur == 0)
        $expand[$i] = 'false';
    
    // Mise en forme des horaires
    $horaire[$i] = sprintf("%s : %dh%02d - %dh%02d  (%d/%d)", $r['Salle'], substr($r['Heure_Debut'], 0, 2), substr($r['Heure_Debut'], 3, 2), substr($r['Heure_Fin'], 0, 2), substr($r['Heure_Fin'], 3, 2), $nbrJoueur, $r['Nbr_Place']);
    
    $dejaInscrit = false;
    
    // Recherche des noms des joueurs inscript
    foreach($resultJoueur as $rj)
    {      
        $NomInscrit = sprintf('%s %s', $rj['Prenom'], $rj['Nom']);
        
        if($rj['id_licencier'] == $_SESSION['id_licencier'])
        {
            $inscript[$i][] = array( 'mode' => 'MOD', 'nom' => $NomInscrit);
            $dejaInscrit = true;
        }
        else
            $inscript[$i][] = array( 'mode' => '---', 'nom' => $NomInscrit);
    }
        
    // Plus de places         
    if( $nbrJoueur >= $nbrPlace || $dejaInscrit)
    {
        $isLibre[$i] = 'Non';
        $btColor[$i] = 'btn-danger';
    }
    else
    {
        // Le jour sélectionné est-il aujourd'hui
        $jourJ = ( $YearNumNow == $iDate);
        
        if($jourJ)
        {
            // Le joueur peut s'inscrire sur ce créneau, si créneau de libre où dirigé tous les joueurs peuvent s'inscrire
            $isLibre[$i] = 'Oui';
        }
        else
        {
            // Le grand test créneau Libre où Dirigé
            if($r['Libre'] == 'Oui')
            {
                // Si aujourd'hui
    
                // Une seule inscription dans le groupe de créneau
                // Déjà inscript sur un créneau du groupe
                $database->query("SELECT COUNT(`id_licencier`) as Nbr FROM `res_reservations` WHERE `Ord` = :ord AND `iDate` = :iDate AND id_licencier = :id_licencier AND Ouvreur = 'Non';");
                $database->bind(':ord', $r['Ord']);
                $database->bind(':iDate', $iDate);
                $database->bind(':id_licencier', $_SESSION['id_licencier']);
                $resultOrd = $database->single();
                
                if($resultOrd === false)
                {
                    // Pas inscript sur un créneau de ce jour
                    $isLibre[$i] = 'Oui';
                }
                else
                {
                    // Déjà inscript dans un créneau de ce groupe
                    $isLibre[$i] = $resultOrd > 0 ? 'Non' : 'Oui';
                }
            }
            else 
            {
                // Créneaux dirigés 

                // Le joueur fait partie des prioritaires pour ce créneau
                $database->query("SELECT `id_prioritaire` FROM `res_prioritaires` WHERE `id_creneau` = :id_creneau AND `id_licencier` = :id_licencier;");
                $database->bind(':id_creneau', $r['id_creneau']);
                $database->bind(':id_licencier', $_SESSION['id_licencier']);
                $resultPrio = $database->single();
                
                if($resultPrio === false)
                    $isLibre[$i] = 'Non';
                else
                    $isLibre[$i] = 'Oui';         
      
            }
        }
    }
                          
    $i++;
}

$tpl->assign('btColor', $btColor );
$tpl->assign('expand', $expand );
$tpl->assign('isOuvreur', $isOuvreur );
$tpl->assign('horaire', $horaire);
$tpl->assign('idCreneau', $idCreneau);
$tpl->assign('ouvreur', $ouvreur);
$tpl->assign('inscript', $inscript);
$tpl->assign('isLibre', $isLibre);

//draw the template
$tpl->draw('heure');
?>