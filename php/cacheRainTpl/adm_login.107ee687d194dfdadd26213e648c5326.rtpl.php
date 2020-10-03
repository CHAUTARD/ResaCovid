<?php if(!class_exists('raintpl')){exit;}?><!-- adm_login.html -->

<?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "header" );?>

<body class="text-center">
	<form class="form-signin" action="admin.php" method="post">

		<img class="mb-4" src="<?php echo $logo;?>" alt="<?php  echo LOGO_TITLE;?>" title="<?php  echo LOGO_TITLE;?>" />
     	<h1 class="h3 mb-3 font-weight-normal">Administration de la réservation des créneaux</h1>
     	
     	<!-- Error Alert -->
     	<?php if( $alert=='Y' ){ ?>
		<div class="alert alert-danger alert-dismissible fade show">
		    <strong>Erreur !</strong><br />Code d'utilisation inconnu !
		</div>
		<?php } ?>
		
     	<label for="nom" class="sr-only">Nom du joueur</label>
     	<input type="text" id="nom" name="nom" class="form-control" placeholder="Nom en majuscule" value="" pattern="[A-Z \-]+" required autofocus>
		<br />
		
		<label for="licence" class="sr-only">Mot de passe</label>
     	<input type="password" id="mdp" name="mdp" class="form-control" placeholder="Mot de passe" value="" required autofocus>
		<br />
		
		<input type="hidden" name="page" value="adm_menu">
     	<button class="btn btn-lg btn-primary btn-block" type="submit">Se connecter</button>
     	
     	<p class="mt-5 mb-3 text-muted">&copy; VSTT, Patrick CHAUTARD (2020)</p>
     	<p class="mt-5 mb-3 text-muted"><a href='https://fr.freepik.com/vecteurs/commercialisation'>Commercialisation vecteur créé par macrovector - fr.freepik.com</a></p>
     	<p class="mt-5 mb-3 text-muted"><a target="_blank" href="https://docs.google.com/document/d/1ruXVzn-4_qtp-bVetTzUiqoOh2hz9dJ-gA5PHGhZGHY/edit?usp=sharing">Documentation sur Google doc</a></p>
   </form>
</body>
</html>