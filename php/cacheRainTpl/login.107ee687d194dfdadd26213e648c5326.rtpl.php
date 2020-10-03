<?php if(!class_exists('raintpl')){exit;}?><!-- login.html 
	Version : 1.0.0
	Date : 2020-10-03
-->

<?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "header" );?>

<body class="text-center">
	<form class="form-signin" action="index.php" method="post">

		<img class="mb-4" src="img/logo.gif" alt="<?php  echo LOGO_TITLE;?>" title="<?php  echo LOGO_TITLE;?>">
     	<h1 class="h3 mb-3 font-weight-normal">Sélection de créneau pour le tennis de table</h1>
     	
     	<!-- Error Alert -->
     	<?php if( $alert=='Y' ){ ?>
		<div class="alert alert-danger alert-dismissible fade show">
		    <strong>Erreur !</strong><br />Code d'utilisation inconnu !
		</div>
		<?php } ?>
		
     	<label for="nom" class="sr-only">Nom du joueur</label>
     	<input type="text" id="nom" name="nom" class="form-control" placeholder="Nom en majuscule" pattern="[A-Za-z \-]+" style="text-transform:uppercase" required autofocus>
		<br />
		
		<label for="licence" class="sr-only">Numéro de licence</label>
     	<input type="text" id="licence" name="licence" class="form-control" placeholder="Numéro de licence" pattern="[0-9]+" required autofocus>
		<br />
		
		<input type="hidden" name="page" value="jour">
     	<button class="btn btn-lg btn-primary btn-block" type="submit">Se connecter</button>
     	
     	<p class="mt-5 mb-3 text-muted">&copy; VSTT, Patrick CHAUTARD (2020)</p>
     	<p class="mt-5 mb-3 text-muted"><a target="_blank" href="https://docs.google.com/document/d/1Ha6CYmFDTwsbk9bmJgs4SVAzGatbEKfK1cqafPqyLLY/edit?usp=sharing">Documentation sur Google doc</a></p>
   </form>
</body>
</html>