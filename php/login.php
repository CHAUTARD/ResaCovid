<?php
/*
 * login.php
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
$tpl->draw('login');
?>