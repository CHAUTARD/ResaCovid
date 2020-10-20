<?php
/*
 * adm_menu.php
 * Version : 1.0.3
 * Date 2020-10-19
 */
$tpl->assign('version', '1.00' );

$nom = strtoupper($_POST['nom']);

// de adm_login -> adm_menu
if(isset($_POST['mdp']))
{
    if ( preg_match( '/^([A-Z \-]+)$/', $nom, $nom2) == 0)
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
    $database->query('SELECT id_licencier FROM res_licencies WHERE (Actif = "Oui") AND ( Nom = :nom OR Surnom = :nom) AND Admin =:passwd;');  
    $database->bind(':nom', $nom);
    $database->bind(':passwd', $_POST['mdp']);
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