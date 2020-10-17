<?php
/* adm_fftt_licence_num.php 
 *      @version : 1.0.0
 *      @date : 2020-10-17
 *
 *  Recherche d'un licencié par le numéro de licence sur la base FFTT
 *  
 */

$licence = $_GET['licence'];

if(intval($licence) == 0)
    die(0);

// Recherche du licencier par les API
require_once 'php/classes/Service.php';

$Api = new Service();

$data = $Api->getLicence($licence);

if(is_null($data))
    die(1);

die(json_encode($data));
?>