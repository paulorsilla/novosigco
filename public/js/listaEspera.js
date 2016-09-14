$(document).ready(function() {
	var tabelaComp = $("#listaEmpregado").DataTable({
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
	var empregadoMatricula = $("#id").val();
	var empregadosSelecionados = [];
	var empregadosMap = [];
	var tabelaSelecaoEmpregados = "<table id='selecaoEmpregados'><thead><tr><th>Matricula</th><th>Nome</th></tr></thead><tbody>";
	
	//busca os empregados no banco de dados
	$.ajax({
        type: 'POST',
        dataType: "json",
        async: false,
        url: "/application/empregado/buscaempregado",
        success: function(d) {
        	empregados = $.parseJSON(d.empregados);
        	$.each(empregados, function (index, value){
        		tabelaSelecaoEmpregados += "<tr><td><input type = 'hidden' id='idCompetencia' value='"+value.id+"'>"+value.titulo+"</td>" +
        				"<td>"+value.tipo+"</td>" +
        				"</tr>";
        		empregadosMap[value.id] = value.titulo +"&&&"+ value.tipo;
        	});
        	tabelaSelecaoEmpregados += "</tbody></table>";
        }
	});
	
	
	
	//Função do botão adicionar participantes para abrir janela modal
	$("#adicionarParticipantes").button({
		icons : {
			primary : "ui-icon-plus",
		},
	}).on('click', function( e ) {
		e.preventDefault();
		empregadosSelecionados = [];
	
	
	
//fechar documento	
});