/** vstt.js
 * 
 * 		@version : 1.0.0
 * 		@date : 2020-10-21
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
	        	   $.alert({
						columnClass: 'medium',
				        title : 'Ajouter un ouvreur',
				        content : msg.data
					});
	        	   
	        	   // Rechargement de la page
	        	   location.reload(true);
	               return true;
	           }
	           else
	           {
	        	   $.alert({
						columnClass: 'medium',
				        title : 'Ajouter un ouvreur',
				        content : 'Erreur sur le serveur !'
					});
	               return false;
	           }
           },

           error : function(resultat, statut, erreur){
        	   $.alert({
					columnClass: 'medium',
			        title : 'Ajouter un ouvreur',
			        content : 'Erreur lors de la mise à jour !'
				});
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
	        	   // Rechargement de la page
	        	   location.reload(true);
	               return true;
	           }
	           else
	           {
	        	   $.alert({
						columnClass: 'medium',
				        title : 'Ajouter un joueur',
				        content : 'Erreur sur le serveur !'
					});
	               return false;
	           }
           },

           error : function(resultat, statut, erreur){
        	   $.alert({
					columnClass: 'medium',
			        title : 'Ajouter un joueur',
			        content : 'Erreur lors de la mise à jour !'
				});
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
      	   idCreneau: creneau
         },
         
         success : function(msg, statut){ // success est toujours en place, bien sûr !
	           var msg = $.parseJSON(msg);
	           if(msg.success=='Oui')
	           {
	        	   $.alert({
						columnClass: 'medium',
				        title : "Suppression d'un créneau",
				        content : msg.data
					});
	        	   
	        	   // Rechargement de la page
	        	   location.reload(true);
	               return true;
	           }
	           else
	           {
	        	   $.alert({
						columnClass: 'medium',
				        title : "Suppression d'un créneau",
				        content : 'Erreur sur le serveur !'
					});
	               return false;
	           }
         },

         error : function(resultat, statut, erreur){
      	   $.alert({
				columnClass: 'medium',
		        title : "Suppression d'un créneau",
		        content : 'Erreur lors de la mise à jour !'
			})
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