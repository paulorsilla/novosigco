<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\CapacitacaoTipo;
use Application\Form\CapacitacaoTipo as CapacitacaoTipoForm;
use Doctrine\ORM\EntityManager;

/**
 * Controlador que gerencia o cadastro de tipos de capacitações
 *
 * @category Application
 * @package Controller
 * @author Paulo R. Silla <paulo.silla@embrapa.br>
 * @author William Gerenutti <william.alves@colaborador.embrapa.br>
 */
class CapacitacaoTipoController extends ActionController {
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
	public function indexAction() {
		$capacitacoesTipo = $this->getEntityManager ()->getRepository ( "Application\Model\CapacitacaoTipo" )->findAll ( array (), array (
				'descricao' => 'ASC' 
		) );
		// adiciona os arquivos indexcomum.js e jquery.dataTable.min.js
		// ao head da página
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/indexcomum.js' );
		return new ViewModel ( array (
				'capacitacoesTipo' => $capacitacoesTipo 
		) );
	}
	public function saveAction() {
		$form = new CapacitacaoTipoForm ();
		//Hidratação para verificar o nome das classes
		$form->setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods(false));
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$capacitacaoTipo = new CapacitacaoTipo ();
			$form->setInputFilter ( $capacitacaoTipo->getInputFilter () );
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$data = $form->getData ();
				unset ( $data ['submit'] );
				if (isset ( $data ['id'] ) && $data ['id'] > 0) {
					$capacitacaoTipo = $this->getEntityManager ()->find ( 'Application\Model\CapacitacaoTipo', $data ['id'] );
				}
				$capacitacaoTipo->setData ( $data );
				$this->getEntityManager ()->persist ( $capacitacaoTipo );
				$this->getEntityManager ()->flush ();
				return $this->redirect ()->toUrl ( '/application/capacitacao-tipo' );
			}
		}
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id > 0) {
			$capacitacaoTipo = $this->getEntityManager ()->find ( 'Application\Model\CapacitacaoTipo', $id );
			$form->bind ( $capacitacaoTipo );
			$form->get ( 'submit' )->setAttribute ( 'value', 'Edit' );
		}
		return new ViewModel ( array (
				'form' => $form 
		) );
	}
	public function deleteAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			throw new \exception ( "Código obrigatório" );
		}
		$capacitacaoTipo = $this->getEntityManager ()->find ( 'Application\Model\CapacitacaoTipo', $id );
		if ($capacitacaoTipo) {
			$this->getEntityManager ()->remove ( $capacitacaoTipo );
			$this->getEntityManager ()->flush ();
		}
		return $this->redirect ()->toUrl ( '/application/capacitacao-tipo' );
	}
}