<?php if(!class_exists('raintpl')){exit;}?><!-- adm_reservation.html 
	Version : 1.0.0
-->

<?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "adm_header" );?>

<body>
    <div class="container">
    
	<?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "adm_navbar" );?>
	
	<!--  Fenêtre modale Prioritaire  -->
	<div class="modal fade" id="JoueurModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><div id='id_titre'>Liste des joueurs pour ...</div></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<ul id="ListJoueurs"class="list-group">
					</ul>
				</div>
			</div>
		</div>
	</div>
	
		<!-- Calendar -->
		<div class="calendar bg-white">
			<div class="row justify-content-md-center">
				<div class="col col-lg-1">
					<a href="?page=reservation&moisPrevious=<?php echo $moisPrevious;?>"><i class="fas fa-arrow-alt-circle-left fa-3x ml-3"></i></a>
				</div>
				<div class="col col-md-auto">	
					<i class="far fa-calendar-alt fa-3x mr-2"></i><span class="month font-weight-bold text-uppercase"><?php echo $calendar_mois_annee;?></span>
				</div>
				<div class="col col-lg-1">
					<a href="?page=reservation&moisPrevious=<?php echo $moisNext;?>"><i class="fas fa-arrow-alt-circle-right fa-3x mr-3"></i></a>
				</div>
			</div>

			<ol class="day-names list-unstyled">
				<li class="font-weight-bold">Lun</li>
				<li class="font-weight-bold">Mar</li>
				<li class="font-weight-bold">Mer</li>
				<li class="font-weight-bold">Jeu</li>
				<li class="font-weight-bold">Ven</li>
				<li class="font-weight-bold">Sam</li>
				<li class="font-weight-bold">Dim</li>
			</ol>

			<ol class="days list-unstyled">
				<?php $counter1=-1; if( !is_null($calendar_case) && is_array($calendar_case) && sizeof($calendar_case) ) foreach( $calendar_case as $key1 => $value1 ){ $counter1++; ?>
				<li>
					<div class="<?php echo $value1["Outside"];?>"><?php echo $value1["Num"];?></div>
						<?php $counter2=-1; if( !is_null($value1["event"]) && is_array($value1["event"]) && sizeof($value1["event"]) ) foreach( $value1["event"] as $key2 => $value2 ){ $counter2++; ?>
							<?php if( $value2["Nbr"] == 0 ){ ?>
							<button type="button" class="event btn <?php echo $value2["type"];?> rounded-pill btn-sm" style="font-size:smaller;" onclick="alert('Pas de joueur inscrit à ce créneau !')"><?php echo $value2["name"];?></button>
							<?php }else{ ?>
							<button type="button" class="event btn <?php echo $value2["type"];?> rounded-pill btn-sm" style="font-size:smaller;" onclick="ShowJoueur('<?php echo $value2["name"];?>', <?php echo $value2["id_creneau"];?>, <?php echo $value2["iDate"];?>)"><?php echo $value2["name"];?></button>
							<?php } ?>
						<?php } ?>
				</li>
				<?php } ?>
			</ol>
		</div>
	</div>
	
	<script>
	function ShowJoueur( name ,id_creneau, iDate) {   
		$.ajax({
           type: "GET",
           url: "admin.php?page=get_joueur",	
           data: { id_creneau: id_creneau, iDate: iDate},
           success: function(data) { 
        	   // list container
        	   	var listJoueurs = $('#ListJoueurs');
        		var text;

        		// Titre de la fenêtre modale
        		$('#id_titre').text("Créneau : " + name);
        		
        		// Vide la liste des joueurs présent
        		listJoueurs.empty();
        		
        		var lJoueurs = $.parseJSON(data);

        		lJoueurs.forEach((joueur) => { 			
        			text = '<li class="list-group-item">';
        								
        	   	    if(joueur.ouvreur)
        	   	    	text += '<i class="fas fa-key"></i> ';
        	   	    else
        	   	    	text += '<i class="fas fa-table-tennis"></i> ';
        	   	
        			text += joueur.nom + '</li>';
        			
	        	 	// Ajouter un élément à la fin de la liste
	        	    listJoueurs.append(text);
        	   	})
           }
	    });
		
		// Ouverture d'une fenêtre modale
		$('#JoueurModal').modal('show');
	}
	</script>
</body>
</html>