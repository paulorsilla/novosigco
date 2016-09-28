$(document).ready(function() {
	var tabelaCap = $("#tabelaCapacitacoes").DataTable({
		 "bInfo": false,
	      "bFilter": false,
	      "bLengthChange": false,
	      "paging": false,
	      "oLanguage": {
	      	"sZeroRecords": "",
	      	"sEmptyTable": ""
	      },
	      "columnDefs": [
	                 { width: "60%", targets: [0] },
	                 { width: "30%", targets: [1] },
	                 { width: "10%", targets: [2] },
	                 { className: "dt-body-center", targets: [2] }
	             ]
	});

	
	$("#tabs").tabs();
	$("#selecoes").tabs();
	
	$("#submit").hide();

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
	
	
	//botão "novo" com sinal de +
	$("button[id^='nov']").button({
		icons: {
			primary: "ui-icon-plus",
		},
	});
	$("#novaPergunta").click(function(e){
		e.preventDefault();
	});
	
	
	//aplicando js nos selects menus
	$("#capacitacao").selectmenu();
	$("#instituicao").selectmenu();
	$("#instrutor").selectmenu();
	
	$("#cancelar").click(function(e) {
		e.preventDefault();
		window.location ="/application/turma";
	});

	$("#salvar").click(function(e) {
		e.preventDefault();
		$("#submit").click();
	});
	
	
	
//fim do documento
});