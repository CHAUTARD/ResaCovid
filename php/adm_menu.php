<?php
/*
 * adm_menu.php
 * Version : 1.0.1
 * Date 2020-09-28
 */
$tpl->assign('version', '1.00' );

// de adm_login -> adm_menu
if(isset($_POST['mdp']))
{
    if ( preg_match( '/^([A-Z \-]+)$/', $_POST['nom'], $nom) == 0)
    {
        header("Location: admin.php?alert=Y");
        exit;
    }
    
    if(strlen($_POST['mdp']) == 0)
    {
        header("Location: admin.php?alert=Y");
        exit;
    }
        
    // Recherche si le joueur existe
    $sql = sprintf('SELECT id_licencier FROM res_licenciers WHERE (Actif = 1) AND ( Nom = "%s" OR Surnom = "%s") AND Admin = "%s";', $_POST['nom'], $_POST['nom'], $_POST['mdp'] );  
    $database->query($sql);
    $result = $database->single();
        
    // Le code ne correspond pas !
    if( $result === false)
    {
        header("Location: admin.php?alert=Y");
        exit;
    }
    
    $_SESSION['id_licencier'] = $result['id_licencier'];
}

//draw the template
$tpl->draw('adm_menu');
?>