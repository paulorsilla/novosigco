<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\Modalidade;
use Application\Form\Modalidade as ModalidadeForm;
use Doctrine\ORM\EntityManager;

/**
 * Controlador que gerencia o cadastro de modalidades
 *
 * @category Application
 * @package Controller
 * @author Paulo R. Silla <paulo.silla@embrapa.br>
 * @author William Gerenutti <william.alves@colaborador.embrapa.br>
 */
class ModalidadeController extends ActionController {
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
	 * Mostra os Tipos de modalidades cadastradas
	 *
	 * @return void
	 */
	public function indexAction() {
		$modalidade = $this->getEntityManager ()->getRepository ( "Application\Model\Modalidade" )->findAll ( array (), array (
				'titulo' => 'ASC'
		) );

		// adiciona os arquivos indexcomum.js e jquery.dataTable.min.js
		// ao head da página
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/indexcomum.js' );
		return new ViewModel ( array (
				'modalidades' => $modalidade
		) );
	}
	
	public function saveAction() {
		$form = new ModalidadeForm ();
		$request = $this->getRequest ();
		//Hidratar classe
		$form->setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods(false));
		if ($request->isPost ()) {
			$modalidade = new Modalidade ();
			$form->setInputFilter ( $modalidade->getInputFilter () );
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$data = $form->getData ();
				unset ( $data ['submit'] );
				if (isset ( $data ['id'] ) && $data ['id'] > 0) {
					$modalidade = $this->getEntityManager ()->find ( 'Application\Model\Modalidade', $data ['id'] );
				}
				$modalidade->setData ( $data );
				$this->getEntityManager ()->persist ( $modalidade );
				$this->getEntityManager ()->flush ();
				return $this->redirect ()->toUrl ( '/application/modalidade' );
			}
		}
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id > 0) {
			$modalidade = $this->getEntityManager ()->find ( 'Application\Model\Modalidade', $id );
			$form->bind ( $modalidade);
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
		$modalidade = $this->getEntityManager ()->find ( 'Application\Model\Modalidade', $id );
		if ($modalidade) {
			$this->getEntityManager ()->remove ( $modalidade );
			$this->getEntityManager ()->flush ();
		}
		return $this->redirect ()->toUrl ( '/application/modalidade' );
	}
}