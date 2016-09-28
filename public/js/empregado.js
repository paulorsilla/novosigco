$(document).ready(function() {
	
	var matricula = $("#matricula").val();
	$("#supervisor").change(function(){
		$.ajax({
	        type: 'POST',
	        dataType: "json",
	        url: "/application/empregado/save",
	        data: { matricula:matricula, 
	        	    supervisor:$(this).find(":selected").val() },
	        });
//		alert($(this).find(":selected").val());
		});
	
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
	
	$("input[id^='data']").setMask()
		.datepicker({
			showOtherMonths : true,
			selectOtherMonths : true,
			dateFormat : 'dd/mm/yy',
			showOn : "button",
			buttonImage : "/images/calendar.gif",
			buttonImageOnly : true,
			buttonText : "Selecione a data"
		});
	
	$("button[id^='nov']").button({
		icons: {
			primary: "ui-icon-plus",
		},
	});

	$("#cancelar").click(function(e) {
		e.preventDefault();
		window.location ="/application/empregado";
	});

	$("#salvar").click(function(e) {
		e.preventDefault();
		$("#submit").click();
	});

	$("#tabs").tabs();
//	$("#historico").tabs();

	var tabelaCargos = $("#tabelaCargos").DataTable({
        					"bLengthChange": false,
        			        "bSort":false,
        			        "bInfo": false,
        			        "bFilter": false,
        			        "oLanguage": {
        			        	"sZeroRecords": "",
        			        	"sEmptyTable": ""
        			        },
        			        "columnDefs": [
    			                       { width: "20%", targets: [1, 2, 3] },
    			                       { className: "dt-body-center", targets: [1, 2, 3] }
    			                   ]
    					});

    var tabelaAreas = $("#tabelaAreas").DataTable({
					        "bLengthChange": false,
					        "bSort":false,
        			        "bInfo": false,
        			        "bFilter": false,
        			        "oLanguage": {
        			        	"sZeroRecords": "",
        			        	"sEmptyTable": ""
        			        },
        			        "columnDefs": [
        			                       { width: "16%", targets: [2, 3, 4] },
        			                       { className: "dt-body-center", targets: [2, 3, 4] }
        			                   ]
					    });
    
	var tabelaFuncoes = $("#tabelaFuncoes").DataTable({
							"bLengthChange": false,
					        "bSort":false,
					        "bInfo": false,
					        "bFilter": false,
					        "oLanguage": {
					        	"sZeroRecords": "",
					        	"sEmptyTable": ""
					        },
					        "columnDefs": [
					                   { width: "10%", targets: [1, 2, 3, 4 ] },
					                   { className: "dt-body-center", targets: [1, 2, 3, 4] }
					               ]
						});

	var tabelaOutrasFuncoes = $("#tabelaOutrasFuncoes").DataTable({
		"bLengthChange": false,
        "bSort":false,
        "bInfo": false,
        "bFilter": false,
        "oLanguage": {
        	"sZeroRecords": "",
        	"sEmptyTable": ""
        },
        "columnDefs": [
                   { width: "20%", targets: [1, 2, 3] },
                   { className: "dt-body-center", targets: [1, 2, 3] }
               ]
	});
	
	var tabelaEquipesTecnicas = $("#tabelaEquipesTecnicas").DataTable({
		"bLengthChange": false,
        "bSort":false,
        "bInfo": false,
        "bFilter": false,
        "oLanguage": {
        	"sZeroRecords": "",
        	"sEmptyTable": ""
        },
        "columnDefs": [ 
                   { width: "20%", targets: [1, 2, 3] },
                   { className: "dt-body-center", targets: [1, 2, 3] }
               ]
	});
	
	var tabelaSublotacoes = $("#tabelaSublotacoes").DataTable({
		"bLengthChange": false,
        "bSort":false,
        "bInfo": false,
        "bFilter": false,
        "oLanguage": {
        	"sZeroRecords": "",
        	"sEmptyTable": ""
        },
        "columnDefs": [
                   { width: "20%", targets: [1, 2, 3] },
                   { className: "dt-body-center", targets: [1, 2, 3] }
               ]
	});
	
    var tabelaEscolaridades = $("#tabelaEscolaridades").DataTable({
        "bLengthChange": false,
        "bSort":false,
        "bInfo": false,
        "bFilter": false,
        "oLanguage": {
        	"sZeroRecords": "",
        	"sEmptyTable": ""
        },
        "columnDefs": [
                       { width: "23%", targets: [0, 1, 2] },
                       { width: "10%", targets: [3, 4] },
                       { className: "dt-body-center", targets: [3, 4] }
                   ]
    });

	var tabelaLotacaoAnterior = $("#tabelaLotacaoAnterior").DataTable({
		"bLengthChange": false,
        "bSort":false,
        "bInfo": false,
        "bFilter": false,
        "oLanguage": {
        	"sZeroRecords": "",
        	"sEmptyTable": ""
        },
        "columnDefs": [
                   { width: "20%", targets: [1, 2, 3] },
                   { className: "dt-body-center", targets: [1, 2, 3] }
               ]
	});
	
	
	var areas = "", cargos = "", funcoes = "", outrasFuncoes = "", equipes = "", sublotacoes = "", escolaridades = "", instituicoes = "", instituicoesPesquisa = "";
	
	$.ajax({
        type: 'POST',
        dataType: "json",
        async: false,
        url: "/application/empregado/buscaempregado",
        data: { matricula:matricula },
        success: function(d) {
        	$("#nomeEmpregado").html(matricula+ " - "+d.empregado);
        }
	});

	$.ajax({
        type: 'POST',
        dataType: "json",
        async: false,
        url: "/application/area/buscaareas",
        success: function(d) {
        	areas = d.areas;
			$("#subareaAtuacao").html("<option val=''>---Selecione uma subárea ---</option>");
        }
	});
	
	$.ajax({
        type: 'POST',
        dataType: "json",
        async: false,
        url: "/application/cargo/buscacargos",
        success: function(d) {
        	cargos = d.cargos;
        }
	});
	
	$.ajax({
        type: 'POST',
        dataType: "json",
        async: false,
        url: "/application/funcao/buscafuncoes",
        success: function(d) {
        	funcoes = d.funcoes;
        }
	});

	$.ajax({
        type: 'POST',
        dataType: "json",
        async: false,
        url: "/application/outra-funcao/buscaoutrasfuncoes",
        success: function(d) {
        	outrasFuncoes = d.outrasFuncoes;
        }
	});
	
	$.ajax({
        type: 'POST',
        dataType: "json",
        async: false,
        url: "/application/equipe-tecnica/buscaequipestecnicas",
        success: function(d) {
        	equipes = d.equipes;
        }
	});
	
	$.ajax({
        type: 'POST',
        dataType: "json",
        async: false,
        url: "/application/sublotacao/buscasublotacoes",
        success: function(d) {
        	sublotacoes = d.sublotacoes;
        }
	});
	
	$.ajax({
        type: 'POST',
        dataType: "json",
        async: false,
        url: "/application/escolaridade/buscaescolaridades",
        success: function(d) {
        	escolaridades = d.escolaridades;
        }
	});

	$.ajax({
        type: 'POST',
        dataType: "json",
        async: false,
        url: "/application/instituicao/buscainstituicoes",
        success: function(d) {
        	instituicoes = d.instituicoes;
        	instituicoesPesquisa = d.instituicoesPesquisa;
        }
	});
	
	var dialogCargo = $("#modal-cargo").dialog({
		autoOpen : false,
		height : 340,
		width : 530,
		modal : true,
		buttons : {
			"Salvar" : function(e) {
				e.preventDefault();
				var id = dialogCargo.data('id');
				var janela = $(this);
				var cargo = $("#cargo").val();
				var dataInicial = $("#dataInicialCargo").val();
				var dataFinal = $("#dataFinalCargo").val();
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: '/application/empregado/addcargo',
					data: {
						matricula:matricula,
						cargo:cargo,
						dataInicialCargo:dataInicial,
						dataFinalCargo:dataFinal,
						id:id
					},
					success: function(d) {
						janela.dialog("close");
						tabelaCargos.clear().draw();
						buscaCargosEmpregado();
					}
				});
			}
		},
	});
	
	var dialogArea = $("#modal-area").dialog({
		autoOpen : false,
		height : 340,
		width : 530,
		modal : true,
		buttons : {
			"Salvar" : function(e) {
				e.preventDefault();
				var id = dialogArea.data('id');
				var janela = $(this);
				var area = $("#areaAtuacao").val();
				var subarea = $("#subareaAtuacao").val();
				var dataInicial = $("#dataInicialArea").val();
				var dataFinal = $("#dataFinalArea").val();
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: '/application/empregado/addareasubarea',
					data: {
						matricula:matricula,
						area:area,
						subarea:subarea,
						dataInicialArea:dataInicial,
						dataFinalArea:dataFinal,
						id:id
					},
					success: function(d) {
						janela.dialog("close");
						tabelaAreas.clear().draw();
						buscaAreasEmpregado();
					}
				});
			}
		},
	});
	
	var dialogFuncao = $("#modal-funcao").dialog({
		autoOpen : false,
		height : 350,
		width : 530,
		modal : true,
		buttons : {
			"Salvar" : function(e) {
				e.preventDefault();
				var id = dialogFuncao.data('id');
				var janela = $(this);
				var funcao = $("#funcao").val();
				var dataInicial = $("#dataInicialFuncao").val();
				var dataFinal = $("#dataFinalFuncao").val();
				var cbo = $("#cbo").val();
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: '/application/empregado/addfuncao',
					data: {
						matricula:matricula,
						funcao:funcao,
						dataInicialFuncao:dataInicial,
						dataFinalFuncao:dataFinal,
						cbo:cbo,
						id:id
					},
					success: function(d) {
						janela.dialog("close");
						tabelaFuncoes.clear().draw();
						buscaFuncoesEmpregado();
					}
				});
			}
		},
	});

	var dialogOutraFuncao = $("#modal-outra-funcao").dialog({
		autoOpen : false,
		height : 340,
		width : 530,
		modal : true,
		buttons : {
			"Salvar" : function(e) {
				e.preventDefault();
				var id = dialogOutraFuncao.data('id');
				var janela = $(this);
				var outraFuncao = $("#outraFuncao").val();
				var dataInicial = $("#dataInicialOutraFuncao").val();
				var dataFinal = $("#dataFinalOutraFuncao").val();
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: '/application/empregado/addoutrafuncao',
					data: {
						matricula:matricula,
						outraFuncao:outraFuncao,
						dataInicialOutraFuncao:dataInicial,
						dataFinalOutraFuncao:dataFinal,
						id:id
					},
					success: function(d) {
						janela.dialog("close");
						tabelaOutrasFuncoes.clear().draw();
						buscaOutrasFuncoesEmpregado();
					}
				});
			}
		},
	});

	var dialogEquipeTecnica = $("#modal-equipe-tecnica").dialog({
		autoOpen : false,
		height : 340,
		width : 530,
		modal : true,
		buttons : {
			"Salvar" : function(e) {
				e.preventDefault();
				var id = dialogEquipeTecnica.data('id');
				var janela = $(this);
				var equipeTecnica = $("#equipeTecnica").val();
				var dataInicial = $("#dataInicialEquipeTecnica").val();
				var dataFinal = $("#dataFinalEquipeTecnica").val();
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: '/application/empregado/addequipetecnica',
					data: {
						matricula:matricula,
						equipeTecnica:equipeTecnica,
						dataInicialEquipeTecnica:dataInicial,
						dataFinalEquipeTecnica:dataFinal,
						id:id
					},
					success: function(d) {
						janela.dialog("close");
						tabelaEquipesTecnicas.clear().draw();
						buscaEquipesTecnicasEmpregado();
					}
				});
			}
		},
	});
	
	var dialogSublotacao = $("#modal-sublotacao").dialog({
		autoOpen : false,
		height : 340,
		width : 530,
		modal : true,
		buttons : {
			"Salvar" : function(e) {
				e.preventDefault();
				var id = dialogSublotacao.data('id');
				var janela = $(this);
				var sublotacao = $("#sublotacao").val();
				var dataInicial = $("#dataInicialSublotacao").val();
				var dataFinal = $("#dataFinalSublotacao").val();
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: '/application/empregado/addsublotacao',
					data: {
						matricula:matricula,
						sublotacao:sublotacao,
						dataInicialSublotacao:dataInicial,
						dataFinalSublotacao:dataFinal,
						id:id
					},
					success: function(d) {
						janela.dialog("close");
						tabelaSublotacoes.clear().draw();
						buscaSublotacoesEmpregado();
					}
				});
			}
		},
	});
	
	var dialogEscolaridade = $("#modal-escolaridade").dialog({
		autoOpen : false,
		height : 500,
		width : 530,
		modal : true,
		buttons : {
			"Salvar" : function(e) {
				e.preventDefault();
				var id = dialogEscolaridade.data('id');
				var janela = $(this);
				var escolaridade = $("#escolaridade").val();
				var instituicao =  $("#instituicao").val();
				var curso = $("#curso").val();
				
				var now = new Date();
				var anoConclusao = $("#anoConclusaoEscolaridade").val();
				if (anoConclusao != "") {
					anoConclusao = parseInt(anoConclusao);
				}
				
				if ((anoConclusao != "") && (anoConclusao <= 1950 || anoConclusao > now.getFullYear())) {
					$("#mensagem").html("Ano de conclusão inválido");
					$("#mensagem").show();
					$("#mensagem").fadeOut(5000);
				} else {
					$.ajax({
						type: 'POST',
						dataType: 'json',
						url: '/application/empregado/addescolaridade',
						data: {
							matricula:matricula,
							escolaridade:escolaridade,
							instituicao:instituicao,
							curso:curso,
							anoconclusao:anoConclusao,
							id:id 	
						},
						success: function(d) {
							janela.dialog("close");
							tabelaEscolaridades.clear().draw();
							buscaEscolaridadesEmpregado();
						}
					});
				}
			}
		},
	});
	
	var dialogLotacaoAnterior = $("#modal-lotacao-anterior").dialog({
		autoOpen : false,
		height : 400,
		width : 640,
		modal : true,
		buttons : {
			"Salvar" : function(e) {
				
				e.preventDefault();
				var id = dialogLotacaoAnterior.data('id');
				var janela = $(this);
				var instituicao =  $("#lotacaoAnterior").val();
				var dataInicial = $("#dataInicialLotacaoAnterior").val();
				var dataFinal = $("#dataFinalLotacaoAnterior").val();
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: '/application/empregado/addlotacaoanterior',
					data: {
						matricula:matricula,
						instituicao:instituicao,
						dataInicial:dataInicial,
						dataFinal:dataFinal,
						id:id 	
					},
				success: function(d) {
						janela.dialog("close");
						tabelaLotacaoAnterior.clear().draw();
						buscaLotacoesAnterioresEmpregado();
					}
				});
			}
		},
	});
	
	$("#cargo").html(cargos).selectmenu();
	$("#areaAtuacao").html(areas).selectmenu({
		change: function(e, ui) {
			e.preventDefault();
			$.ajax({
				type: 'POST',
				dataType: "json",
				async: false,
				data: {area:$(this).val()},
				url: "/application/subarea/buscasubareas",
				success: function(d) {
					$("#subareaAtuacao").html(d.subareas)
						.val("")
						.selectmenu("refresh");
				}
			});
		}
	});
	$("#subareaAtuacao").selectmenu();	
	$("#funcao").html(funcoes).selectmenu();
	$("#outraFuncao").html(outrasFuncoes).selectmenu();
	$("#equipeTecnica").html(equipes).selectmenu();
	$("#sublotacao").html(sublotacoes).selectmenu();
	$("#escolaridade").html(escolaridades).selectmenu();
	$("#instituicao").html(instituicoes).selectmenu();
	$("#lotacaoAnterior").html(instituicoesPesquisa).selectmenu();
	
	$("#novoCargo").click(function(e) {
		e.preventDefault();
		$("#cargo").val("").selectmenu("refresh");
		$("#dataInicialCargo").val("");
		$("#dataFinalCargo").val("");
		dialogCargo.data('id', -1);
		dialogCargo.dialog("open");
	});
	
	$("#novaArea").click(function(e) {
		e.preventDefault();
		$("#areaAtuacao").val("").selectmenu("refresh");
		$("#subareaAtuacao").html("<option val=''>---Selecione uma subárea ---</option>")
			.val("")
			.selectmenu("refresh");
		$("#dataInicialArea").val("");
		$("#dataFinalArea").val("");
		dialogArea.dialog("open");
	});
	
	$("#novaFuncao").click(function(e) {
		e.preventDefault();
		$("#funcao").val("").selectmenu("refresh");
		$("#dataInicialFuncao").val("");
		$("#dataFinalFuncao").val("");
		$("#cbo").val("");
		dialogFuncao.data('id', -1);
		dialogFuncao.dialog("open");
	});

	$("#novaOutra").click(function(e) {
		e.preventDefault();
		$("#outraFuncao").val("").selectmenu("refresh");
		$("#dataInicialOutraFuncao").val("");
		$("#dataFinalOutraFuncao").val("");
		dialogOutraFuncao.data('id', -1);
		dialogOutraFuncao.dialog("open");
	});

	$("#novaEquipe").click(function(e) {
		e.preventDefault();
		$("#equipeTecnica").val("").selectmenu("refresh");
		$("#dataInicialEquipeTecnica").val("");
		$("#dataFinalEquipeTecnica").val("");
		dialogEquipeTecnica.data('id', -1);
		dialogEquipeTecnica.dialog("open");
	});

	$("#novaSublotacao").click(function(e) {
		e.preventDefault();
		$("#sublotacao").val("").selectmenu("refresh");
		$("#dataInicialSublotacao").val("");
		$("#dataFinalSublotacao").val("");
		dialogSublotacao.data('id', -1);
		dialogSublotacao.dialog("open");
	});
	
	$("#novaEscolaridade").click(function(e) {
		e.preventDefault();
		$("#escolaridade").val("").selectmenu("refresh");
		$("#instituicao").val("").selectmenu("refresh");
		$("#curso").val("");
		$("#dataInicialEscolaridade").val("");
		$("#dataConclusaoEscolaridade").val("");
		$("#mensagem").fadeOut(0);
		dialogEscolaridade.data("id", "").dialog("open");
	});
	
	$("#novaLotacaoAnterior").click(function(e) {
		e.preventDefault();
//		$("#escolaridade").val("").selectmenu("refresh");x 
		$("#LotacaoAnterior").val("").selectmenu("refresh");
//		$("#curso").val("");
//		$("#dataInicialEscolaridade").val("");
//		$("#dataConclusaoEscolaridade").val("");
		dialogLotacaoAnterior.dialog("open");
	});
	
	buscaCargosEmpregado();
	buscaAreasEmpregado();
	buscaFuncoesEmpregado();
	buscaOutrasFuncoesEmpregado();
	buscaEquipesTecnicasEmpregado();
	buscaSublotacoesEmpregado();
	buscaEscolaridadesEmpregado();
	buscaLotacoesAnterioresEmpregado();
	
	function buscaCargosEmpregado() {
		$.ajax({
			type: 'POST',
			dataType: "json",
			async: false,
			data: {matricula:matricula},
			url: "/application/empregado/buscacargos",
			success: function(d) {
				$.each(d.cargos, function(index, value) {
					var aux = value.split(";");
					tabelaCargos.row.add([aux[1], aux[2], aux[3], "<button id='editarCargo_"+aux[0]+"'>Editar</button><button id='excluirCargo_"+aux[0]+"'>Remover</button>"]).draw();
					
					$("#excluirCargo_"+aux[0]).button({
						icons: {
							primary: "ui-icon-trash",
						},
						text: false
					}).click(function(e) {
						e.preventDefault();
						if(confirm("Deseja realmente excluir?")) {
							var botao = $(this);
							$.ajax({
								type: 'POST',
								data: {id:aux[0]},
								url: "/application/empregado/deletecargo",
								success: function() {
									tabelaCargos.row( botao.parents('tr')).remove().draw();
								}
							});
						}
					});
					
					$("#editarCargo_"+aux[0]).button({
						icons: {
							primary: "ui-icon-pencil",
						},
						text: false
					}).click(function(e) {
						e.preventDefault();
						$("#cargo").val(aux[4]);
						$("#cargo").selectmenu("refresh");
						$("#dataInicialCargo").val(aux[2].replace(/\-/g, '/'));
						$("#dataFinalCargo").val(aux[3].replace(/\-/g, '/'));
						dialogCargo.data('id', aux[0]).dialog("open");
					});
				});
			}
		});
	}
	
	function buscaAreasEmpregado() {
		$.ajax({
			type: 'POST',
			dataType: "json",
			async: false,
			data: {matricula:matricula},
			url: "/application/empregado/buscaareas",
			success: function(d) {
				$.each(d.areas, function(index, value) {
					var aux = value.split(";");
					tabelaAreas.row.add([aux[1], aux[2], aux[3], aux[4], "<button id='editarArea_"+aux[0]+"'>Editar</button><button id='excluirArea_"+aux[0]+"'>Remover</button>"]).draw();
					
					$("#excluirArea_"+aux[0]).button({
						icons: {
							primary: "ui-icon-trash",
						},
						text: false
					}).click(function(e) {
						e.preventDefault();
						if(confirm("Deseja realmente excluir?")) {
							var botao = $(this);
							$.ajax({
								type: 'POST',
								data: {id:aux[0]},
								url: "/application/empregado/deletearea",
								success: function() {
									tabelaAreas.row( botao.parents('tr')).remove().draw();
								}
							});
						}
					});
					
					$("#editarArea_"+aux[0]).button({
						icons: {
							primary: "ui-icon-pencil",
						},
						text: false
					}).click(function(e) {
						e.preventDefault();
						$("#areaAtuacao").val(aux[5]);
						$("#areaAtuacao").selectmenu("refresh");
						
						$.ajax({
							type: 'POST',
							dataType: "json",
							async: false,
							data: {area:aux[5]},
							url: "/application/subarea/buscasubareas",
							success: function(d) {
								$("#subareaAtuacao").html(d.subareas)
									.val(aux[6])
									.selectmenu("refresh");
							}
						});
						$("#dataInicialArea").val(aux[3].replace(/\-/g, '/'));
						$("#dataFinalArea").val(aux[4].replace(/\-/g, '/'));
						dialogArea.data('id', aux[0]).dialog("open");
					});
				});
			}
		});
	}
	
	function buscaFuncoesEmpregado() {
		$.ajax({
			type: 'POST',
			dataType: "json",
			async: false,
			data: {matricula:matricula},
			url: "/application/empregado/buscafuncoes",
			success: function(d) {
				$.each(d.funcoes, function(index, value) {
					var aux = value.split(";");
					tabelaFuncoes.row.add([aux[1], aux[5], aux[2], aux[3], "<button id='editarFuncao_"+aux[0]+"'>Editar</button><button id='excluirFuncao_"+aux[0]+"'>Remover</button>"]).draw();
					
					$("#excluirFuncao_"+aux[0]).button({
						icons: {
							primary: "ui-icon-trash",
						},
						text: false
					}).click(function(e) {
						e.preventDefault();
						if(confirm("Deseja realmente excluir?")) {
							var botao = $(this);
							$.ajax({
								type: 'POST',
								data: {id:aux[0]},
								url: "/application/empregado/deletefuncao",
								success: function() {
									tabelaFuncoes.row( botao.parents('tr')).remove().draw();
								}
							});
						}
					});
					
					$("#editarFuncao_"+aux[0]).button({
						icons: {
							primary: "ui-icon-pencil",
						},
						text: false
					}).click(function(e) {
						e.preventDefault();
						$("#funcao").val(aux[4]);
						$("#funcao").selectmenu("refresh");
						$("#dataInicialFuncao").val(aux[2]);
						$("#dataFinalFuncao").val(aux[3]);
						$("#cbo").val(aux[5]);
						dialogFuncao.data('id', aux[0]).dialog("open");
					});
				});
			}
		});
	}
	
	function buscaOutrasFuncoesEmpregado() {
		$.ajax({
			type: 'POST',
			dataType: "json",
			async: false,
			data: {matricula:matricula},
			url: "/application/empregado/buscaoutrasfuncoes",
			success: function(d) {
				$.each(d.outrasFuncoes, function(index, value) {
					var aux = value.split(";");
					tabelaOutrasFuncoes.row.add([aux[1], aux[2], aux[3], "<button id='editarOutraFuncao_"+aux[0]+"'>Editar</button><button id='excluirOutraFuncao_"+aux[0]+"'>Remover</button>"]).draw();
					
					$("#excluirOutraFuncao_"+aux[0]).button({
						icons: {
							primary: "ui-icon-trash",
						},
						text: false
					}).click(function(e) {
						e.preventDefault();
						if(confirm("Deseja realmente excluir?")) {
							var botao = $(this);
							$.ajax({
								type: 'POST',
								data: {id:aux[0]},
								url: "/application/empregado/deleteoutrafuncao",
								success: function() {
									tabelaOutrasFuncoes.row( botao.parents('tr')).remove().draw();
								}
							});
						}
					});
					
					$("#editarOutraFuncao_"+aux[0]).button({
						icons: {
							primary: "ui-icon-pencil",
						},
						text: false
					}).click(function(e) {
						e.preventDefault();
						$("#outraFuncao").val(aux[4]);
						$("#outraFuncao").selectmenu("refresh");
						$("#dataInicialOutraFuncao").val(aux[2].replace(/\-/g, '/'));
						$("#dataFinalOutraFuncao").val(aux[3].replace(/\-/g, '/'));
						dialogOutraFuncao.data('id', aux[0]).dialog("open");
					});
				});
			}
		});
	}
	
	function buscaEquipesTecnicasEmpregado() {
		$.ajax({
			type: 'POST',
			dataType: "json",
			async: false,
			data: {matricula:matricula},
			url: "/application/empregado/buscaequipestecnicas",
			success: function(d) {
				$.each(d.equipesTecnicas, function(index, value) {
					var aux = value.split(";");
					tabelaEquipesTecnicas.row.add([aux[1], aux[2], aux[3], "<button id='editarEquipeTecnica_"+aux[0]+"'>Editar</button><button id='excluirEquipeTecnica_"+aux[0]+"'>Remover</button>"]).draw();
					
					$("#excluirEquipeTecnica_"+aux[0]).button({
						icons: {
							primary: "ui-icon-trash",
						},
						text: false
					}).click(function(e) {
						e.preventDefault();
						if(confirm("Deseja realmente excluir?")) {
							var botao = $(this);
							$.ajax({
								type: 'POST',
								data: {id:aux[0]},
								url: "/application/empregado/deleteequipetecnica",
								success: function() {
									tabelaEquipesTecnicas.row(botao.parents('tr')).remove().draw();
								}
							});
						}
					});
					
					$("#editarEquipeTecnica_"+aux[0]).button({
						icons: {
							primary: "ui-icon-pencil",
						},
						text: false
					}).click(function(e) {
						e.preventDefault();
						$("#equipeTecnica").val(aux[4]);
						$("#equipeTecnica").selectmenu("refresh");
						$("#dataInicialEquipeTecnica").val(aux[2].replace(/\-/g, '/'));
						$("#dataFinalEquipeTecnica").val(aux[3].replace(/\-/g, '/'));
						dialogEquipeTecnica.data('id', aux[0]).dialog("open");
					});
				});
			}
		});
	}
	
	function buscaSublotacoesEmpregado() {
		$.ajax({
			type: 'POST',
			dataType: "json",
			async: false,
			data: {matricula:matricula},
			url: "/application/empregado/buscasublotacoes",
			success: function(d) {
				$.each(d.sublotacoes, function(index, value) {
					var aux = value.split(";");
					tabelaSublotacoes.row.add([aux[1]+" - "+aux[5], aux[2], aux[3], "<button id='editarSublotacao_"+aux[0]+"'>Editar</button><button id='excluirSublotacao_"+aux[0]+"'>Remover</button>"]).draw();
					
					$("#excluirSublotacao_"+aux[0]).button({
						icons: {
							primary: "ui-icon-trash",
						},
						text: false
					}).click(function(e) {
						e.preventDefault();
						if(confirm("Deseja realmente excluir?")) {
							var botao = $(this);
							$.ajax({
								type: 'POST',
								data: {id:aux[0]},
								url: "/application/empregado/deletesublotacao",
								success: function() {
									tabelaSublotacoes.row(botao.parents('tr')).remove().draw();
								}
							});
						}
					});
					
					$("#editarSublotacao_"+aux[0]).button({
						icons: {
							primary: "ui-icon-pencil",
						},
						text: false
					}).click(function(e) {
						e.preventDefault();
						$("#sublotacao").val(aux[4]);
						$("#sublotacao").selectmenu("refresh");
						$("#dataInicialSublotacao").val(aux[2].replace(/\-/g, '/'));
						$("#dataFinalSublotacao").val(aux[3].replace(/\-/g, '/'));
						dialogSublotacao.data('id', aux[0]).dialog("open");
					});
				});
			}
		});
	}
	
	function buscaEscolaridadesEmpregado() {
		$.ajax({
			type: 'POST',
			dataType: "json",
			async: false,
			data: {matricula:matricula},
			url: "/application/empregado/buscaescolaridades",
			success: function(d) {
				$.each(d.escolaridades, function(index, value) {
					var aux = value.split(";");
					tabelaEscolaridades.row.add([aux[1], aux[2], aux[3], aux[4], "<button id='editarEscolaridade_"+aux[0]+"'>Editar</button><button id='excluirEscolaridade_"+aux[0]+"'>Remover</button>"]).draw();
					
					$("#excluirEscolaridade_"+aux[0]).button({
						icons: {
							primary: "ui-icon-trash",
						},
						text: false
					}).click(function(e) {
						e.preventDefault();
						if(confirm("Deseja realmente excluir?")) {
							var botao = $(this);
							$.ajax({
								type: 'POST',
								data: {id:aux[0]},
								url: "/application/empregado/deleteescolaridade",
								success: function() {
									tabelaEscolaridades.row( botao.parents('tr')).remove().draw();
								}
							});
						}
					});					
					$("#editarEscolaridade_"+aux[0]).button({
						icons: {
							primary: "ui-icon-pencil",
						},
						text: false
					}).click(function(e) {
						e.preventDefault();
						$("#escolaridade").val(aux[5]);
						$("#escolaridade").selectmenu("refresh");
						$("#instituicao").val(aux[6]);
						$("#instituicao").selectmenu("refresh");
						$("#curso").val(aux[3]);
						$("#anoConclusaoEscolaridade").val(aux[4]);
						$("#mensagem").fadeOut(0);
						dialogEscolaridade.data('id', aux[0]).dialog("open");
					});
				});
			}
		});
	}
	
	function buscaLotacoesAnterioresEmpregado() {
		$.ajax({
			type: 'POST',
			dataType: "json",
			async: false,
			data: {matricula:matricula},
			url: "/application/empregado/buscalotacoesanteriores",
			success: function(d) {
				$.each(d.lotacoes, function(index, value) {
					var aux = value.split(";");
					tabelaLotacaoAnterior.row.add([aux[1], aux[3], aux[4], "<button id='editarLotacaoAnterior_"+aux[0]+"'>Editar</button><button id='excluirLotacaoAnterior_"+aux[0]+"'>Remover</button>"]).draw();
					
					$("#excluirLotacaoAnterior_"+aux[0]).button({
						icons: {
							primary: "ui-icon-trash",
						},
						text: false
					}).click(function(e) {
						e.preventDefault();
						if(confirm("Deseja realmente excluir?")) {
							var botao = $(this);
							$.ajax({
								type: 'POST',
								data: {id:aux[0]},
								url: "/application/empregado/deletelotacaoanterior",
								success: function() {
									tabelaLotacaoAnterior.row(botao.parents('tr')).remove().draw();
								}
							});
						}
					});
					
					$("#editarLotacaoAnterior_"+aux[0]).button({
						icons: {
							primary: "ui-icon-pencil",
						},
						text: false
					}).click(function(e) {
						e.preventDefault();
						$("#lotacaoAnterior").val(aux[1]);
						$("#lotacaoAnterior").selectmenu("refresh");
						$("#dataInicialLotacaoAnterior").val(aux[3].replace(/\-/g, '/'));
						$("#dataFinalLotacaoAnterior").val(aux[4].replace(/\-/g, '/'));
						dialogLotacaoAnterior.data('id', aux[0]).dialog("open");
					});
				});
			}
		});
	}
	
});