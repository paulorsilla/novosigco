<?php

namespace Admin;

use DoctrineORMModule\Service\EntityManagerFactory;
use DoctrineORMModule\Options\DBALConnection;
use DoctrineORMModule\Service\DBALConnectionFactory;
use DoctrineORMModule\Service\ConfigurationFactory as ORMConfigurationFactory;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

class Module implements ServiceProviderInterface {
	public function getAutoloaderConfig() {
		return array (
				'Zend\Loader\ClassMapAutoloader' => array (
						__DIR__ . '/autoload_classmap.php' 
				),
				'Zend\Loader\StandardAutoloader' => array (
						'namespaces' => array (
								__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__ 
						) 
				) 
		);
	}
	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}
	
	/**
	 * Retorna a configuração do service manager do módulo
	 * 
	 * @return array
	 */
	public function getServiceConfig() {
		return array(
			'factories' => array(
// 				'doctrine.entitymanager.orm_default'	=> new EntityManagerFactory('orm_default'),
// 				'doctrine.connection.orm_default'		=> new DBALConnectionFactory('orm_default'),
// 				'doctrine.configuration.orm_default'	=> new ORMConfigurationFactory('orm_default'),
			),
		);
	}
	
	/**
	 * Executada no bootstrap do módulo
	 *
	 * @param MvcEvent $e        	
	 */
	public function onBootstrap(MvcEvent $e) {
		
		/**
		 * @var \Zend\ModuleManager\ModuleManager $moduleManager
		 */
		$moduleManager = $e->getApplication ()->getServiceManager ()->get ( 'modulemanager' );
		/**
		 * @var \Zend\EventManager\SharedEventManager $sharedEvents
		 */
		$sharedEvents = $moduleManager->getEventManager ()->getSharedManager ();
		
	//	adiciona eventos ao módulo
		$sharedEvents->attach ( 'Zend\Mvc\Controller\AbstractActionController', \Zend\Mvc\MvcEvent::EVENT_DISPATCH, array (
				$this,
				'mvcPreDispatch' 
		), 100 );

		
	}
	
	/**
	 * Verifica se precisa fazer a autorização do acesso
	 * 
	 * @param MvcEvent $event
	 *        	Evento
	 * @return boolean
	 */
	public function mvcPreDispatch($event) {
		$di = $event->getTarget ()->getServiceLocator ();
		$routeMatch = $event->getRouteMatch ();
		$moduleName = $routeMatch->getParam ( 'module' );
		$controllerName = $routeMatch->getParam ( 'controller' );
		$actionName = $routeMatch->getParam ( 'action' );
		
		$authService = $di->get ( 'Admin\Service\Auth' );
		if (! $authService->authorize ( $moduleName, $controllerName, $actionName )) {
			throw new \Exception ( 'Você não tem permissão para acessar este recurso.' );
		}
		return true;
	}
}
//Commit