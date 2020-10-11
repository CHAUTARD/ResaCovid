<?php
/*   jour.php
 * 
 * Sélection du jour pour l'inscription à la réservation
 *  @version : 1.0.2
 *  @date : 2020-10-10
 */

/* Champ des tables de la base */

$tpl->assign('version', '1.00' );

if ( preg_match( '/^([A-Z \-]+)$/', strtoupper($_POST['nom']), $nom) == 0)
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
$sql = sprintf("SELECT * FROM res_licenciers WHERE (Actif = 1) AND ( Nom='%s' OR Surnom='%s') AND id_licencier=%d", $_POST['nom'], $_POST['nom'], $_POST['licence'] );

$database->query($sql);
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

function setTd($value='&nbsp;', $etat='OFF')
{   
    switch($etat)
    {
        case 'ON':
            return sprintf('<td><center>'.
            '<form action="index.php" method="get">'.
                '<input type="hidden" name="page" value="heure">'.
                '<input type="hidden" name="jour" id="jour" value="%s">'.
                '<button type="submit" class="btn btn-outline-primary">%s</button>'.
                '</form></center></td>', $value, date("d", strtotime($value)) );
            
        case 'TODAY':
            return sprintf('<td><center>'.
                '<form action="index.php" method="get">'.
                '<input type="hidden" name="page" value="heure">'.
                '<input type="hidden" name="jour" id="jour" value="%s">'.
                '<button type="submit" class="btn btn-outline-success">%s</button>'.
                '</form></center></td>', $value, date("d", strtotime($value)));
            
        case 'OFF':
            return sprintf('<td><center><button class="btn btn-secondary" disabled>%s</button></center></td>', date("d", strtotime($value)));  

    }
    return false;
}
?>