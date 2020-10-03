<?php if(!class_exists('raintpl')){exit;}?><!-- heure.html -->

<?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "header" );?>

<body>
	<div class="container h-100">	
		<div class="alert alert-dark" my-3>
			<div class="d-flex align-items-center text-white-50 bg-purple rounded box-shadow">
	        	<img class="mr-3" width="96" height="96" src="img/logo.gif" text="<?php  echo LOGO_TITLE;?>" alt="<?php  echo LOGO_TITLE;?>">
	        	<div class="lh-100 align-items-center">
	          		<h1 class="mb-0 text-white">Choix de l'horaire du <?php echo $datechoisie;?></h1>   
	          		<br />		
	        		<h6 class="mx-auto" style="width: 250px;"><?php echo $now;?></h6>
	        	</div>
	      	</div>
		</div>
		
		<br />
	    <div class="alert alert-info">
    		<p><h4><center>Bonjour, <?php echo $joueur;?></center></h4></p>
		</div> 
		<br />
			
		<?php if( $horaire["1"] > '' ){ ?>					
		<div class="row">
			<div class="col-sm-4">	
				<div class="card">
					<div class="card-header">
						<h5>
							<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse1" aria-expanded="false" aria-controls="collapse1"><i class="fap fa fa-plus"></i> <?php echo $horaire["1"];?></button>
							<?php if( $isLibre["1"] == 'Oui' ){ ?>
								<br /><br /><a href="#" onclick="AddJoueur( <?php echo $dayofyear;?>, <?php echo $idCreneau["1"];?>)" class="btn btn-primary" alt="M'ajouter dans la liste des joueurs" title="M'ajouter dans la liste des joueurs"><i class="far fa-check-square" aria-hidden="true"></i> Ajout</a>
							<?php } ?>
						</h5>
					</div>
					<div class="collapse" id="collapse1">
						<div class="card-body">
							<h5 class="card-title">
								<?php if( $isOuvreur["1"] == 'Oui' ){ ?>
								<a href="#" onclick="AddOuvreur( <?php echo $dayofyear;?>, <?php echo $idCreneau["1"];?>)" class="btn btn-primary" alt="Me positionner comme ouvreur" title="Me positionner comme ouvreur"><i class="fas fa-key"></i></a>&nbsp;
								<?php } ?>
								<?php echo $ouvreur["1"];?>
							</h5>
						</div>
						<ul class="list-group list-group-flush">
						    <?php $counter1=-1; if( !is_null($inscript["1"]) && is_array($inscript["1"]) && sizeof($inscript["1"]) ) foreach( $inscript["1"] as $key1 => $value1 ){ $counter1++; ?>
						    	<li class="list-group-item"><?php if( $value1["mode"] == 'MOD' ){ ?><a href="#" onclick="DelCreneau( <?php echo $dayofyear;?>, <?php echo $idCreneau["1"];?>)" class="btn btn-primary" alt="Supprimer cette réservation" title="Supprimer cette réservation"> - </a>&nbsp;<?php } ?><?php echo $value1["nom"];?></li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
			
			<?php if( $horaire["2"] > '' ){ ?>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-header">
						<h5>
							<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2"><i class="fap fa fa-plus"></i> <?php echo $horaire["2"];?></button>
							<?php if( $isLibre["2"] == 'Oui' ){ ?>
								<br /><br /><a href="#" onclick="AddJoueur( <?php echo $dayofyear;?>, <?php echo $idCreneau["2"];?>)" class="btn btn-primary" alt="M'ajouter dans la liste des joueurs" title="M'ajouter dans la liste des joueurs"><i class="far fa-check-square" aria-hidden="true"></i> Ajout</a>
							<?php } ?>
						</h5>
					</div>
					<div class="collapse" id="collapse2">
						<div class="card-body">
							<h5 class="card-title">
								<?php if( $isOuvreur["2"] == 'Oui' ){ ?>
								<a href="#" onclick="AddOuvreur( <?php echo $dayofyear;?>, <?php echo $idCreneau["2"];?>)" class="btn btn-primary" alt="Me positionner comme ouvreur" title="Me positionner comme ouvreur"><i class="fas fa-key"></i></a>&nbsp;
								<?php } ?>
								<?php echo $ouvreur["2"];?>
							</h5>
						</div>
						<ul class="list-group list-group-flush">
						    <?php $counter1=-1; if( !is_null($inscript["2"]) && is_array($inscript["2"]) && sizeof($inscript["2"]) ) foreach( $inscript["2"] as $key1 => $value1 ){ $counter1++; ?>
						    	<li class="list-group-item"><?php if( $value1["mode"] == 'MOD' ){ ?><a href="#" onclick="DelCreneau( <?php echo $dayofyear;?>, <?php echo $idCreneau["2"];?>)" class="btn btn-primary" alt="Supprimer cette réservation" title="Supprimer cette réservation"> - </a>&nbsp;<?php } ?><?php echo $value1["nom"];?></li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
			<?php } ?>
			
			<?php if( $horaire["3"] > '' ){ ?>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-header">
						<h5>
							<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3"><i class="fap fa fa-plus"></i> <?php echo $horaire["3"];?></button>
							<?php if( $isLibre["3"] == 'Oui' ){ ?>
								<br /><br /><a href="#" onclick="AddJoueur( <?php echo $dayofyear;?>, <?php echo $idCreneau["3"];?>)" class="btn btn-primary" alt="M'ajouter dans la liste des joueurs" title="M'ajouter dans la liste des joueurs"><i class="far fa-check-square" aria-hidden="true"></i> Ajout</a>
							<?php } ?>
						</h5>
					</div>
					<div class="collapse" id="collapse3">
						<div class="card-body">
							<h5 class="card-title">
								<?php if( $isOuvreur["3"] == 'Oui' ){ ?>
								<a href="#" onclick="AddOuvreur( <?php echo $dayofyear;?>, <?php echo $idCreneau["3"];?>)" class="btn btn-primary" alt="Me positionner comme ouvreur" title="Me positionner comme ouvreur"><i class="fas fa-key"></i></a>&nbsp;
								<?php } ?>
								<?php echo $ouvreur["3"];?>
							</h5>
						</div>
						<ul class="list-group list-group-flush">
						    <?php $counter1=-1; if( !is_null($inscript["3"]) && is_array($inscript["3"]) && sizeof($inscript["3"]) ) foreach( $inscript["3"] as $key1 => $value1 ){ $counter1++; ?>
						    	<li class="list-group-item"><?php if( $value1["mode"] == 'MOD' ){ ?><a href="#" onclick="DelCreneau( <?php echo $dayofyear;?>, <?php echo $idCreneau["3"];?>)" class="btn btn-primary" alt="Supprimer cette réservation" title="Supprimer cette réservation"> - </a>&nbsp;<?php } ?><?php echo $value1["nom"];?></li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
		
		<?php if( $horaire["4"] > '' ){ ?>
		<br />
		<div class="row">
			<div class="col-sm-4">
				<div class="card">
					<div class="card-header">
						<h5>
							<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4"><i class="fap fa fa-plus"></i> <?php echo $horaire["4"];?></button>
							<?php if( $isLibre["4"] == 'Oui' ){ ?>
								<br /><br /><a href="#" onclick="AddJoueur( <?php echo $dayofyear;?>, <?php echo $idCreneau["4"];?>)" class="btn btn-primary" alt="M'ajouter dans la liste des joueurs" title="M'ajouter dans la liste des joueurs"><i class="far fa-check-square" aria-hidden="true"></i> Ajout</a>
							<?php } ?>
						</h5>
					</div>
					<div class="collapse" id="collapse4">
						<div class="card-body">
							<h5 class="card-title">
								<?php if( $isOuvreur["4"] == 'Oui' ){ ?>
								<a href="#" onclick="AddOuvreur( <?php echo $dayofyear;?>, <?php echo $idCreneau["4"];?>)" class="btn btn-primary" alt="Me positionner comme ouvreur" title="Me positionner comme ouvreur"><i class="fas fa-key"></i></a>&nbsp;
								<?php } ?>
								<?php echo $ouvreur["4"];?>
							</h5>
						</div>
						<ul class="list-group list-group-flush">
						    <?php $counter1=-1; if( !is_null($inscript["4"]) && is_array($inscript["4"]) && sizeof($inscript["4"]) ) foreach( $inscript["4"] as $key1 => $value1 ){ $counter1++; ?>
						    	<li class="list-group-item"><?php if( $value1["mode"] == 'MOD' ){ ?><a href="#" onclick="DelCreneau( <?php echo $dayofyear;?>, <?php echo $idCreneau["4"];?>)" class="btn btn-primary" alt="Supprimer cette réservation" title="Supprimer cette réservation"> - </a>&nbsp;<?php } ?><?php echo $value1["nom"];?></li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
			
			<?php if( $horaire["5"] > '' ){ ?>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-header">
						<h5>
							<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapse5"><i class="fap fa fa-plus"></i> <?php echo $horaire["5"];?></button>
							<?php if( $isLibre["5"] == 'Oui' ){ ?>
								<br /><br /><a href="#" onclick="AddJoueur( <?php echo $dayofyear;?>, <?php echo $idCreneau["5"];?>)" class="btn btn-primary" alt="M'ajouter dans la liste des joueurs" title="M'ajouter dans la liste des joueurs"><i class="far fa-check-square" aria-hidden="true"></i> Ajout</a>
							<?php } ?>
						</h5>
					</div>
					<div class="collapse" id="collapse5">
						<div class="card-body">
							<h5 class="card-title">
								<?php if( $isOuvreur["5"] == 'Oui' ){ ?>
								<a href="#" onclick="AddOuvreur( <?php echo $dayofyear;?>, <?php echo $idCreneau["5"];?>)" class="btn btn-primary" alt="Me positionner comme ouvreur" title="Me positionner comme ouvreur"><i class="fas fa-key"></i></a>&nbsp;
								<?php } ?>
								<?php echo $ouvreur["5"];?>
							</h5>
						</div>
						<ul class="list-group list-group-flush">
						    <?php $counter1=-1; if( !is_null($inscript["5"]) && is_array($inscript["5"]) && sizeof($inscript["5"]) ) foreach( $inscript["5"] as $key1 => $value1 ){ $counter1++; ?>
						    	<li class="list-group-item"><?php if( $value1["mode"] == 'MOD' ){ ?><a href="#" onclick="DelCreneau( <?php echo $dayofyear;?>, <?php echo $idCreneau["5"];?>)" class="btn btn-primary" alt="Supprimer cette réservation" title="Supprimer cette réservation"> - </a>&nbsp;<?php } ?><?php echo $value1["nom"];?></li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
			<?php } ?>
			
			<?php if( $horaire["6"] > '' ){ ?>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-header">
						<h5>
							<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse6" aria-expanded="false" aria-controls="collapse6"><i class="fap fa fa-plus"></i> <?php echo $horaire["6"];?></button>
							<?php if( $isLibre["6"] == 'Oui' ){ ?>
								<br /><br /><a href="#" onclick="AddJoueur( <?php echo $dayofyear;?>, <?php echo $idCreneau["6"];?>)" class="btn btn-primary" alt="M'ajouter dans la liste des joueurs" title="M'ajouter dans la liste des joueurs"><i class="far fa-check-square" aria-hidden="true"></i> Ajout</a>
							<?php } ?>
						</h5>
					</div>
					<div class="collapse" id="collapse6">
						<div class="card-body">
							<h5 class="card-title">
								<?php if( $isOuvreur["6"] == 'Oui' ){ ?>
								<a href="#" onclick="AddOuvreur( <?php echo $dayofyear;?>, <?php echo $idCreneau["6"];?>)" class="btn btn-primary" alt="Me positionner comme ouvreur" title="Me positionner comme ouvreur"><i class="fas fa-key"></i></a>&nbsp;
								<?php } ?>
								<?php echo $ouvreur["6"];?>
							</h5>
						</div>
						<ul class="list-group list-group-flush">
						    <?php $counter1=-1; if( !is_null($inscript["6"]) && is_array($inscript["6"]) && sizeof($inscript["6"]) ) foreach( $inscript["6"] as $key1 => $value1 ){ $counter1++; ?>
						    	<li class="list-group-item"><?php if( $value1["mode"] == 'MOD' ){ ?><a href="#" onclick="DelCreneau( <?php echo $dayofyear;?>, <?php echo $idCreneau["6"];?>)" class="btn btn-primary" alt="Supprimer cette réservation" title="Supprimer cette réservation"> - </a>&nbsp;<?php } ?><?php echo $value1["nom"];?></li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
			<?php } ?>
			
		</div>
		<?php } ?>
		
		<div class="row">
			<div class="col-sm-4">
				<form class="form-signin" action="index.php" method="post">
			     	<button class="btn btn-lg btn-primary btn-block" type="submit"><i class="fas fa-sign-out-alt"></i> Quitter</button>
			   </form>
			</div>
			<div class="col-sm-4">&nbsp;</div>
			<div class="col-sm-4">
				<form class="form-signin" action="index.php" method="post">
					<input type="hidden" name="nom" value="<?php echo $nom;?>">
					<input type="hidden" name="licence" value="<?php echo $id_licencier;?>">
					<input type="hidden" name="page" value="jour">
			     	<button class="btn btn-lg btn-primary btn-block" type="submit"><i class="fa fa-repeat" aria-hidden="true"></i> Continuer</button>
			   </form>
			</div>
		</div>
	</div>
	

</body>

<script>
    $(document).ready(function(){
        // Add minus icon for collapse element which is open by default
        $(".collapse.show").each(function(){
        	$(this).prev(".card-header").find(".fap").addClass("fa-minus").removeClass("fa-plus");
        });
        
        // Toggle plus minus icon on show hide of collapse element
        $(".collapse").on('show.bs.collapse', function(){
        	$(this).prev(".card-header").find(".fap").removeClass("fa-plus").addClass("fa-minus");
        }).on('hide.bs.collapse', function(){
        	$(this).prev(".card-header").find(".fap").removeClass("fa-minus").addClass("fa-plus");
        });
    });
</script>

</html>
