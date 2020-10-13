<?php
/*   jour.php
 * 
 * Sélection du jour pour l'inscription à la réservation
 *  @version : 1.0.3
 *  @date : 2020-10-12
 */

/* Champ des tables de la base */

$tpl->assign('version', '1.00' );

$nom = strtoupper($_POST['nom']);

if ( preg_match( '/^([A-Z \-]+)$/', $nom) == 0)
{
    header("Location: index.php?alert=Y");
    exit;
}

if ( preg_match( '/^([0-9]+)$/', $_POST['licence'], $licence) == 0)
{
    header("Location: index.php?alert=Y");
    exit;
}

// Recherche si le joueur existe
$database->query("SELECT * FROM res_licenciers WHERE (Actif = 1) AND ( Nom = :Nom OR Surnom = :Nom) AND id_licencier = :id_licencier");
$database->bind(':Nom', $nom);
$database->bind(':id_licencier', $_POST['licence'], PDO::PARAM_INT);
$result = $database->single();

// Le code ne correspond pas !
if( $result === false)
{
    header("Location: index.php?alert=Y");
    exit;
}

$_SESSION['id_licencier'] = $_POST['licence'];

// Date du jour
$tpl->assign('now', strftime('%A %d %B %Y'));

// Information sur le licencier
$tpl->assign('licencier', $result);

if($result['Telephone'] == '' || $result['Email'] == '' || $result['Email'] == 'pas.saisie@faux') {
    $tpl->assign('btn', 'btn-warning');
    $tpl->assign('btnMsg', 'Votre fiche licence est incomplète !');
} else { 
    $tpl->assign('btn', 'btn-primary');
    $tpl->assign('btnMsg', 'Consultation de votre fiche licence.');
}
        
// Recherche des jours de la semaine avec ou sans créneau
$database->query("SELECT DISTINCT(Jour) jj FROM `res_creneaux` ORDER BY Jour");
$result = $database->resultSet();

// 1 => Lundi .. 7 => Dimanche
// false => Pas de créneau
$aJour = array( 1 => false, false,false,false,false,false,false);
foreach($result as $r)
        $aJour[$r['jj']] = true;
    
// Mois Année avec la première lettre en majuscule
$tpl->assign('mois', ucfirst(strftime('%B %Y')));
 
// Jour de la semaine actuel
// 0 (pour dimanche) à 6 (pour samedi)
$dJour = date('w');
// Dimanche = 7
if($dJour == 0) $dJour=7;

$jour = date('Y-m-d');

$ret = '';
$ret2 = '';
$ret3 = '';

