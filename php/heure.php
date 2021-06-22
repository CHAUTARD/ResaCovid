<?php
/** heure.php
 * @version 1.0.7
 * @date : 2021-06-20
 */

// $_GET
//   'jour' => string '2020-09-16' (length=10)

// Recherche des informations sur le joueur connecté
$database->query("SELECT Prenom, Ouvreur FROM res_licencies WHERE id_licencier = :id_licencier");
$database->bind('id_licencier', $_SESSION['id_licencier'], PDO::PARAM_INT);
$result = $database->single();

// Pas de résultat
// Le code ne correspond pas !
if( $result === false)
{
    header("Location: index.php?alert=Y");
    exit;
}

$tpl->assign('prenom', $result['Prenom']);
$tpl->assign('id_licencier', $_SESSION['id_licencier']);
$tpl->assign('nom', $_SESSION['nom']);

// Couleur du bouton pour le créneau
$btColor = array( 1 => 'btn-primary', 'btn-primary', 'btn-primary', 'btn-primary', 'btn-primary', 'btn-primary');
$btBgColor = array( 1 => '#007bff', '#007bff', '#007bff', '#007bff', '#007bff', '#007bff');

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
// 1 (pour lundi) à 7 (pour dimanche)
$dJour = date_format( $date, 'N');

// Recherche des créneaux pour le jour choisi
$database->query('SELECT `id_creneau`, sa.`Salle`, sa.`Color`, `Heure_Debut`, `Heure_Fin`, `id_ouvreur`, `Nbr_Place`, `Libre`, cr.`Ord`  FROM `res_creneaux` cr LEFT JOIN `res_salles` sa USING (id_salle) WHERE cr.`Actif` = "Oui" AND sa.`Active` = "Oui" AND cr.`Jour` = :jour ORDER BY cr.Heure_Debut;');
$database->bind(':jour', $dJour);

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
    // Couleur de fond du header de la card
    $btBgColor[$i] = $r['Color'];
    
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
        $ouvreur[$i] = '<img src="img/clefs.png" alt="Ouvreur" class="img-thumbnail" style="border:none;background:none;"  width="36"> ' . GetNomByNumLicence($resultOuvreur['id_licencier'] );
        
        // Déjà inscript comme ouvreur pour ce créneau
        if($_SESSION['id_licencier'] == $resultOuvreur['id_licencier'])
            $isOuvreur[$i] = 'Non';
    }
      
    // Recherche des numeros de licence des inscripts pour ce créneau
    $database->query("SELECT l.id_licencier, r.id_reservation, CONCAT( l.Prenom, ' ', l.Nom) as PN  FROM `res_reservations` r LEFT JOIN `res_licencies` l ON r.id_licencier = l.id_licencier WHERE `id_creneau` = :id_creneau AND `iDate` = :iDate AND r.Ouvreur = 'Non' ORDER BY Nom, Prenom;");
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
        if($rj['id_licencier'] == $_SESSION['id_licencier'])
        {
            $inscript[$i][] = array( 'mode' => 'MOD', 'id_reservation' => $rj['id_reservation'], 'nom' => $rj['PN']);
            $dejaInscrit = true;
        }
        else
            $inscript[$i][] = array( 'mode' => '---', 'id_reservation' => $rj['id_reservation'], 'nom' => $rj['PN']);
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
$tpl->assign('btBgColor', $btBgColor );
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