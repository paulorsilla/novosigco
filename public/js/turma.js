$(document).ready(function() {
	//tabela do avaliação
//	var tabelaCap = $("#tabelaAplicacao").DataTable({
//		 "aaSorting": [0, "asc"],
//		 "bInfo": false,
//		 "ordering": false,
//	      "bFilter": false,
//	      "bLengthChange": false,
//	      "paging": false,
//	      "oLanguage": {
//	      	"sZeroRecords": "",
//	      	"sEmptyTable": ""
//	      },
//	      "columnDefs": [
//	                 { width: "30%", targets: [0] },
//	                 { width: "60%", targets: [1] },
//	                 { width: "10%", targets: [2] },
//	                 { className: "dt-body-center", targets: [2] }
//	             ]
//	});
	
	//tabela de participantes na tela
	var tabelaEmp = $("#tabelaParticipantes").DataTable({
		  "bInfo": false,
	      "bFilter": false,
	      "bLengthChange": false,
	      "paging": false,
	      "rowId": 'staffId',
	      "oLanguage": {
	      	"sZeroRecords": "",
	      	"sEmptyTable": "",
	      	
	      },
	      "columnDefs": [
	                 { width: "30%", targets: [1] },
	                // { width: "20%", targets: [4] },
	                // { width: "10%", targets: [5] },
	                 { className: "dt-body-center", targets: [2] }
	             ]
	});	
	
	var tabelaProg = $('#tabelaProgramacao').DataTable({	
			  "bInfo": false,
		      "bFilter": false,
		      "bLengthChange": false,
		      "paging": false,
		      "oLanguage": {
		      	"sZeroRecords": "",
		      	"sEmptyTable": "",
		      	
		      },
		      "columnDefs": [
		                 { width: "18%", targets: [0] },
		                 { width: "18%", targets: [1] },
		                 { width: "18%", targets: [2] },
		                 { width: "36%", targets: [3] },
		                 {"className": "dt-left", "targets": "_all"},
		             ]
		});	
	
	//tabelas
	$("#tabs").tabs();
	$("#selecoes").tabs();
	
	//variaveis referentes a empregado
	var listaId = $("#id").val();
	var empregadosSelecionados = [];
	var empregadosMap = [];
//	var esperasSelecionadas = [];
//	var esperasMap = [];
	var tabelaSelecaoEmpregados = "<table id='selecaoEmpregados'><thead><tr><th>Matricula</th><th>Nome</th></tr></thead><tbody>";
	var tabelaSelecaoParticipantes = "<table id='selecaoParticipantes'><thead><tr><th>Matricula</th><th>Nome</th></tr></thead><tbody>";
	//busca os empregados no banco de dados
	$.ajax({
        type: 'POST',
        dataType: "json",
        async: false,
        url: "/application/empregado/buscaempregados",
        success: function(d) {
        	empregados = $.parseJSON(d.empregados);
        	$.each(empregados, function (index, value){
        		tabelaSelecaoEmpregados += "<tr><td><input type = 'hidden' id='idEmpregado' value='"+value.matricula+"'>"+value.matricula+"</td>" +
				"<td>"+value.nome+"</td>" +
				"</tr>";
        		empregadosMap[value.matricula] = value.matricula +"&&&"+ value.nome;
        	});
        	tabelaSelecaoEmpregados += "</tbody></table>";
        }
	});

//	//busca empregados, em caso de edição
//	if (listaId > 0) {
//		$.ajax({
//	        type: 'POST',
//	        dataType: "json",
//	        async: false,
//	        data: {listaId:listaId},
//	        url: "/application/empregado/buscaempregado",
//	        success: function(d) {
//	        	var emp = $.parseJSON(d.empregados);
//	        	$.each(emp, function (index, value){
//	        		empregadosSelecionados.push(value.matricula); 
//	        	});
//	        	adicionaEmpregado();
//	        }
//		});
//	}
	
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
	// botões salvar e cancelar
	$("#cancelar").click(function(e) {
		e.preventDefault();
		window.location ="/application/turma";
	});
	$("#salvar").click(function(e) {
		e.preventDefault();
		$("#submit").click();
	});
	
	//botão "novo" com sinal de +
	$("button[id^='nov']").button({
		icons: {
			primary: "ui-icon-plus",
		},
		//text: false,
	});
	
	//aplicando js nos selects menus
	$("#capacitacao").selectmenu({
				change: function(e, ui) {
					e.preventDefault();
					$("#tabelaQuestionario tbody").html("");
					tabelaSelecaoParticipantes = "<table id='selecaoParticipantes'><thead><tr><th>Matricula</th><th>Nome</th></tr></thead><tbody>";
					//busca listas de esperas
					$.ajax({
				        type: 'POST',
				        dataType: "json",
				        data: {idCapacitacao:$(this).val()},
				        async: false,
				        url: "/application/lista-espera/buscalistaespera",
				        success: function(d) {
				        	var	empregados = $.parseJSON(d.empregados);
				        	$.each(empregados, function (index, value){
				        		tabelaSelecaoParticipantes += "<tr><td><input type = 'hidden' id='idParticipante' value='"+value.matricula+"'>"+value.matricula+"</td>" +
								"<td>"+value.nome+"</td></tr>";
				        		empregadosMap[value.matricula] = value.matricula +"&&&"+ value.nome;
				        	});
				        	tabelaSelecaoParticipantes += "</tbody></table>";
				        }
					});
					
					$.ajax({
				        type: 'POST',
				        dataType: "json",
				        data: {idCapacitacao:$(this).val()},
				        async: false,
				        url: "/application/capacitacao/buscacompetencias",
				        success: function(d) {
				        	var	questionario = $.parseJSON(d.competencias);
				        	$.each(questionario, function(index, value){
				        		$("#tabelaQuestionario tbody").append('<tr><td>'+value.titulo+'</td><td></td><td></td></tr>');
				        		
				        	});
				        }	
					});
				}
			});
	$("#instituicao").selectmenu();
	$("#instrutor").selectmenu();
	$("#coordenacao").selectmenu();
	$("#aplicacao").selectmenu();
	
	
	//janela modal para seleção de empregados
	var dialogEmpregados = $("#modal-participantes").dialog({
		autoOpen : false,
		height : 700,
		width : 950,
		modal : true,
		buttons : {
			"Concluir" : function(e) {
				e.preventDefault();
				adicionaEmpregado();
    			$(this).dialog("close");
			}
		}
	});
	$("#novoParticipante").button({
		icons : {
			primary : "ui-icon-plus",
		},
	}).on('click', function( e ) {
		e.preventDefault();
		var capacitacaoID = $("#capacitacao").val();
		if(capacitacaoID == ""){
			alert("Selecione uma capacitação no menu acima");
			return false;
		}
		empregadosSelecionados = [];
		
		$("#empregados").html(tabelaSelecaoEmpregados);
    	$("#selecaoEmpregados").DataTable({
    		"pageLength": 15,
    		"order": [[ 1, "asc" ]],
    		"bLengthChange": false,
    		"bInfo": false,
    	});

    	dialogEmpregados.dialog("open");
		$("#selecaoEmpregados tbody").on('click','tr',function(e){
			 var matricula = $(this).find("#idEmpregado").val();
			 $(this).toggleClass('selected');
			 var indice = empregadosSelecionados.indexOf(matricula); 
			 if(indice === -1){
				 empregadosSelecionados.push(matricula); 
			 }
			 else{
				 empregadosSelecionados.splice(indice, 1);
			 }
		});
	});	
	
	function adicionaEmpregado(){
		$.each(empregadosSelecionados, function (index, value){
			var aux = empregadosMap[value].split("&&&");
			if($("#excluirEmpregado_"+value).length == 0){
				tabelaEmp
				 .row
				 .add (["<input type= 'hidden' id= 'empregado' name= 'matricula[]' value = '"+value+"'>"+aux[0], aux[1], '<button id="excluirEmpregado_'+value+'">Remover empregado</button>'])
				 .draw();
				$("#excluirEmpregado_"+value).button({
					icons: {
						primary: "ui-icon-trash",
				},
				text: false
				}).click(function(e) {
					e.preventDefault();
					if(confirm("Deseja realmente excluir?")) {
						tabelaEmp.row($(this).parents('tr')).remove().draw();
						}
					});
				}
		});
	}
	
	//Janela modal lista de espera
	var dialogEsperas = $("#modal-listaEspera").dialog({
		autoOpen : false,
		height : 700,
		width : 950,
		modal : true,
		buttons : {
			"Concluir" : function(e) {
				e.preventDefault();
				adicionaEmpregado();
    			$(this).dialog("close");
			}
		}
	});
	
	$("#novalistaEspera").button({
		icons : {
			primary : "ui-icon-plus",
		},
	}).on('click', function( e ) {
		e.preventDefault();	
		var capacitacaoID = $("#capacitacao").val();
		if (capacitacaoID == ""){
			alert("Selecione uma Capacitação no menu acima");
			return false;
		}
		empregadosSelecionados = [];
		$("#esperas").html(tabelaSelecaoParticipantes);
    	$("#selecaoParticipantes").DataTable({
    		"pageLength": 15,
    		"order": [[ 1, "asc" ]],
    		"bLengthChange": false,
    		"bInfo": false,
    	});
	
    	dialogEsperas.dialog("open");
    	
		$("#selecaoParticipantes tbody").on('click','tr',function(e){
			 var participanteID = $(this).find("#idParticipante").val();
			 $(this).toggleClass('selected');
			 var indice = empregadosSelecionados.indexOf(participanteID); 
			 if(indice === -1){
				empregadosSelecionados.push(participanteID);
			 }
			 else{
				empregadosSelecionados.splice(indice, 1);
			 }
		});
	});		
	$("#novaProgramacao").on('click',function(e){
		e.preventDefault();
		var id = $("#tabelaProgramacao tr").length-1;
		tabelaProg.row.add([
			"<td><input type='text' style='width: 210px' id='dataRealizacao_"+id+"' name='dataRealizacao[]'></td>",
			"<td><input type='text' style='width: 250px' id='horaInicial_"+id+"' name='horaInicial[]'></td>",
			"<td><input type='text' style='width: 250px' id='horaFinal_"+id+"' name='horaFinal[]'></td>",
			"<td><input type='text' style='width: 550px' id='local_"+id+"' name='local[]'></td>",
			"<td><button id='removerProgramacao_"+id+"'>Remover</button>"
		]).draw();

		$("#removerProgramacao_"+id).button({
			icons: {
				primary: "ui-icon-trash",
			},
		text: false,
		});
			
		//calenadário
		$("#dataRealizacao_"+id).datepicker({
		    dateFormat: 'dd-mm-yy',
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
			selectOtherMonths : true,
			DateFormat : ["mm-dd-yyyy"]
		});
		
		//mascara da aba programação:
		 $('#dataRealizacao_'+id).mask('00-00-0000');
		 $('#horaInicial_'+id).mask('00:00');
		 $('#horaFinal_'+id).mask('00:00');
		
		var removerProg = $("#removerProgramacao_"+id).on('click',function(e){
			e.preventDefault();
	
		});
	});
	
//	function adicionaLinhas(){
//				$("#tabelaProgramacao tbody").append(
//				"<tr>"+
//				"<td></td>"+
//				"<td></td>"+
//				"<td></td>"+
//				"<td></td>"+
//				"<td><button id='removerProgramacao' title='Remover Programação'>Remover</button><input type='text' id='sequencia'></td>"+
//				"</tr>"
//				);
//				$("#removerProgramacao").button({
//					icons : {
//						primary : "ui-icon-trash",
//					},
//				}).on('click', function(e){
//					e.preventDefault();
//					var row = $(this).closest('tr').get(0); 
//					tabelaProg.row(row).remove().draw();
//					atualizaSequencia();
//				});
//				atualizaSequencia();
//	}
	function atualizaSequencia(){
//		var sequencia = $("#sequencia");
		var id = 1;
		$.each($('input[id="sequencia"]'), function (index, value){
			$(this).val(id++);
		});
	}
	
//fim do documento
});