// Positionnement sur le 1er jour de la semaine
switch($dJour)
{        
    case 1: // Lundi
        $ret .= setTd( date('Y-m-d'), 'TODAY' );
        for($i =1; $i < 7; $i++)
            $ret .= setTd( calculeJour( $jour, 'P'.$i.'D'), 'ON');
            
        for(; $i < 14; $i++)
            $ret2 .= setTd( calculeJour( $jour, 'P'.$i.'D'), 'ON');
            
        for(; $i < 21; $i++)
            $ret3 .= setTd( calculeJour( $jour, 'P'.$i.'D'), 'ON');  
        break;
        
    case 2: // Mardi
        $ret .= setTd(calculeJourMoins( $jour, 'P1D')) . setTd( date('Y-m-d'), 'TODAY');
        
        for($i = 1; $i < 6; $i++)
            $ret .= setTd( calculeJour( $jour, 'P'.$i.'D'), 'ON');
            
        for( ; $i < 13; $i++)
            $ret2 .= setTd( calculeJour( $jour, 'P'.$i.'D'), 'ON');
                
         for( ; $i < 20; $i++)
             $ret3 .= setTd( calculeJour( $jour, 'P'.$i.'D'), 'ON');
          break;
        
    case 3: // Mercredi
        $ret .= setTd(calculeJourMoins( $jour, 'P2D')). setTd(calculeJourMoins( $jour, 'P1D')) . setTd( date('Y-m-d'), 'TODAY');   
        for($i = 1; $i < 5; $i++)
            $ret .= setTd( calculeJour( $jour, 'P'.$i.'D'), 'ON');
            
        for(; $i < 12; $i++)
            $ret2 .= setTd( calculeJour( $jour, 'P'.$i.'D'), 'ON');
            
        for(; $i < 19; $i++)
            $ret3 .= setTd( calculeJour( $jour, 'P'.$i.'D'), 'ON'); 
        break;
        
    case 4: // Jeudi
        $ret .=  setTd(calculeJourMoins( $jour, 'P3D')) . setTd(calculeJourMoins( $jour, 'P2D')). setTd(calculeJourMoins( $jour, 'P1D')) . setTd( date('Y-m-d'), 'TODAY');
        for($i = 1; $i < 4; $i++)
            $ret .= setTd( calculeJour( $jour, 'P'.$i.'D'), 'ON');
            
        for(; $i < 11; $i++)
            $ret2 .= setTd( calculeJour( $jour, 'P'.$i.'D'), 'ON');
            
        for(; $i < 18; $i++)
            $ret3 .= setTd( calculeJour( $jour, 'P'.$i.'D'), 'ON'); 
        break;
        
    case 5: // Vendredi
        $ret .= setTd(calculeJourMoins( $jour, 'P4D')) . setTd(calculeJourMoins( $jour, 'P3D')) . setTd(calculeJourMoins( $jour, 'P2D')).
        setTd(calculeJourMoins( $jour, 'P1D')) . setTd( date('Y-m-d'), 'TODAY');
        for($i = 1; $i < 3; $i++)
            $ret .= setTd( calculeJour( $jour, 'P'.$i.'D'), 'ON');
            
        for(; $i < 10; $i++)
            $ret2 .= setTd( calculeJour( $jour, 'P'.$i.'D'), 'ON');
            
        for(; $i < 17; $i++)
            $ret3 .= setTd( calculeJour( $jour, 'P'.$i.'D'), 'ON');
            break;
        break;
        
    case 6: // Samedi
        $ret .= setTd(calculeJourMoins( $jour, 'P5D')). setTd(calculeJourMoins( $jour, 'P4D')) . setTd(calculeJourMoins( $jour, 'P3D')) . 
        setTd(calculeJourMoins( $jour, 'P2D')). setTd(calculeJourMoins( $jour, 'P1D')) . setTd( date('Y-m-d'), 'TODAY') . setTd( calculeJour( $jour, 'P1D'), 'ON');
            
        for($i = 2; $i < 9; $i++)
            $ret2 .= setTd( calculeJour( $jour, 'P'.$i.'D'), 'ON');
            
        for(; $i < 16; $i++)
            $ret3 .= setTd( calculeJour( $jour, 'P'.$i.'D'), 'ON');
            break;
            
    case 7: // Dimanche
        $ret .= setTd(calculeJourMoins( $jour, 'P6D')) . setTd(calculeJourMoins( $jour, 'P5D')). setTd(calculeJourMoins( $jour, 'P4D')) .
        setTd(calculeJourMoins( $jour, 'P3D')) . setTd(calculeJourMoins( $jour, 'P2D')). setTd(calculeJourMoins( $jour, 'P1D')) .
        setTd( date('Y-m-d'), 'TODAY');
        
        for($i = 2; $i < 9; $i++)
            $ret2 .= setTd( calculeJour( $jour, 'P'.$i.'D'), 'ON');
            
            for(; $i < 16; $i++)
                $ret3 .= setTd( calculeJour( $jour, 'P'.$i.'D'), 'ON');
                break;
}

$tpl->assign('lgn1', $ret);
$tpl->assign('lgn2', $ret2);
$tpl->assign('lgn3', $ret3);

