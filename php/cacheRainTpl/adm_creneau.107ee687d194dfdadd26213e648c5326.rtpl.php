<?php if(!class_exists('raintpl')){exit;}?><!-- adm_creneau.html 
	Version : 1.0.1
	Date : 2020-10-03
-->

<?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "adm_header" );?>

<body>
    <div class="container">
    
	<?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "adm_navbar" );?>
	
	<!--  Fenêtre modale Prioritaire pour le créneau choisi  -->
	<div class="modal fade" id="PrioritaireCreneauModal" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><div id='id_nom'></div></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<ul class="list-group list-group-flush" id='id_list_prioritaire'></ul>
					</div>
									
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!--  Fenêtre modale Ajouter ou modifier un créneau  -->
	<div class="modal fade" id="creneauModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="far fa-clock"></i> Fiche créneau</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="container py-5">
					<div class="row">
						<div class="col-md-10 mx-auto">
							<div class="modal-body">
								<form class="was-validated" id="id_form_save_creneau" method="get">						
									<div class="form-group row">
										<div class="col-sm-6">
											<label for="addNom" class="col-form-label">Appéllation : </label>
											<input type="text" class="form-control" id="addNom" name="addNom" placeholder="Appellation du créneau" required>
											<div class="valid-feedback">Valide</div>
											<div class="invalid-feedback">Erreur dans la saisie.</div>
										</div>

										<div class="col-sm-6">
											<label class="col-form-label">Salle : </label>
											<select class="browser-default custom-select" id="addSalle" name='addSalle'>
											  <option value="Copée" selected>Copée</option>
											  <option value="Tcheuméo">Tcheuméo</option>
											</select>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-6">
											<label for="addJour" class="col-form-label">Jour : </label> 
											<select class="browser-default custom-select" name="addJour" id="addJour">
											  <option value="1">Lundi</option>
											  <option value="2">Mardi</option>
											  <option value="3">Mercredi</option>
											  <option value="4">Jeudi</option>
											  <option value="5">Vendredi</option>
											  <option value="6">Samedi</option>
											  <option value="0">Dimanche</option>
											</select>
										</div>

										<div class="col-sm-6">
											<label class="col-form-label">Heure de début : <i class="far fa-clock"></i></label>
      										<input type="time" class="form-control" id="addHeureDebut" name="addHeureDebut" min="09:00" max="23:00" required>
											<div class="valid-feedback">Valide</div>
											<div class="invalid-feedback">Erreur dans la saisie.</div>      										
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-6">
											<label class="col-form-label">Heure de début : <i class="far fa-clock"></i></label>
      										<input type="time" class="form-control" id="addHeureFin" name="addHeureFin" min="09:00" max="23:00" required>
											<div class="valid-feedback">Valide</div>
											<div class="invalid-feedback">Erreur dans la saisie.</div> 
										</div>

										<div class="col-sm-6">
											<div>
												<label class="col-form-label">Créneau :</label><br />
												<input type="radio" name="addLibre" class="radioOuiNon demoyes" id="addLibreOui" value="Oui" checked>
												<label for="addLibreOui">Libre</label> 
												<input type="radio"	name="addLibre" class="radioOuiNon demono" id="addLibreNon" value="Non">
												<label for="addLibreNon">Entrainement</label>
											</div>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-6">
											<label for="addOuvreur" class="col-form-label">Ouvreur : </label> 
											<select class="browser-default custom-select" id="addIdOuvreur" name="addOuvreur">
												<option value="0" selected>Pas d'ouvreur</option>
												<?php $counter1=-1; if( !is_null($ouvreurs) && is_array($ouvreurs) && sizeof($ouvreurs) ) foreach( $ouvreurs as $key1 => $value1 ){ $counter1++; ?>
											  	<option value="<?php echo $key1;?>"><?php echo $value1;?></option>
											  	<?php } ?>
											</select>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-6">
											<label class="col-form-label">Nombre de place : </label>
											<input type="number" min="1" max="18" class="form-control" id="addNbrPlace" name="addNbrPlace" placeholder="Nombre de place disponible pour ce créneau" required>
										</div>

										<div class="col-sm-6">
											<label class="col-form-label">Ordre : </label>
											<input type="number" min="0" class="form-control" id="addOrd" name="addOrd" placeholder="0 pour créneau isolé, sinon un nombre pour les cours du même niveau" required>
										</div>
									</div>

									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
										<button type="submit" class="btn btn-primary">Sauver</button>
									</div>
								</form>
							</div>
						</div>						
					</div>
				</div>
			</div>
		</div>
	</div>

		<table id="tCreneaux" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Index</th>
					<th>Nom</th>
					<th>Salle</th>
					<th>Jour</th>
					<th>H. Début</th>
					<th>H. Fin</th>
					<th>Libre</th>
					<th>Ouv.</th>
					<th>Plac.</th>
					<th>Ord</th>
					<th>Lic.</th>
				</tr>
			</thead>
			<tbody>
				<?php $counter1=-1; if( !is_null($creneaux) && is_array($creneaux) && sizeof($creneaux) ) foreach( $creneaux as $key1 => $value1 ){ $counter1++; ?>
				<tr>
					<td><?php echo $value1["id_creneau"];?></td>
					<td><?php echo $value1["Nom"];?></td>
					<td><?php echo $value1["Salle"];?></td>
					<td><?php echo $value1["Jour"];?></td>
					<td><?php echo $value1["Heure_Debut"];?></td>
					<td><?php echo $value1["Heure_Fin"];?></td>
					<td><?php echo $value1["Libre"];?></td>
					<td><?php echo $value1["id_ouvreur"];?></td>
					<td><?php echo $value1["Nbr_Place"];?></td>
					<td><?php echo $value1["Ord"];?></td>
					<td><button><i class='fas fa-user-lock'></i></button></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	
	<script>
		$(document).ready(
			function() {
				var table = $('#tCreneaux').DataTable({
					scrollY : '75vh',
					scrollX : false,
					scrollCollapse : true,
					paging : false,
					language : { url : "js/French.json" },
					dom : 'Bfrtip',
					select : true,
					columnDefs : [
						{ targets : 0, visible : false, searchable : false },
						{ targets: [ 0, 4, 5, 6, 10 ], className: "text-center", width: "4%" },
						{ targets: [ 8, 9 ], className: "text-right" },
						{ targets: 10, searchable: false, orderable: false}
					],
					buttons : [{
						text : '<i class="far fa-plus-square"></i> Ajouter un créneau',
						action : function( e, dt, node,	config) {
							$('#addCreneau').val('');
							$('#addNom').val('');
							$('#addSalle').val('Coppée');
							$('#addJour').val('');
							$('#addHeureDebut').val('');
							$('#addHeureFin').val('');
							$('#addLibre').val('Oui');
							$('#addIdOuvreur').val(0);
							$('#addNbrPlace').val(12);
							$('#addOrd').val(0);
							
							// Ouverture d'une fenêtre modale
							$('#creneauModal').modal('show');
						}
					}, {
						text : '<i class="far fa-edit"></i> Modifier',
						enabled : false,
						action : function( e, dt, node, config) {
							var rowData = dt.row({ selected : true }).data();

								// Transfert des données dans le formulaire
								$('#addCreneau').val(rowData[0]);
								$('#addNom').val(rowData[1]);
								$('#addSalle').val(rowData[2]);
								$('#addJour').val(rowData[3]);
								$('#addHeureDebut').val(rowData[4]);
								$('#addHeureFin').val(rowData[5]);
								$('#addLibre').val(rowData[6]);
								$('#addIdOuvreur').val(rowData[7]);
								$('#addNbrPlace').val(rowData[8]);
								$('#addOrd').val(rowData[9]);

								// Ouverture d'une fenêtre modale
								$('#adherentModal').modal('show');
							}
						}, {
							text : '<i class="far fa-trash-alt"></i> Supprimer',
							enabled : false,
							action : function( e, dt, node, config) {
								var aRow = table.row('.selected').data();
								if (confirm("Confirmez vous la suppression de "	+ aRow[1] + " " + aRow[3] + " ?")) {
									// AJAX Request
									$.ajax({
										url : 'admin.php',
										type : 'GET',
										data : {
											page : 'delete_creneau',
											id : aRow[0]
										},
										success : function(response) {
											table.row('.selected').remove().draw(false);
										}
									})
								}
							}
						}, {
							extend : 'pdfHtml5',
							title: 'Liste des créneaux',
							exportOptions: {
			                    columns: [ 1, 2, 3, 4, 6, 7, 8 ]
			                },
							text : '<i class="far fa-file-pdf"></i> PDF'
						},
						{
							extend : 'colvis',
							text : '<i class="far fa-eye"></i> Affiche/Cache colonne'
						} 
					],
					bJQueryUI : true
				});
				
				/* Désactivation des boutons Modifier, Supprimer */
				table.on('select deselect', function() {
					var selectedRows = table.rows({selected : true}).count();
	
					table.button(1).enable(selectedRows === 1);
					table.button(2).enable(selectedRows === 1);
				});
				
				$('#tCreneaux tbody').on('click','button', function() {
					var data = table.row( $(this).parents('tr')).data();
					
					// Remplir le prenom et nom du licencié
					$('#id_nom').text(' Créneau : ' + data[1] + ' ' + data[2] + ' ' + data[3] + ' ' + data[4]);
									
					// Chargement des prioritées en Ajax
					$.ajax({
						url : 'admin.php',
						type : 'GET',
						data : {
							page : 'get_prioritaire_creneau',
							id : data[0]
						},
						success : function(response) {	
							$("#id_list_prioritaire").empty();
							
							// Ajoute tous les prioritaires au créneau concernés
							$.each( $.parseJSON(response), function( key, value ) {	
								$("#id_list_prioritaire"). append('<li class="list-group-item"><i class="fas ' + value.cls + '"></i> ' + value.nom +'</li>');		
							})
						}
					});
					
					// Ouverture d'une fenêtre modale
					$('#PrioritaireCreneauModal').modal('show');
				});
				
				// this is the id of the form
				$("#id_form_save_creneau").submit(function(e) {

				    e.preventDefault(); // avoid to execute the actual submit of the form.

				    var form = $(this);
				    
				    $.ajax({
						type: "GET",
						url: "admin.php?page=>add_creneau&id_creneau=0",	
						data: form.serialize(), // serializes the form's elements.
						success: function(data) { 
							alert(data);  // show response from the php script.
							
							// Rechargement des données
							table.ajax.reload();
						}
				    })   
				})
			}
		)
	</script>
	
</body>
</html>	