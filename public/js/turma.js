$(document).ready(function() {
	//tabela do questionário
	var tabelaCap = $("#tabelaQuestionario").DataTable({
		 "aaSorting": [0, "asc"],
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
	//tabela de participantes na tela
	var tabelaParticipantes = $("#tabelaParticipantes").DataTable({
		  "bInfo": false,
	      "bFilter": false,
	      "bLengthChange": false,
	      "paging": false,
	      "oLanguage": {
	      	"sZeroRecords": "",
	      	"sEmptyTable": ""
	      },
	      "columnDefs": [
	                 { width: "30%", targets: [1] },
	                 { width: "20%", targets: [4] },
	                 { width: "10%", targets: [5] },
	                 { className: "dt-body-center", targets: [2] }
	             ]
	});

	//calenadário
	$("#inicial").datepicker({
	    dateFormat: 'dd/mm/yy',
	    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
	    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
	    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
	    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
	    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
	    nextText: 'Próximo',
	    prevText: 'Anterior',			
	    showOn : "button",
		buttonImage : "/images/calendar.gif",
		buttonImageOnly : true,
		buttonText : "Selecione a data",
		showOtherMonths : true,
		selectOtherMonths : true
	});
	
	$("input[id='final']").setMask()
	.datepicker({
	    dateFormat: 'dd/mm/yy',
	    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
	    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
	    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
	    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
	    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
	    nextText: 'Próximo',
	    prevText: 'Anterior',			
	    showOn : "button",
		buttonImage : "/images/calendar.gif",
		buttonImageOnly : true,
		buttonText : "Selecione a data",
		showOtherMonths : true,
		selectOtherMonths : true
	});
	
	//tabelas
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