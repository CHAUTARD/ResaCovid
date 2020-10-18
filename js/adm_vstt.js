/** adm_vstt.js
 * @version : 1.0.2
 * @date : 2020-10-06
 */

// Setup DataTable Defaults
/*
$.extend( $.fn.dataTable.defaults, {
	fnInitComplete: function(oSettings, json) {

		// Add "Clear Filter" button to Filter
		var btnClear = $('<a class="btnClearDataTableFilter"><span style="color: Tomato;"><i class="fas fa-times-circle"></i></span></a>');
		
		btnClear.appendTo($('#' + oSettings.sTableId).parents('.dataTables_wrapper').find('.dataTables_filter'));
		$('#' + oSettings.sTableId + '_wrapper .btnClearDataTableFilter').click(function () {
			$('#' + oSettings.sTableId).dataTable().fnFilter('');
		});
	}
});
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
 * Envoye d'un email à partir du formulaire de contact
 */

function SendContactEmail() {

    $.ajax({
        type: "GET",
        url: "admin.php?page=send_email",
        data: {
        	nom:  $("#emailNom").val(),
        	email: $("#emailAdresse").val(),
        	message: $("#emailMessage").val()
        },
        success : function(response){  
			$.alert({
				columnClass: 'medium',
			    title: 'Courriel',
			    content: response
			})
        }
    });
    
    return false;
}

/*
 * Confirmation avant la suppression de tables
 */
function ConfirmSubmit() {
	return confirm("Attention cette opération n'est pas reversible, vous allez supprimer toutes les données ?");
}