<?php
/*
 * adm_login.php
 * Version : 1.0.0
 */

try 
{
    $tpl->assign('alert', isset($_GET['alert']) && $_GET['alert'] == 'Y' ? 'Y' : 'N');
} 
catch (Exception $e) 
{
    $tpl->assign('alert', 'N');
}

//draw the template
$tpl->draw('adm_login');
?>