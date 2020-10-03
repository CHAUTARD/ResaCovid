<?php if(!class_exists('raintpl')){exit;}?><!-- jour.html -->

<?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "header" );?>

<body>
	<div class="container h-100">	
		<div class="alert alert-dark" my-3>
			<div class="d-flex align-items-center text-white-50 bg-purple rounded box-shadow">
	        	<img class="mr-3" width="96" height="96" src="img/logo.gif" text="<?php  echo LOGO_TITLE;?>" alt="<?php  echo LOGO_TITLE;?>">
	        	<div class="lh-100 align-items-center">
	          		<h1 class="mb-0 text-white">Choix du jour</h1>   
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
			
		<center><i class="fa fa-calendar fa-3x" aria-hidden="true"> <?php echo $mois;?></i></center>
		<br />
					
       	<table class="table table-style">
       		<thead class="thead-light">
				<tr>
				  <th scope="col">Lundi</th>
				  <th scope="col">Mardi</th>
				  <th scope="col">Mercredi</th>
				  <th scope="col">Jeudi</th>
				  <th scope="col">Vendredi</th>
				  <th scope="col">Samedi</th>
				  <th scope="col">Dimanche</th>
				</tr>
			</thead>
						
			<tbody>
				<tr><?php echo $lgn1;?></tr>
				<tr><?php echo $lgn2;?></tr>
				<tr><?php echo $lgn3;?></tr>
			</tbody>
		</table>
	</div>
</body>
</html>