// Exemple : 20256 -> 256 éme jours de 2020
$iDate = date('yz');

// Recherche de toutes les réservation à venir
$database->query("SELECT re.`id_reservation` as id_reservation, re.`id_creneau` as id_creneau, re.`iDate` as iDate, cr.`Salle` as Salle, cr.`Heure_Debut` as Heure_Debut, cr.`Heure_Fin` as Heure_Fin FROM `res_reservations` re LEFT JOIN `res_creneaux` cr USING (id_creneau) WHERE `id_licencier` = :id_licencier AND `Ouvreur` = 'Non' AND `iDate` >= :iDate;");
$database->bind(':id_licencier', $_SESSION['id_licencier']);
$database->bind(':iDate', $iDate);


$reservations = $database->resultSet();

for( $i=0, $iLen = count($reservations); $i < $iLen; $i++) {
    // Transformation du iDate en Lundi jj mois
    $reservations[$i]['Date'] = quatiemeToDate( $reservations[$i]['iDate'] );
    $reservations[$i]['Heure_Debut'] = formatHeure( $reservations[$i]['Heure_Debut'] );
    $reservations[$i]['Heure_Fin'] = formatHeure( $reservations[$i]['Heure_Fin'] );
}

$tpl->assign('reservations', $reservations);

//draw the template
$tpl->draw('jour');

/*------------------------------------------------------------------------------------------------
 *     F o n c t i o n
 *------------------------------------------------------------------------------------------------*/

function quatiemeToDate( $yddd) {
    $timestamp = mktime( 0, 0, 0, 1, 1, 2000 + substr($yddd, 0, 2));
    $timestamp += substr($yddd, 2) * 86400;
       
    return ucwords( strftime("%A %d %B", $timestamp)) ;
}

// P1D veut dire 1 Jour, P2D veut dire 2 jours ...
function calculeJourMoins($jour, $duree=1 )
{
    $date = new DateTime($jour);
    $date->sub( new DateInterval( $duree ));
    return $date->format('Y-m-d'); 
}

function calculeJour($jour, $duree=1 )
{
    $date = new DateTime($jour);
    $date->add( new DateInterval( $duree ));
    return $date->format('Y-m-d');
}

function setTd($value='&nbsp;', $etat='OFF' )
{  
    global $aJour;
    
    // Jour du mois
    $J = date("d", strtotime($value));
    
    // Jour de la semaine 1 .. 7
    $N = date("N", strtotime($value));
    
    // Modification si jour est sans créneau
    switch($etat)
    {
        case 'ON':
            if( $aJour[$N] === false)
                return sprintf('<td><button class="btn btn-warning" title="Pas de créneau sur ce jour" disabled>%s</button></td>', $J);
            break;
            
        case 'TODAY':
            if( $aJour[$N] === false)
                return sprintf('<td><button class="btn btn-success" title="Pas de créneau aujourd\'hui" disabled>%s</button></td>', $J);
            break;
            
        case 'OFF':
            return sprintf('<td><button class="btn btn-secondary" title="Pas disponible" disabled>%s</button></td>', $J);  
    }
        
        
    switch($etat)
    {
        case 'ON':
            return sprintf('<td>'.
            '<form action="index.php" method="get">'.
                '<input type="hidden" name="page" value="heure">'.
                '<input type="hidden" name="jour" id="jour" value="%s">'.
                '<button type="submit" class="btn btn-outline-primary" title="Voir les créneaux">%s</button>'.
                '</form></td>', $value, $J );
            
        case 'TODAY':
            return sprintf('<td>'.
                '<form action="index.php" method="get">'.
                '<input type="hidden" name="page" value="heure">'.
                '<input type="hidden" name="jour" id="jour" value="%s">'.
                '<button type="submit" class="btn btn-outline-success" title="Voir les créneaux du jour">%s</button>'.
                '</form></td>', $value, $J);
    }
    return false;
}
?>