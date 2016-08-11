$(document).ready(function() {
	
	$("#hidden").hide();
	$("body").css('background-image', 'none');
	
	/*
	 * Janela modal que apresenta o formulário de login
	 */
    $( "#dialog-form" ).dialog({
    	dialogClass: 'no-close',
        autoOpen: true,
        resizable: false,
        closeOnEscape: false,
        draggable: false,
        height: 220,
        width: 350,
        modal: false,
        buttons: {
              "Entrar": function() {
                  $("#submitbutton").trigger("click");
              }
        }
    });
});
