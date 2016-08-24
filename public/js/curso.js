$(document).ready(function() {
	var tabelaComp = $("#competenciasCurso").DataTable({
      "bSort":false,
      "bInfo": false,
      "bFilter": false,
      "bLengthChange": false,
      "oLanguage": {
      	"sZeroRecords": "",
      	"sEmptyTable": ""
      },
      "columnDefs": [
                 { width: "40%", targets: [0, 1] },
                 { className: "dt-body-center", targets: [2] }
             ]
	});
	var cursoId = $("#id").val();
	var competenciasSelecionadas = [];
	var competenciasMap = [];
	var tabelaSelecaoCompetencias = "<table id='selecaoCompetencias'><thead><tr><th>Descrição</th><th>Tipo de competência</th></tr></thead><tbody>";

	//busca as competências no banco de dados
	$.ajax({
        type: 'POST',
        dataType: "json",
        async: false,
        url: "/application/competencia/buscacompetencia",
        success: function(d) {
        	competencias = $.parseJSON(d.competencias);
        	$.each(competencias, function (index, value){
        		tabelaSelecaoCompetencias += "<tr><td><input type = 'hidden' id='idCompetencia' value='"+value.id+"'>"+value.titulo+"</td>" +
        				"<td>"+value.tipo+"</td>" +
        				"</tr>";
        		competenciasMap[value.id] = value.titulo +"&&&"+ value.tipo;
        	});
        	tabelaSelecaoCompetencias += "</tbody></table>";
        }
	});
	
	
	if (cursoId > 0) {
		//busca competencias do curso, em caso de edição
		$.ajax({
	        type: 'POST',
	        dataType: "json",
	        async: false,
	        data: {cursoId:cursoId},
	        url: "/application/curso/buscacompetencias",
	        success: function(d) {
	        	var comp = $.parseJSON(d.competencias);
	        	$.each(comp, function (index, value){
	        		competenciasSelecionadas.push(value.id);
	        	});
	        	adicionaCompetencia();
	        }
		});
	}	
	//janela modal para seleção de competências
	var dialogCompetencias = $("#modal-competencia").dialog({
		autoOpen : false,
		height : 624,
		width : 924,
		modal : true,
		buttons : {
			"Concluir" : function(e) {
				e.preventDefault();
				adicionaCompetencia();
    			$(this).dialog("close");
			}
		}
	});
	$("#novaCompetencia").button({
		icons : {
			primary : "ui-icon-plus",
		},
	}).on('click', function( e ) {
		e.preventDefault();
		competenciasSelecionadas = [];

		$("#competencias").html(tabelaSelecaoCompetencias);
    	$("#selecaoCompetencias").DataTable({
    		"bLengthChange": false,
    		"bInfo": false,
    	});
		
		dialogCompetencias.dialog("open");
		$("#selecaoCompetencias tbody").on('click','tr',function(e){
			 var id = $(this).find("#idCompetencia").val();
			 $(this).toggleClass('selected');
			 var indice = competenciasSelecionadas.indexOf(id);
			 if(indice === -1){
				 competenciasSelecionadas.push(id);
			 }
			 else{
				 competenciasSelecionadas.splice(indice, 1);
			 }
		});
	});
	
	function adicionaCompetencia(){	
		$.each(competenciasSelecionadas, function (index, value){
			var aux = competenciasMap[value].split("&&&");
			if($("#excluirCompetencia_"+value).length == 0){
				tabelaComp
				 .row
				 .add (["<input type= 'hidden' id= 'competencia' name= 'competencia[]' value = '"+value+"'>"+aux[0], aux[1], '<button id="excluirCompetencia_'+value+'">Remover competência</button>'])
				 .draw();
				$("#excluirCompetencia_"+value).button({
					icons: {
						primary: "ui-icon-trash",
				},
				text: false
				}).click(function(e) {
					e.preventDefault();
					if(confirm("Deseja realmente excluir?")) {
						tabelaComp.row($(this).parents('tr')).remove().draw();
						}
					});
				}
		});
	}
});