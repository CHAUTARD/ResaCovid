<?php
/**   functions.php  
 *      @version : 1.0.1
 *      @date : 2020-10-14 
 */

// Les constantes tableau n'étant disponible qua partir de la version 5.6
$MOIS_FR = array( 1 => 'Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre');
$JOUR_FR = array( 1 => 'Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi', 'Dimanche');

/** Recherche du nom d'un joueur à partir de son numéro de licence
 * 
 * @param global $database
 * @param int $numLicence
 * @param int $lenNom = Longeur du nom à partir du début
 * @return string
 */
function GetNomByNumLicence($numLicence, $lenNom = 25)
{
    global $database;
    
    // Recherche des informations sur le joueur connexté
    $sql = sprintf("SELECT Nom, Prenom FROM res_licencies WHERE id_licencier=%d", $numLicence );
    
    $database->query($sql);
    $result = $database->single();
    
    // Pas de résultat
    if( $result === false)
        return false;
        
    return sprintf('%s %s', $result['Prenom'], substr( $result['Nom'], 0 , $lenNom));
}

/** Recherche des licenciers ouvreurs
 * 
 * @param global $database
 * @return string[]
 */
function GetOuvreurs()
{
    global $database;
    
    $database->query("SELECT `id_licencier`,  `Nom`,  `Prenom` FROM `res_licencies` WHERE Ouvreur = 'Oui' ORDER BY Nom, Prenom;");
    $result = $database->resultSet();
    
    $ret = array();
    foreach($result as $r)
        $ret[$r['id_licencier']] = $r['Prenom'] . ' ' . $r['Nom'];        

    return $ret;
}

/** Présence d'un ouvreur pour un créneau donné
 * 
 * @param global $database
 * @param int $idCreneau
 * @param int $idLicencier
 * @return boolean
 */
function IsOuvreur( $idCreneau, $idLicencier) 
{   
    global $database;
    
    $database->query("SELECT COUNT(*) FROM `res_creneaux` WHERE `id_ouvreur` = :id_licencier AND `id_creneau` = :id_creneau");
    $database->bind(':id_licencier', $idLicencier, PDO::PARAM_INT);
    $database->bind(':id_creneau', $idCreneau, PDO::PARAM_INT);
       
    $result = $database->single();
           
    if($result === false) return false;
    
    return $result['count'] == 1;
}

/** Formatage de l'heure
 * 
 * @param string time $p format HH:MM:SS
 * @return string format HHhMM
 */
function formatHeure($p) { return str_replace( ':', 'h', substr($p, 0, 5)); }

/** Mise en forme d'une date
 * 
 * @param string $originalDate     '09-01'
 * @return string                   '01/09'
 */
function formatDate($originalDate) { return date("d/m", strtotime('2020-' . $originalDate)); }

/*
 *                             0123456789
 * En entrée téléphone format :0102030405
 * En Sortie           format : 01.02.03.04.05
 */
function formatTel($numTel) {   
    $i=0;
    $j=0;
    $formate = "";
    while ($i<strlen($numTel)) { //tant qu il y a des caracteres
        if ($j < 2) {
            if (preg_match('/^[0-9]$/', $numTel[$i])) { //si on a bien un chiffre on le garde
                $formate .= $numTel[$i];
                $j++;
            }
            $i++;
        }
        else 
        { //si on a mis 2 chiffres a la suite on met un point
            $formate .= ".";
            $j=0;
        }
    }
    return $formate;
}

/** Le jour de la semaine
 * 
 * @param string $date
 * @return number
 */
function JourSemaine($date)
{
    // N 	Représentation numérique ISO-8601 du jour de la semaine = 1 (pour Lundi) à 7 (pour Dimanche)
    $dayOfWeek = date("N", $date);
    
    // w 	Jour de la semaine au format numérique 	0 (pour dimanche) à 6 (pour samedi)
    if (! is_numeric($dayOfWeek)) {
        
        $dayOfWeek = date("w", $date);
        
        if ($dayOfWeek == 0)
            $dayOfWeek = 7;
    }
    return $dayOfWeek;
}
?>