<?php
/** adm_exportation.php 
 * @version: 1.0.0
 * @date: 2020-10-06
 * 
 * Exportation des tables
 */

$tpl->assign( 'titre', '<i class="fas fa-file-upload"></i> Exportation en SQL');

//draw the template
$tpl->draw('adm_exportation');
?>