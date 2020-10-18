<?php
/* admin.php
 * 
 * @version : 1.0.2
 * @date : 2020-10-11
 */

// Rapporte les erreurs pour la DODEV. Les autres, vous n'aurez rien ! nada !!!
error_reporting( E_ALL & ~ E_NOTICE ); // Rapporte toutes les erreurs à part les E_NOTICE
//    error_reporting( 0 ); // Désactiver le rapport d'erreurs

session_save_path( 'templates' );
if (!isset($_SESSION)) {
    if( ! session_start() )
    {
        alert ( 'Démarrage session impossible !' );
        die();
    }
}

date_default_timezone_set('Europe/Paris');
setlocale(LC_ALL, 'fr_FR.UTF-8');

require_once 'php/classes/raintpl.php';

// Les constante de paramétrage
require_once "php/constant.php";

require_once "php/classes/pdo.php";

$database = SimplePDO::getInstance();

// Les fonctions génériques
require_once 'php/functions.php';

// Logo de l'association
$tpl->assign('logo', 'img/logo.gif');

// Version de php du serveur
$tpl->assign('phpversion', phpversion() );
$tpl->assign('mysqlVersion', $database->GetMysqlVersion() );

// Appel de traitement en AJAX

if(isset($_GET) && isset($_GET['page']))
{   
    include 'php/adm_'.$_GET['page'].'.php';
    die();
}

if(isset($_POST) && isset($_POST['page']))
{     
    switch( $_POST['page'] )
    {
        case 'adm_menu':
        case 'adm_licencier':
        case 'adm_creneau':
        case 'adm_priorite':
        case 'adm_prioritaire':
        case 'adm_reservation':
        case 'adm_importation':
        case 'adm_database_dump':
        case "adm_traite_xls":
        case 'adm_clean':
        case 'adm_clean_reservation':
        case 'adm_clean_prioritaire':
        case 'adm_clean_creneau' :
        case 'adm_stat_prioritaire':
            include 'php/' . $_POST['page'] . '.php';
            break;
    }
}
else 
{
    // Page login
    include 'php/adm_login.php';  
}

die();