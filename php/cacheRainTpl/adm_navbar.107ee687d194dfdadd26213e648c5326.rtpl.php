<?php if(!class_exists('raintpl')){exit;}?><!-- titre_header.html
	Version : 1.0.1
	Date : 2020-10-03
 -->

<!--- Navbar --->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
	<a class="navbar-brand text-white" href="#">			
		<!-- Logo Image -->
		<img src="<?php echo $logo;?>" width="48" alt="<?php  echo LOGO_TITLE;?>" title="<?php  echo LOGO_TITLE;?> class="d-inline-block align-middle mr-2"> 
		<!-- Logo Text -->
		<b><u><?php echo $titre;?></u></b>
	</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse"
		data-target="#nvbCollapse" aria-controls="nvbCollapse">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="nvbCollapse">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item pl-1">
				<a class="nav-link" href="?page=menu"><i class="fas fa-home fa-fw mr-1"></i>Menu</a>
			</li>
			<li class="nav-item dropdown">
        		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-location-arrow fa-fw mr-1"></i>Pages</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="?page=licencier">Les licenciés</a>
					<a class="dropdown-item" href="?page=creneau">les crénaux</a>
					<a class="dropdown-item" href="?page=prioritaire">Les prioritaires</a>
					<a class="dropdown-item" href="?page=reservation">Les réservations</a>
				</div>
			</li>
			<li class="nav-item pl-1">
				<a class="nav-link" href="admin.php"><i class="fas fa-sign-out-alt fa-fw mr-1"></i>Quitter</a>
			</li>
			<li class="nav-item pl-1">
				<a class="nav-link" href="#" onClick="alert('Site construit par Patrick CHAUTARD.')"><i class="fas fa-info-circle fa-fw mr-1"></i>A propos de ...</a>
			</li>
		</ul>
	</div>
</nav>
<!--# Navbar #-->