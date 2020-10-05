<?php
/*
 * index.php
 * Version : 1.0.1
 * Date : 2020-10-05
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
setlocale(LC_ALL, 'fr_FR.UTF-8', 'fra');

require_once 'php/classes/raintpl.php';

// Les constante de paramétrage
require_once "php/constant.php";

require_once "php/classes/pdo.php";

$database = SimplePDO::getInstance();

// Les fonctions génériques
require_once 'php/functions.php';

// Appel de traitement en AJAX
if(isset($_GET) && isset($_GET['page']))
{
    include 'php/'.$_GET['page'].'.php';
    die();
}

if(isset($_POST) && isset($_POST['page']))
{
    switch( $_POST['page'] )
    {
        case 'jour':
        case 'heure':
            include 'php/' . $_POST['page'] . '.php';
            break;
    }
}
else 
{
    // Page login
    include 'php/login.php';  
}

die();