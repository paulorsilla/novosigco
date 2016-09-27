<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
return array (
 		'configuration' => array(

 			'orm_nco'				=> array(
	 			'metadata_cache' 	=> 'array',
	 			'query_cache'		=> 'array',
	 			'result_cache'		=> 'array',
	 			'driver'			=> 'orm_nco',
	 			'generate_proxies'	=> 'true',
	 			'proxy_dir'			=> 'data/DoctrineORMModule/Proxy',
	 			'proxy_namespace'	=> 'EntityProxy',
	 			'filters'			=> array()
 			),
 				
 			'orm_rh'				=> array(
				'metadata_cache' 	=> 'array',
				'query_cache'		=> 'array',
				'result_cache'		=> 'array',
				'driver'			=> 'orm_rh',
				'generate_proxies'	=> 'true',
				'proxy_dir'			=> 'data/DoctrineORMModule/Proxy',
 				'proxy_namespace'	=> 'EntityProxy',
 				'filters'			=> array()
 			),
 		),
		
		'acl' => array (
				'roles' => array (
						'comum' => null,
						'admin' => 'comum' 
				),
				'resources' => array (
						'Admin\Controller\Auth.index',
						'Admin\Controller\Auth.login',
						'Admin\Controller\Auth.logout',
						'Admin\Controller\Index.save',
						'Admin\Controller\Index.delete',
						'Admin\Controller\Usuario.index',
						'Admin\Controller\Usuario.save',
						'Admin\Controller\Usuario.delete',
						'Application\Controller\Area.index',
						'Application\Controller\Area.save',
						'Application\Controller\Area.delete',
						'Application\Controller\Area.buscaareas',
						'Application\Controller\Subarea.index',
						'Application\Controller\Subarea.save',
						'Application\Controller\Subarea.delete',
						'Application\Controller\Subarea.buscasubareas',
						'Application\Controller\EquipeTecnica.index',
						'Application\Controller\EquipeTecnica.save',
						'Application\Controller\EquipeTecnica.delete',
						'Application\Controller\EquipeTecnica.buscaequipestecnicas',
						'Application\Controller\Escolaridade.index',
						'Application\Controller\Escolaridade.save',
						'Application\Controller\Escolaridade.delete',
						'Application\Controller\Escolaridade.buscaescolaridades',
						'Application\Controller\Instrutor.index',
						'Application\Controller\Instrutor.save',
						'Application\Controller\Instrutor.delete',
						'Application\Controller\Funcao.index',
						'Application\Controller\Funcao.save',
						'Application\Controller\Funcao.delete',
						'Application\Controller\Funcao.buscafuncoes',
						'Application\Controller\OutraFuncao.index',
						'Application\Controller\OutraFuncao.save',
						'Application\Controller\OutraFuncao.delete',
						'Application\Controller\OutraFuncao.buscaoutrasfuncoes',
						'Application\Controller\Sublotacao.index',
						'Application\Controller\Sublotacao.save',
						'Application\Controller\Sublotacao.delete',
						'Application\Controller\Sublotacao.buscasublotacoes',
						'Application\Controller\Cargo.index',
						'Application\Controller\Cargo.save',
						'Application\Controller\Cargo.delete',
						'Application\Controller\Cargo.buscacargos',
						'Application\Controller\Competencia.index',
						'Application\Controller\Competencia.save',
						'Application\Controller\Competencia.delete',
						'Application\Controller\Competencia.buscacompetencia',
						'Application\Controller\Modalidade.index',
						'Application\Controller\Modalidade.save',
						'Application\Controller\Modalidade.delete',
						'Application\Controller\Capacitacao.index',
						'Application\Controller\Capacitacao.save',
						'Application\Controller\Capacitacao.delete',
						'Application\Controller\CapacitacaoTipo.index',
						'Application\Controller\CapacitacaoTipo.save',
						'Application\Controller\CapacitacaoTipo.delete',
						'Application\Controller\Capacitacao.buscacompetencias',
						'Application\Controller\Empregado.buscaempregado',
						'Application\Controller\Empregado.save',
						'Application\Controller\Empregado.index',
						'Application\Controller\Empregado.addareasubarea',
						'Application\Controller\Empregado.addcargo',
						'Application\Controller\Empregado.addfuncao',
						'Application\Controller\Empregado.addoutrafuncao',
						'Application\Controller\Empregado.addequipetecnica',
						'Application\Controller\Empregado.addsublotacao',
						'Application\Controller\Empregado.addescolaridade',
						'Application\Controller\Empregado.addlotacaoanterior',
						'Application\Controller\Empregado.deletecargo',
						'Application\Controller\Empregado.deletearea',
						'Application\Controller\Empregado.deletefuncao',
						'Application\Controller\Empregado.deleteoutrafuncao',
						'Application\Controller\Empregado.deleteequipetecnica',
						'Application\Controller\Empregado.deletesublotacao',
						'Application\Controller\Empregado.deleteescolaridade',
						'Application\Controller\Empregado.deletelotacaoanterior',
						'Application\Controller\Empregado.buscacargos',
						'Application\Controller\Empregado.buscaareas',
						'Application\Controller\Empregado.buscafuncoes',
						'Application\Controller\Empregado.buscaoutrasfuncoes',
						'Application\Controller\Empregado.buscaequipestecnicas',
						'Application\Controller\Empregado.buscasublotacoes',
						'Application\Controller\Empregado.buscaescolaridades',
						'Application\Controller\Empregado.buscaempregados',
						'Application\Controller\Empregado.buscalotacoesanteriores',
						'Application\Controller\ModalidadeLicitacao.index',
						'Application\Controller\ModalidadeLicitacao.save',
						'Application\Controller\ModalidadeLicitacao.delete',
						'Application\Controller\ModalidadeLicitacao.buscamodalidades',
						'Application\Controller\Index.index',
						'Application\Controller\Instituicao.index', 
						'Application\Controller\Instituicao.save', 
						'Application\Controller\Instituicao.buscaempregados', 
						'Application\Controller\Instituicao.buscadados', 
						'Application\Controller\Instituicao.buscainstituicoes',
						'Application\Controller\Instituicao.buscainstituicaoprincipal',
						'Application\Controller\ListaEspera.index',
						'Application\Controller\ListaEspera.save',
						'Application\Controller\ListaEspera.delete',
						'Application\Controller\Turma.index',
						'Application\Controller\Turma.save',
						'Application\Controller\Turma.delete',
				),
				'privilege' => array (
						'comum' => array (
								'allow' => array (
										'Admin\Controller\Auth.index',
										'Admin\Controller\Auth.login',
										'Admin\Controller\Auth.logout',
										'Application\Controller\Area.index',
										'Application\Controller\Area.save',
										'Application\Controller\Area.delete',
										'Application\Controller\Area.buscaareas',
										'Application\Controller\Subarea.index',
										'Application\Controller\Subarea.save',
										'Application\Controller\Subarea.delete',
										'Application\Controller\Subarea.buscasubareas',
										'Application\Controller\EquipeTecnica.index',
										'Application\Controller\EquipeTecnica.save',
										'Application\Controller\EquipeTecnica.delete',
										'Application\Controller\EquipeTecnica.buscaequipestecnicas',
										'Application\Controller\Escolaridade.index',
										'Application\Controller\Escolaridade.save',
										'Application\Controller\Escolaridade.delete',
										'Application\Controller\Escolaridade.buscaescolaridades',
										'Application\Controller\Funcao.index',
										'Application\Controller\Funcao.save',
										'Application\Controller\Funcao.delete',
										'Application\Controller\Funcao.buscafuncoes',
										'Application\Controller\OutraFuncao.index',
										'Application\Controller\OutraFuncao.save',
										'Application\Controller\OutraFuncao.delete',
										'Application\Controller\OutraFuncao.buscaoutrasfuncoes',
										'Application\Controller\Sublotacao.index',
										'Application\Controller\Sublotacao.save',
										'Application\Controller\Sublotacao.delete',
										'Application\Controller\Sublotacao.buscasublotacoes',
										'Application\Controller\Cargo.buscacargos',
										'Application\Controller\Empregado.save',
										'Application\Controller\Empregado.index',
										'Application\Controller\Empregado.buscaempregados',
										'Application\Controller\Empregado.buscaempregado',
										'Application\Controller\Empregado.buscacargos',
										'Application\Controller\Empregado.buscaareas',
										'Application\Controller\Empregado.buscafuncoes',
										'Application\Controller\Empregado.buscaoutrasfuncoes',
										'Application\Controller\Empregado.buscaequipestecnicas',
										'Application\Controller\Empregado.buscasublotacoes',
										'Application\Controller\Empregado.buscaescolaridades',
										'Application\Controller\Empregado.buscalotacoesanteriores',
										'Application\Controller\Index.index', 
										'Application\Controller\Instituicao.index', 
										'Application\Controller\Instituicao.buscaempregados', 
										'Application\Controller\Instituicao.buscadados', 
										'Application\Controller\Instituicao.buscainstituicoes',
										'Application\Controller\Instituicao.buscainstituicaoprincipal',
										'Application\Controller\Instituicao.buscainstituicaoprincipal',
										'Application\Controller\Instituicao.save',
										'Application\Controller\Empregado.deletelotacaoanterior',
								) 
						),
						'admin' => array (
								'allow' => array (
										'Admin\Controller\Index.save',
										'Admin\Controller\Index.delete',
										'Admin\Controller\Usuario.index',
										'Admin\Controller\Usuario.save',
										'Admin\Controller\Usuario.delete',
										'Application\Controller\Cargo.index',
										'Application\Controller\Cargo.save',
										'Application\Controller\Cargo.delete',
										'Application\Controller\Competencia.index',
										'Application\Controller\Competencia.save',
										'Application\Controller\Competencia.delete',
										'Application\Controller\Competencia.buscacompetencia',
										'Application\Controller\Modalidade.index',
										'Application\Controller\Modalidade.save',
										'Application\Controller\Modalidade.delete',
										'Application\Controller\Capacitacao.buscacompetencias',
										'Application\Controller\Capacitacao.index',
										'Application\Controller\Capacitacao.save',
										'Application\Controller\Capacitacao.delete',
										'Application\Controller\CapacitacaoTipo.index',
										'Application\Controller\CapacitacaoTipo.save',
										'Application\Controller\CapacitacaoTipo.delete',
										'Application\Controller\Instituicao.save',
										'Application\Controller\Empregado.addareasubarea',
										'Application\Controller\Empregado.addcargo',
										'Application\Controller\Empregado.addfuncao',
										'Application\Controller\Empregado.addoutrafuncao',
										'Application\Controller\Empregado.addequipetecnica',
										'Application\Controller\Empregado.addsublotacao',
										'Application\Controller\Empregado.addescolaridade',
										'Application\Controller\Empregado.deletecargo',
										'Application\Controller\Empregado.deletearea',
										'Application\Controller\Empregado.deletefuncao',
										'Application\Controller\Empregado.deleteoutrafuncao',
										'Application\Controller\Empregado.deleteequipetecnica',
										'Application\Controller\Empregado.deletesublotacao',
										'Application\Controller\Empregado.deleteescolaridade',
										'Application\Controller\Empregado.addlotacaoanterior',
										'Application\Controller\Empregado.deletelotacaoanterior',
										'Application\Controller\Instrutor.index',
										'Application\Controller\Instrutor.save',
										'Application\Controller\Instrutor.delete',
										'Application\Controller\ListaEspera.index',
										'Application\Controller\ListaEspera.save',
										'Application\Controller\ListaEspera.delete',
										'Application\Controller\Turma.index',
										'Application\Controller\Turma.save',
										'Application\Controller\Turma.delete',
								) 
						) 
				) 
		) 
);
