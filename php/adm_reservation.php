<?php
/** adm_reservation
 *      @version : 1.0.1
 *      @date : 2020-10-16
 * 
 * Consultation des réservations.
 * 
 */

$tpl->assign( 'titre', '<i class="far fa-calendar-alt"></i> Les réservations');

if(isset($_GET['moisPrevious']))
{
    // Calcul du mois précédent
    $date = new DateTime($_GET['moisPrevious']);
}
else 
{
    $date = new DateTime(); 
}

$mois = $date->format('m');

$moisClair = $MOIS_FR[ (int) $mois];
$year = $date->format('Y');

$date->modify("-1 month");
$tpl->assign('moisPrevious', $date->format('Y-m-d') );

$date->modify("+2 month");
$tpl->assign('moisNext', $date->format('Y-m-d') );

// Chercher la première date du mois
$PremiereDateMois = strtotime($year . "-" . $mois . "-01");

// Le premier jour du mois tombe sur quel jour de la semaine
$PremierJourMois =JourSemaine($PremiereDateMois);

// Trouver le nombre de jours dans le mois
// t 	Nombre de jours dans le mois 	28 à 31
$NombreJourMois = date("t", strtotime($PremiereDateMois));

// Chercher la dernière date du mois
$DernierJourMois = strtotime($year . "-" . $mois . "-" . $NombreJourMois);

// Décalage calculé pour trouver le nombre de cellules à ajouter
$decallageDebut = $PremierJourMois - 1;
$libreDevant = ($decallageDebut < 0) ? 7 - abs($decallageDebut) : $PremierJourMois - 1;

// le dernier jour du mois tombe quel jour de la semaine
$JourFinMois = JourSemaine($DernierJourMois);

// Numero du dernier jour du mois précédent
$date = new DateTime($year.'-'.$mois.'-01');
$date->sub( new DateInterval( "P1D" ));
$DernierJourMoisMoins1  = $date->format('d');

// Recherche des créneaux d'entrainement de tous les jours de la semaine
$database->query("SELECT `id_creneau`, `Salle`, `Jour`, `Heure_Debut`, `Heure_Fin`, `Libre`,  `Nbr_Place` FROM `res_creneaux` cr LEFT JOIN `res_salles` sa USING (id_salle) ORDER BY `Jour`, `Heure_Debut`");
$result = $database->resultSet();

// initialisation du tableau
$creneau = array( 1 => false, false, false, false, false, false, false);
    
foreach($result as $r)
{   
    $creneau[$r['Jour']][] = array(
        'id_creneau' => $r['id_creneau'],
        'libre' => $r['Libre'],
        'titre_salle' => sprintf("(%s) %s/%s (%%d/%d)", substr($r['Salle'], 0, 1), formatHeure($r['Heure_Debut']), formatHeure($r['Heure_Fin']), $r['Nbr_Place']),
        // Jour en clair pour la popup
        'titre_popup' => sprintf("(%s) %s %s/%s (%%d/%d)", substr($r['Salle'], 0, 1),  $JOUR_FR[$r['Jour']], formatHeure($r['Heure_Debut']), formatHeure($r['Heure_Fin']), $r['Nbr_Place'])
    );
}

$iCase = 1;
$case = array();

// Remplir les cases avant le début du mois
for($i = $libreDevant-1; $i >= 0; $i--)
{
    $case[$iCase] = array( 'Num' => $DernierJourMoisMoins1-$i, 'Outside' => 'outside' );
    $iCase++;
}

$tpl->assign('calendar_mois_annee', $moisClair . ' ' . $year);
$tpl->assign('calendar_event_day', "Pas d'événement pour aujourd'hui." );

$j = 1;
$j2 = 1;
for($i=$libreDevant+1; $i < 36; $i++)
{
    if($j > $NombreJourMois)
    {
        // Dernier jour du tableau, pas du mois visionné
        $case[$i] = array( 'Num' => $j2, 'Outside' => 'outside' );
        $j2++;
    }
    else 
    {
        // Recherche du jour de la semaine
        $dateJour = sprintf( '%d-%02d-%02d', $year, $mois, $j);
        
        // 1 - 7 Lundi .. Dimanche
        $JourSemaine = date('N', strtotime($dateJour));
        
        // Recherche du numero de jour dans l'année YYnnn
        $JourAnnee = date_format( date_create($dateJour), 'yz');
      
        $event = array( );
      
        /*
         * text-primary, text-secondary, text-success, text-danger, text-warning, text-info, text-light, text-dark, text-muted, text-white
         *
         * event all-day begin span-2 bg-warning
         * event all-day end bg-success
         */
        
        // Existe t'il des créneaux pour ce jour
        if( $creneau[$JourSemaine] === false)
        {
            // Pas d'événement ce jour
            $case[$i] = array(
                'Num' => $j,
                'Outside' => 'date'
            );
        }
        else 
        {
            foreach( $creneau[$JourSemaine] as $value)
            {                
                // Recherche du nombre de joueur sur ce créneau
                $database->query("SELECT count(*) as count FROM `res_reservations` WHERE `id_creneau`=:id_creneau AND `iDate`= :iDate And `Ouvreur`='Non';");
                $database->bind('id_creneau', $value['id_creneau']);
                $database->bind('iDate', $JourAnnee);
                $resultNbr = $database->single();
                
                // Nombre de joueur sur le créneau
                $Nbr =  ($resultNbr === false ? 0 : $resultNbr['count']);
                
                // En fonction du type de créneau Libre où Dirigé
                if($Nbr == 0)
                    $color = 'btn-info';
                else
                    $color = $value['libre'] == 'Oui' ? 'btn-primary' : 'btn-success';
                
                $event[] = array( 
                    'id_creneau' => $value['id_creneau'],
                    'iDate' => $JourAnnee,
                    'Nbr' => $Nbr,
                    'type' => $color, 
                    'name' => sprintf( $value['titre_salle'], $Nbr ),
                    'name_popup' => sprintf( $value['titre_popup'], $Nbr )
                );
            }
        
            $case[$i] = array(
               'Num' => $j,
               'Outside' => 'date', // 'outside'
               'event' => $event
            ); 
        }
    }

    $j++;
}

$tpl->assign('calendar_case', $case );

//draw the template
$tpl->draw('adm_reservation');
?>