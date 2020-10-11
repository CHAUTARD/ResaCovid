// vstt.js

// Add ouvreur
function AddOuvreur( yearNum, creneau) {
      $.ajax({
           type: "GET",
           url: 'index.php',
           data:{
        	   page:'add_ouvreur',
        	   iDate: yearNum,
        	   iCreneau: creneau
           },
           
           success : function(msg, statut){ // success est toujours en place, bien sûr !
	           var msg = $.parseJSON(msg);
	           if(msg.success=='Oui')
	           {
	        	   alert(msg.data);
	        	   
	        	   // Rechargement de la page
	        	   location.reload(true);
	               return true;
	           }
	           else
	           {
	               alert('Erreur sur le serveur !');
	               return false;
	           }
           },

           error : function(resultat, statut, erreur){
        	   alert('Erreur lors de la mise à jour !');
           },
           
           complete : function(resultat, statut){

           }
      });
 }

//Add ouvreur
function AddJoueur( yearNum, creneau) {
      $.ajax({
           type: "GET",
           url: 'index.php',
           data:{
        	   page:'add_joueur',
        	   iDate: yearNum,
        	   iCreneau: creneau
           },
           
           success : function(msg, statut){ // success est toujours en place, bien sûr !
	           var msg = $.parseJSON(msg);
	           if(msg.success=='Oui')
	           {
	        	   // Supprimé à la demande de Yves
	        	   // alert(msg.data);
	        	   
	        	   // Rechargement de la page
	        	   location.reload(true);
	               return true;
	           }
	           else
	           {
	               alert('Erreur sur le serveur !');
	               return false;
	           }
           },

           error : function(resultat, statut, erreur){
        	   alert('Erreur lors de la mise à jour !');
           },
           
           complete : function(resultat, statut){

           }
      });
 }

// DelCreneau
function DelCreneau( yearNum, creneau) {
    $.ajax({
         type: "GET",
         url: 'admin.php',
         data:{
      	   page:'delete_creneau',
      	   iDate: yearNum,
      	   iCreneau: creneau
         },
         
         success : function(msg, statut){ // success est toujours en place, bien sûr !
	           var msg = $.parseJSON(msg);
	           if(msg.success=='Oui')
	           {
	        	   alert(msg.data);
	        	   
	        	   // Rechargement de la page
	        	   location.reload(true);
	               return true;
	           }
	           else
	           {
	               alert('Erreur sur le serveur !');
	               return false;
	           }
         },

         error : function(resultat, statut, erreur){
      	   alert('Erreur lors de la mise à jour !');
         },
         
         complete : function(resultat, statut){

         }
    });
}

function DelReservation(idReservation) {	
	alert('ici');
	// Chargement des prioritées en Ajax
	$.ajax({
		url : 'admin.php',
		type : 'GET',
		data : {
			page : 'delete_reservation',
			idReservation : idReservation
		},
		success : function(response) {	
			location.reload(true);
		}
	})
}