<?php if(!class_exists('raintpl')){exit;}?><!-- adm_importation.html -->

<?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "adm_header" );?>

<body>
	<div class="container">
		<div class="row">
			<div class="col">
				<h1>
					<center>Importation à partir de SPID</center>
				</h1>
			</div>

			<div class="col">
				<form class="form-signin" action="admin.php" method="post">
					<input type="hidden" name="page" value="adm_menu"> 
					<input type="hidden" name="nom" value="<?php echo $nom;?>">
					<button class="btn btn-primary btn-lg btn-block btn-huge" type="submit">
						<i class="fas fa-step-backward"></i> Retour au Menu
					</button>
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col">
				<label>Sur le site http://spid.fftt.com</label><br />
				<img alt="Cartouche Club" src="img/spid1.png" />
			</div>
			<div class="col">
				<label>Dans la barre du haut choisir "LICENCES"</label><br />
				<img alt="Menu du haut" src="img/spid2.png" />
			</div>
			<div class="col">
				<label>Saisir les identifiants club</label><br />
				<img alt="Information Club" src="img/spid3.png" />
			</div>
		</div>
		
		<div class="row">
			<div class="col">
				<label>Choisir liste</label><br />
				<img alt="Cartouche Club" src="img/spid4.png" />
			</div>
			<div class="col">
				<label>Saisir les informations tel que l'image</label><br />
				<img alt="Menu du haut" src="img/spid5.png" />
			</div>
		</div>
		
		<hr />
		<div class="row">
			<div class="col">
				<form method="post" action="admin.php" target="_blank" enctype="multipart/form-data">
					<input type="hidden" name="page" value="adm_traite_xls" />
					<div class="form-group">
    					<label for="idFormControlFile">Fichier qui vient d'être importé</label>
    					<input type="file" class="form-control-file" name="upload" id="idFormControlFile" accept=".csv, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required/>
  					</div>
  					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Importer</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>