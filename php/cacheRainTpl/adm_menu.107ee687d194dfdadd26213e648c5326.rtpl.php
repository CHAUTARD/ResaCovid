<?php if(!class_exists('raintpl')){exit;}?><!-- adm_menu.html 
	Version : 1.0.3
	Date : 2020-10-02
-->

<!doctype html>
<html lang="fr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
	<meta Cache-Control: no-cache,no-store />
    <meta name="description" content="Réservation de table">
    <meta name="author" content="Patrick CHAUTARD">
    
    <link rel="icon" href="img/favicon_adm.ico">
    
    <title>Réservation de table</title>
	
    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" type="text/css" href="js/bootstrap/css/bootstrap.min.css" />
	
	<!-- Latest compiled and minified JavaScript -->
    <script type="text/javascript" src="js/DataTables/Jquery-3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap/js/bootstrap.min.js"></script>
    
    <script type="text/javascript" src="js/adm_vstt.js"></script>
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-2">
				<img src="img/logo.gif" width="200" alt="<?php  echo LOGO_TITLE;?>" title="<?php  echo LOGO_TITLE;?>">
			</div>
			<div class="col-8 text-center justify-content-center align-self-center">
				<h1>Administration de la réservation des créneaux</h1>			
			</div>
     		<div class="col>">
     			<form class="form-signin" action="admin.php" method="post">
					<button class="btn btn-light btn-lg btn-block btn-huge" type="submit"><img src="img/quitter.png" alt="Bye Bye !" title="Bye Bye !"></button>
				</form>
     		</div>
     	</div>
	    <br>
		<div class="row">
	        <div class="col">
	        	<div class="card">
	 				<img class="card-img-top" alt="Joueurs" src="img/joueurs.png">

	        		<div class="card-footer">
			        	<form class="form-signin" action="admin.php" method="post">
			        		<input type="hidden" name="page" value="adm_licencier">
			            	<button class="btn btn-primary btn-lg btn-block btn-huge" type="submit">Les licenciés</button>
			            </form>
			        </div>
			    </div>
	        </div>

	        <div class="col">
	        	<div class="card">
	 				<img class="card-img-top" alt="Créneaux" src="img/creneaux.png">

	        		<div class="card-footer">
			        	<form class="form-signin" action="admin.php" method="post">
			        		<input type="hidden" name="page" value="adm_creneau">
			            	<button class="btn btn-primary btn-lg btn-block btn-huge" type="submit">Les créneaux</button>
			            </form>
			        </div>
			    </div>
	        </div>

	        <div class="col">
	        	<div class="card">
	 				<img class="card-img-top" alt="Prioritaires" src="img/prioritaires.png">

	        		<div class="card-footer">
			        	<form class="form-signin" action="admin.php" method="post">
			        		<input type="hidden" name="page" value="adm_prioritaire">
			            	<button class="btn btn-primary btn-lg btn-block btn-huge" type="submit">Les prioritaires</button>
			            </form>
			        </div>
			    </div>
	        </div>
	        
	        <div class="col">
	        	<div class="card">
	 				<img class="card-img-top" alt="Réservation" src="img/reservations.png">

	        		<div class="card-footer">
			        	<form class="form-signin" action="admin.php" method="post">
			        		<input type="hidden" name="page" value="adm_reservation">
			            	<button class="btn btn-primary btn-lg btn-block btn-huge" type="submit">Les réservations</button>
			            </form>
			        </div>
			    </div>
	        </div>
	    </div>
	    <hr />
	    <div class="row">
	        <div class="col-md-3">
     	        <div class="card">
	 				<img class="card-img-top" alt="Importation" src="img/importation.png">

	        		<div class="card-footer">
			        	<form class="form-signin" action="admin.php" method="post">
			        		<input type="hidden" name="page" value="adm_importation">
			            	<button class="btn btn-primary btn-lg btn-block btn-huge" type="submit">Importation SPID</button>
			            </form>
			        </div>
			    </div>
	        </div>
	        <div class="col-md-3">
	             <div class="card">
	 				<img class="card-img-top" alt="Exportation" src="img/exportation.png">

	        		<div class="card-footer">
			        	<form class="form-signin" action="admin.php" method="post">
			        		<input type="hidden" name="page" value="adm_database_dump">
			            	<button class="btn btn-primary btn-lg btn-block btn-huge" type="submit">Exportation SQL</button>
			            </form>
			        </div>
			    </div>
	        </div>
	        <div class="col-md-3">
	             <div class="card">
	 				<img class="card-img-top" alt="prioritaire" src="img/stat_1.png">

	        		<div class="card-footer">
			        	<form class="form-signin" action="admin.php" method="post">
			        		<input type="hidden" name="page" value="adm_stat_prioritaire">
			            	<button class="btn btn-primary btn-lg btn-block btn-huge" type="submit">Stat. prioritaires</button>
			            </form>
			        </div>
			    </div>
	        </div>
	    </div>
	    <hr />
	    <center><h2 class="bg-danger text-white">  Opérations non reverssibles !  </h2></center>
	    <hr />
	    <div class="row">
	        <div class="col-md-4">
	        	<div class="card">
	 				<img class="card-img-top" alt="Vidage" src="img/clean.png">

	        		<div class="card-footer">
			        	<form class="form-signin" action="admin.php" method="post" onsubmit="return ConfirmSubmit()">
			        		<input type="hidden" name="page" value="adm_clean">
			            	<button class="btn btn-danger btn-lg btn-block btn-huge" type="submit">Nettoyages</button>
			            </form>
			        </div>
			    </div>
	        </div>
	        <div class="col">
		        <div class="card">
		 			<img class="card-img-top" alt="Delete réservation" src="img/del_reservation.png">
	
	        		<div class="card-footer">
			        	<form class="form-signin" action="admin.php" method="post" onsubmit="return ConfirmSubmit()">
			        		<input type="hidden" name="page" value="adm_clean_reservation">
			            	<button class="btn btn-danger btn-lg btn-block btn-huge" type="submit">Réservations</button>
			            </form>
			        </div>
			    </div>
	        </div>
	        <div class="col">
	        	<div class="card">
	        	 	<img class="card-img-top" alt="Delete Prioritaires" src="img/del_prioritaire.png">

	        		<div class="card-footer">
			        	<form class="form-signin" action="admin.php" method="post" onsubmit="return ConfirmSubmit()">
			        		<input type="hidden" name="page" value="adm_clean_prioritaire">
			            	<button class="btn btn-danger btn-lg btn-block btn-huge" type="submit">Prioritaires</button>
			            </form>
			        </div>
			    </div>
	        </div>
	        <div class="col">
	        	<div class="card">
	        	 	<img class="card-img-top" alt="Delete Créneaux" src="img/del_creneau.png">

	        		<div class="card-footer">
			        	<form class="form-signin" action="admin.php" method="post" onsubmit="return ConfirmSubmit()">
			        		<input type="hidden" name="page" value="adm_clean_creneau">
			            	<button class="btn btn-danger btn-lg btn-block btn-huge" type="submit">Créneaux</button>
			            </form>
			        </div>
			    </div>
	        </div>
	    </div>
	    <hr />
	</div>
</body>
</html>