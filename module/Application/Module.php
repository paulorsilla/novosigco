<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use DoctrineORMModule\Service\EntityManagerFactory;
use DoctrineORMModule\Service\DBALConnectionFactory;
use DoctrineORMModule\Service\ConfigurationFactory as ORMConfigurationFactory;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements ServiceProviderInterface
{
    public function onBootstrap($e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        date_default_timezone_set('UTC');
    }

    public function getConfig()
    {
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
 				'doctrine.entitymanager.orm_nco'	=> new EntityManagerFactory('orm_nco'),
 				'doctrine.connection.orm_nco'		=> new DBALConnectionFactory('orm_nco'),
 				'doctrine.configuration.orm_nco'	=> new ORMConfigurationFactory('orm_nco'),
				'doctrine.entitymanager.orm_rh'		=> new EntityManagerFactory('orm_rh'),
   				'doctrine.connection.orm_rh'		=> new DBALConnectionFactory('orm_rh'),
   				'doctrine.configuration.orm_rh'		=> new ORMConfigurationFactory('orm_rh'),
   			),
    	);
    }
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
