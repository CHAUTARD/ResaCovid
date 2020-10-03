<?php if(!class_exists('raintpl')){exit;}?><!-- adm_stat_prioritaire.html 
	Version : 1.0.0
	Date : 2020-09-26
-->

<?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "adm_header" );?>

<body>
	<div class="container">
	   
	<?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "adm_navbar" );?>
	
		<div class="row">
			<div class="col-sm-6">
				<canvas id="myChartPrioritaire"></canvas>
			</div>
		</div>
	</div>
	
	<script>
	var ctx = document.getElementById('myChartPrioritaire').getContext('2d');
	var chart = new Chart(ctx, {
	    // The type of chart we want to create
	    type: 'line',

	    // The data for our dataset
	    data: {
	        labels: ['0', '1', '2', '3', '4', '5', '+'],
	        datasets: [{
	            label: 'Répartition du nombre des prioritaires',
	            backgroundColor: 'rgb(255, 99, 132)',
	            borderColor: 'rgb(255, 99, 132)',
	            data: [<?php echo $valeurs;?>]
	        }]
	    },

	    // Configuration options go here
	    options: {}
	});
	</script>
</body>
</html>	