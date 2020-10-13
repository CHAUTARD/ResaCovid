/* vstt.js

 */

/** AddOuvreur
 * 
 * Ajout d'un ouvreur
 * 
 * @param yearNum
 * @param creneau
 * @returns
 */
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

/** AddJoueur
 * 
 * Ajout d'un licencier
 * 
 * @param yearNum
 * @param creneau
 * @returns
 */
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

/** DelCreneau
 * 
 * Suppression d'un créneau
 * 
 * @param yearNum
 * @param creneau
 * @returns
 */
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

/** DelReservation
 * Supression d'une réservation par le licencier
 * 
 * @param idReservation
 * @returns
 */
function DelReservation(idReservation) {	
	// Chargement des prioriétées en Ajax
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