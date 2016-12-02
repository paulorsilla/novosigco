<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application\Controller;

use Core\Controller\ActionController;

class IndexController extends ActionController {
	/**
	 *
	 * @return void
	 */
	public function indexAction() {
		$session = $this->getServiceLocator ()->get ( 'Zend\ServiceManager\ServiceManager' )->get ( 'Session' );
		$usuario = $session->offsetGet ( 'user' );
		if (! isset ( $usuario )) {
			return $this->redirect ()->toUrl ( '/admin/auth/index' );
		}
		return;
	}
}
