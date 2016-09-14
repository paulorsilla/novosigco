<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\ListaEspera;
use Application\Form\ListaEspera as ListaEsperaForm;
use Doctrine\ORM\EntityManager;

/**
 * Controlador que gerencia o cadastro de lista de espera
 *
 * @category Application
 * @package Controller
 * @author Paulo R. Silla <paulo.silla@embrapa.br>
 * @author William Gerenutti <william.alves@colaborador.embrapa.br>
 */
class ListaEsperaController extends ActionController {
	/**
	 *
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $em;
	public function setEntityManager(EntityManager $em) {
		$this->em = $em;
	}
	public function getEntityManager() {
		if (null === $this->em) {
			$this->em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
		}
		return $this->em;
	}

	/**
	 * Mostram listas cadastradas
	 *
	 * @return void
	 */
	public function indexAction() {
		$espera = $this->getEntityManager ()->getRepository ( "Application\Model\ListaEspera" )->findAll ( array (), array (
				'capacitacao' => 'ASC'
		) );
	
		// adiciona os arquivos indexcomum.js e jquery.dataTable.min.js
		// ao head da página
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/indexcomum.js' );
		return new ViewModel ( array (
				'esperas' => $espera
		) );
	}

	public function saveAction() {
		$form = new ListaEsperaForm ($this->getEntityManager ());
		$request = $this->getRequest ();
		//Hidratar classe
		$form->setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods(false));
		if ($request->isPost ()) {
			$espera = new ListaEspera();
			//unset em capacitação.
			$form->setInputFilter ( $espera->getInputFilter () );
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$data = $form->getData ();
				$capacitacao = $this->getEntityManager ()->find ( 'Application\Model\Capacitacao', $data ['capacitacao'] );
				unset ( $data ['capacitacao'] );
				unset ( $data ['submit'] );
				if (isset ( $data ['id'] ) && $data ['id'] > 0) {
					$espera = $this->getEntityManager ()->find ( 'Application\Model\ListaEspera', $data ['id'] );
				}
				$espera->setData ( $data );
				$espera->setCapacitacao ( $capacitacao);
				$this->getEntityManager ()->persist ( $espera );
				$this->getEntityManager ()->flush ();
				return $this->redirect ()->toUrl ( '/application/lista-espera' );
			}
		}
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id > 0) {
			$espera = $this->getEntityManager ()->find ( 'Application\Model\ListaEspera', $id );
			$form->bind ( $espera);
			$form->get ( 'submit' )->setAttribute ( 'value', 'Edit' );
		}
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/listaEspera.js' );
		return new ViewModel ( array (
				'form' => $form
		) );
	}
	public function deleteAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			throw new \exception ( "Código obrigatório" );
		}
		$espera = $this->getEntityManager ()->find ( 'Application\Model\ListaEspera', $id );
		if ($espera) {
			$this->getEntityManager ()->remove ( $espera );
			$this->getEntityManager ()->flush ();
		}
		return $this->redirect ()->toUrl ( '/application/lista-espera' );
	}

}