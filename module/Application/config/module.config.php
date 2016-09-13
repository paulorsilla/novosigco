<?php
/**
 * Zend Framework (http://framework.zend.com/)
*
* @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
* @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
* @license   http://framework.zend.com/license/new-bsd New BSD License
*/
namespace Application;

return array(
		
		'router' => array(
				'routes' => array(
						'home' => array(
								'type' => 'Segment',
								'options' => array(
										'route'    => '/[page/:page]',
										'defaults' => array(
												'controller' => 'Application\Controller\Index',
												'action'     => 'index',
												'module'     => 'application',
										),
								),
						),
						'application' => array(
								'type'    => 'Literal',
								'options' => array(
										'route'    => '/application',
										'defaults' => array(
												'controller'    => 'Index',
												'action'        => 'index',
												'__NAMESPACE__' => 'Application\Controller',
												'module'     => 'application'
										),
								),
								'may_terminate' => true,
								'child_routes' => array(
										'default' => array(
												'type'    => 'Segment',
												'options' => array(
														'route'    => '/[:controller[/:action]]',
														'constraints' => array(
																'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
																'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
														),
														'defaults' => array(
														),
												),
												'child_routes' => array( //permite mandar dados pela url
														'wildcard' => array(
																'type' => 'Wildcard'
														),
												),
										),
								),
						),
				),
		),
		'service_manager' => array(
				'factories' => array(
						'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
				),
		),
		'translator' => array(
				'locale' => 'pt_BR',
				'translation_file_patterns' => array(
						array(
								'type'     => 'phparray',
								'base_dir' => __DIR__ . '/../language',
								'pattern'  => '%s.php',
						),
				),
		),
		'controllers' => array(
				'invokables' => array(
		            'Application\Controller\Area'     				 => 'Application\Controller\AreaController',
		            'Application\Controller\Subarea'     	   	 	 => 'Application\Controller\SubareaController',
		            'Application\Controller\Cargo'     				 => 'Application\Controller\CargoController',
					'Application\Controller\Capacitacao'       		 => 'Application\Controller\CapacitacaoController',
					'Application\Controller\CapacitacaoTipo'       	 => 'Application\Controller\CapacitacaoTipoController',
					'Application\Controller\Competencia'             => 'Application\Controller\CompetenciaController',
					'Application\Controller\CompetenciaTipo'         => 'Application\Controller\CompetenciaTipoController',
		            'Application\Controller\EquipeTecnica' 			 => 'Application\Controller\EquipeTecnicaController',
		            'Application\Controller\Escolaridade' 			 => 'Application\Controller\EscolaridadeController',
					'Application\Controller\Instrutor'    		 	 => 'Application\Controller\InstrutorController',
					'Application\Controller\ListaEspera'      		 => 'Application\Controller\ListaEsperaController',
					'Application\Controller\Modalidade'       		 => 'Application\Controller\ModalidadeController',
		            'Application\Controller\Funcao'    				 => 'Application\Controller\FuncaoController',
		            'Application\Controller\OutraFuncao'			 => 'Application\Controller\OutraFuncaoController',
		            'Application\Controller\Sublotacao' 			 => 'Application\Controller\SublotacaoController',
					'Application\Controller\Index'                   => 'Application\Controller\IndexController',
		        	'Application\Controller\Instituicao'             => 'Application\Controller\InstituicaoController',
		        	'Application\Controller\Empregado'               => 'Application\Controller\EmpregadoController',
				),
		),
		'validators' => array(
				'invokables' => array(
						'Application\Validator\Cpf' => 'Application\Validator\Cpf'
				),
		),
		
		'view_manager' => array(
				'display_not_found_reason' => true,
				'display_exceptions'       => true,
				'doctype'                  => 'HTML5',
				'not_found_template'       => 'error/404',
				'exception_template'       => 'error/index',
				'template_map' => array(
						'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
						'error/404'               => __DIR__ . '/../view/error/404.phtml',
						'error/index'             => __DIR__ . '/../view/error/index.phtml',
				),
				'template_path_stack' => array(
						__DIR__ . '/../view',
				),
		),
		'strategies' => array(
				'ViewJsonStrategy',
		),

		'doctrine' => array(
				'driver' => array(
						__NAMESPACE__ .'_driver' => array(
								'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
								'cache' => 'array',
								'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Model')
						),
						'orm_default' => array(
								'drivers' => array(
										__NAMESPACE__.'\Model' => __NAMESPACE__.'_driver'
								)
						),
						'orm_nco' => array(
								'drivers' => array(
										__NAMESPACE__.'\Model' => __NAMESPACE__.'_driver'
								)
						),
						'orm_rh' => array(
								'drivers' => array(
										__NAMESPACE__.'\Model' => __NAMESPACE__.'_driver'
								)
						)
				)
		),
);


