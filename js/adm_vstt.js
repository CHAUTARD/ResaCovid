/* adm_vstt.js
 * Version : 1.0.1
 * Date : 2020-10-02
 */

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


/*
 * Confirmation avant la suppression de tables
 */
function ConfirmSubmit() {
	return confirm("Attention cette opération n'est pas reversible, vous allez supprimer toutes les données ?");
}