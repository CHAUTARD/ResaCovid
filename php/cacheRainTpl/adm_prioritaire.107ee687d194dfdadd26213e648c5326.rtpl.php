<?php if(!class_exists('raintpl')){exit;}?><!-- adm_prioritaire.html 
	Version : 1.0.0
-->

<?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "adm_header" );?>

<body>
	<div class="container">
	   
	<?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "adm_navbar" );?>
	
		<div class="row">
			<div class="col-sm-3">
				<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
					<?php $counter1=-1; if( !is_null($creneaux) && is_array($creneaux) && sizeof($creneaux) ) foreach( $creneaux as $key1 => $value1 ){ $counter1++; ?>
					<a class="nav-link<?php echo $value1["Active"];?>" id="v-tab-<?php echo $value1["id_creneau"];?>" data-toggle="pill" href="#v-pills-<?php echo $value1["id_creneau"];?>" role="tab" aria-controls="v-pills-<?php echo $value1["id_creneau"];?>" aria-selected="true">
						<?php echo $value1["Salle"];?> <?php echo $value1["Jour"];?> <?php echo $value1["Heure_Debut"];?> <?php echo $value1["Nbr_Place"];?>
					</a>
					<?php } ?>
				</div>
			</div>
			<div class="col">
				<div class="tab-content" id="v-pills-tabContent">
					<?php $counter1=-1; if( !is_null($creneaux) && is_array($creneaux) && sizeof($creneaux) ) foreach( $creneaux as $key1 => $value1 ){ $counter1++; ?>
					<div class="tab-pane fade<?php echo $value1["ShowActive"];?>" id="v-pills-<?php echo $value1["id_creneau"];?>" role="tabpanel" aria-labelledby="v-pills-<?php echo $value1["id_creneau"];?>">
						<ul class="list-group">
							<?php $counter2=-1; if( !is_null($value1["Licenciers"]) && is_array($value1["Licenciers"]) && sizeof($value1["Licenciers"]) ) foreach( $value1["Licenciers"] as $key2 => $value2 ){ $counter2++; ?>
							<li class="list-group-item">
							 	<button onclick="DelPrioritaire(<?php echo $value2["id_prioritaire"];?>)"><i class="far fa-trash-alt"></i></button> Lic : <?php echo $value2["id_licencier"];?>, <?php echo $value2["Nom"];?> <?php echo $value2["Prenom"];?>
							</li>
							<?php } ?>
						</ul>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	
	<script>
	function DelPrioritaire(id_prioritaire) {    
	    $.ajax({
           type: "GET",
           url: "admin.php?page=delete_prioritaire",	
           data: { id_prioritaire: id_prioritaire},
           success: function(data) { 
        	   alert(data); 
        	   location.reload(true);
           }
	    })
	}
	</script>
</body>
</html>	