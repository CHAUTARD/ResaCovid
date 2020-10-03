<?php if(!class_exists('raintpl')){exit;}?><!-- adm_menu.html 
  Version : 1.0.2
  Date : 2020-10-03
-->

<?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "adm_header" );?>

<body>
    <div class="container">
    
	<?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "adm_navbar" );?>
	
	<!--  Fenêtre modale Prioritaire  -->
	<div class="modal fade" id="PrioritaireModal" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><div id='id_nom'></div></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="id_form_save_prioritaire" method="get">
						<div class="form-group">
							<ul class="list-group list-group-flush">
								<?php $counter1=-1; if( !is_null($creneaux) && is_array($creneaux) && sizeof($creneaux) ) foreach( $creneaux as $key1 => $value1 ){ $counter1++; ?>
								<li class="list-group-item">
      								<div class="custom-control custom-checkbox">
        								<input type="checkbox" class="custom-control-input checkPrioritaire" id="check<?php echo $key1;?>" name='check<?php echo $key1;?>'>
        								<label class="custom-control-label" for="check<?php echo $key1;?>"><?php echo $value1;?></label>
      								</div>
    							</li>
    							<?php } ?>
							</ul>
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

	<!--  Fenêtre modale Ajouter ou modifier un enregistrement  -->
	<div class="modal fade" id="adherentModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fas fa-user-plus"></i> Fiche licencié</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="container py-5">
					<div class="row">
						<div class="col-md-10 mx-auto">
							<div class="modal-body">
								<form class="was-validated" id="id_form_save_licencier" method="get">
									<div class="form-group row">
										<div class="col-sm-6">
											<label for="addLicence" class="col-form-label">N° Licence : </label>
											<input type="number" min="1" class="form-control" id="addLicence" name="addLicence" placeholder="Saisir votre numéro de licence FFTT" required>
											<div class="valid-feedback">Valide</div>
											<div class="invalid-feedback">Erreur dans la saisie.</div>
										</div>

										<div class="col-sm-6">
											<label class="col-form-label">Civilité : </label>
											<div>
												<label class="radio-inline">
												<input type="radio" name="addCivilite" value="Mr" id="addCiviliteMr" checked="checked" /> Mr </label>
												<label class="radio-inline">
												<input type="radio" name="addCivilite" value="Mme" id="addCiviliteMme" /> Mme </label>
											</div>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-6">
											<label for="addNom" class="col-form-label">Nom : </label>
											<input type="text" class="form-control" id="addNom" name="addNom" placeholder="Saisir votre nom de famille" style="text-transform:uppercase" required>
											<div class="valid-feedback">Valide</div>
											<div class="invalid-feedback">Erreur dans la saisie.</div>
										</div>

										<div class="col-sm-6">
											<label for="addSurnom" class="col-form-label">Surnom : </label>
											<input type="text" class="form-control" id="addSurnom" name="addSurnom" placeholder="Saisir votre surnom">
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-6">
											<label for="addPrenom" class="col-form-label">Prénom : </label>
											<input type="text" class="form-control" id="addPrenom" name="addPrenom" placeholder="Saisir votre prénom" required>
											<div class="valid-feedback">Valide</div>
											<div class="invalid-feedback">Erreur dans la saisie.</div>
										</div>

										<div class="col-sm-6">
											<label for="addEquipe" class="col-form-label">N° d'équipe (0 - Loisir) : <output name="valueEquipe" id="valueEquipe">0</output>
											</label> <input type="range" min="0" max="<?php  echo NOMBRE_EQUIPE;?>"
												class="form-control range" id="addEquipe" name="addEquipe"
												value="0" oninput="valueEquipe.value = addEquipe.value">
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-6">
											<label for="addTelephone" class="col-form-label">Téléphone : </label>
											<input type="tel" class="form-control" id="addTelephone" name="addTelephone"
												placeholder="Numéro de téléphone 06.02.03.04.05 (Portable où Fixe)"
												pattern="^(0)[1-9]([-. ]?[0-9]{2}){3}([-. ]?[0-9]{2})$" required>
											<div class="valid-feedback">Valide</div>
											<div class="invalid-feedback">Erreur dans la saisie.</div>
										</div>

										<div class="col-sm-6">
											<label for="addEmail" class="col-form-label">Email : </label>
											<input type="email" class="form-control" id="addEmail" name="addEmail" placeholder="Saisir votre adresse de messagerie" value="pas.saisie@faux" required>
											<div class="valid-feedback">Valide</div>
											<div class="invalid-feedback">Erreur dans la saisie.</div>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-6">
											<label class="col-form-label">Ouvreur : </label>
											<div>
												<input type="radio" name="addOuvreur" class="radioOuiNon demoyes" id="addOuvreurOui" value="Oui">
												<label for="addOuvreurOui">Oui</label> 
												<input type="radio" name="addOuvreur" class="radioOuiNon demono" id="addOuvreurNon" value="Non" checked>
												 <label for="addOuvreurNon">Non</label>
											</div>
										</div>

										<div class="col-sm-6">
											<label for="addAdmin" class="col-form-label">Administrateur : </label>
											<input type="password" class="form-control" id="addAdmin" name="addAdmin" placeholder="Non où mot de passe sur 10 caractères" value="">
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

		<table id="tLicenciers" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Licence</th>
					<th>Civ</th>
					<th>Nom</th>
					<th>Surnom</th>
					<th>Prénom</th>
					<th>Equ</th>
					<th>Téléphone</th>
					<th>Email</th>
					<th>Ouv.</th>
					<th>Admin</th>
					<th>Action</th>
				</tr>
			</thead>
		</table>
	</div>

	<script>
		$(document).ready(
			function() {
				var table = $('#tLicenciers').DataTable({
					ajax : {
					    url: "admin.php",
					    data: {
					    	page: "get_licenciers"
					    }
					},
					scrollY : '70vh',
					scrollX : false,
					scrollCollapse : true,
					paging : false,
					language : { url : "js/French.json" },
					columnDefs : [
						{ targets: [ 1, 9 ], visible : false, searchable : false },
						{ targets: [ 0, 5, 8, -1 ], className: "text-center", width: "4%" },
						{ targets : -1, data : null, "searchable": false, "orderable": false, defaultContent : "<button><i class='fas fa-user-lock'></i></button>" }
					],
					dom : 'Bfrtip',
					select : true,
					buttons : [{
						text : '<i class="fas fa-user-plus"></i> Ajouter un licencié',
						action : function( e, dt, node,	config) {
							$('#addLicence').val('');
							$('#addCiviliteMr').prop('checked',true);
							$('#addNom').val('');
							$('#addSurnom').val('');
							$('#addPrenom').val('');
							$('#addEquipe').val(0);
							$('#valueEquipe').val(0);
							$('#addTelephone').val('');
							$('#addEmail').val('pas.saisie@faux');
							$('#addOuvreurNon').prop('checked',true);
							$('#addAdmin').val('');
							
							// Ouverture d'une fenêtre modale
							$('#adherentModal').modal('show');
						}
					}, {
						text : '<i class="fas fa-user-edit"></i> Modifier',
						enabled : false,
						action : function( e, dt, node, config) {
							var rowData = dt.row({ selected : true }).data();

							// Transfert des données dans le formulaire
							/* console.log(rowData);
							    	0: 865607​
									1: "WILMUS"​
									2: ""​
									3: "Franck"​
									4: 3​
									5: ""​
									6: ""​
									7: "Non"​
									8: "Non"​
							 */
							$('#addLicence').val(rowData[0]);
							if (rowData[1] == 'Mr')
								$('#addCiviliteMr').prop('checked',true);
							else
								$('#addCiviliteMme').prop('checked',true);
							$('#addNom').val(rowData[2]);
							$('#addSurnom').val(rowData[3]);
							$('#addPrenom').val(rowData[4]);
							$('#addEquipe').val(rowData[5]);
							$('#valueEquipe').val(rowData[5]);
							$('#addTelephone').val(rowData[6]);
							$('#addEmail').val(rowData[7]);
							if (rowData[8] == 'Oui')
								$('#addOuvreurOui').prop('checked',true);
							else
								$('#addOuvreurNon').prop('checked',true);

							$('#addAdmin').val(rowData[9]);

							// Ouverture d'une fenêtre modale
							$('#adherentModal').modal('show');
						}
					}, {
						text : '<i class="far fa-trash-alt"></i> Supprimer',
						enabled : false,
						action : function( e, dt, node, config) {
							var aRow = table.row('.selected').data();
							if (confirm("Confirmez vous la suppression de "	+ aRow[1] + " " + aRow[4] + " " + aRow[2] +" ?")) {
								// AJAX Request
								$.ajax({
									url : 'admin.php',
									type : 'GET',
									data : {
										page : 'delete_licencier',
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
						title: 'Liste des licenciers',
						exportOptions: {
		                    columns: [ 0, 1, 2, 3, 4, 6, 7 ]
		                },
						text : '<i class="far fa-file-pdf"></i> PDF'
					}, {
						extend : 'colvis',
						text : '<i class="far fa-eye"></i> Affiche/Cache colonne'
					} ],

					bJQueryUI : true
				});
	
				/* Désactivation des boutons Modifier, Supprimer */
				table.on('select deselect', function() {
					var selectedRows = table.rows({selected : true}).count();
	
					table.button(1).enable(selectedRows === 1);
					table.button(2).enable(selectedRows === 1);
				});
	
				$('#tLicenciers tbody').on('click','button', function() {
					var data = table.row( $(this).parents('tr')).data();
					
					// Remplir le prenom et nom du licencié
					$('#id_nom').text(data[4] + ' ' + data[2] + ' prioritaire :');
					
					// Décoche tous les choix
					$('.checkPrioritaire:checkbox:checked').each(function() {
						this.checked = false;
					});
					
					// Chargement des prioritées en Ajax
					$.ajax({
						url : 'admin.php',
						type : 'GET',
						data : {
							page : 'get_prioritaire',
							id : data[0]
						},
						success : function(response) {						
							// Check des créneaux concernés
							$.each( $.parseJSON(response), function( key, value ) {						
								$( "#check" + value ).prop( "checked", true );
							})
						}
					});
					
					// Ouverture d'une fenêtre modale
					$('#PrioritaireModal').modal('show');
				});
				
				// this is the id of the form
				$("#id_form_save_licencier").submit(function(e) {

				    e.preventDefault(); // avoid to execute the actual submit of the form.

				    var form = $(this);
				    
				    $.ajax({
				           type: "GET",
				           url: "admin.php?page=add_licencier>",
				           data: form.serialize(), // serializes the form's elements.
				           success: function(data) { 
				        	   	alert(data); 
				        	   
								// Rechargement des données
								table.ajax.reload();
								
				    	   } // show response from the php script.
				    })   
				});
				
				// this is the id of the form
				$("#id_form_save_prioritaire").submit(function(e) {

				    e.preventDefault(); // avoid to execute the actual submit of the form.

				    var form = $(this);
				    
				    $.ajax({
							type: "GET",
							url: "admin.php?page=save_prioritaire",
							data: form.serialize(), // serializes the form's elements.
							success: function(data) { 
				        	   alert(data);  // show response from the php script.

								// Rechargement des données
								table.ajax.reload();
				           }
				    })    
				})
			})
	</script>
</body>
</html>