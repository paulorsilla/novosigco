$(document).ready(function() {
	$("#submit").hide();
}
	$("#cancelar").button({
		icons: {
			primary: "ui-icon-close",
		},
	text: true,
	});
	$("#salvar").button({
		icons: {
			primary: "ui-icon-disk",
		},
	text: true,
	});

	$("#cancelar").click(function(e) {
		e.preventDefault();
		window.location ="/application/turma";
	});

	$("#salvar").click(function(e) {
		e.preventDefault();
		$("#submit").click();
	});
	$("#tabs").tabs();
	
	
	//fim do documento
	}