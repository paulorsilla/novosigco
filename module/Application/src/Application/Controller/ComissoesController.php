<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\Comissoes;
use Application\Form\Comissoes as ComissoesForm;
use Doctrine\ORM\EntityManager;

/**
 * Controlador que gerencia o cadastro de Comissoes
 *
 * @category Application
 * @package Controller
 * @author Paulo R. Silla <paulo.silla@embrapa.br>
 * @author William Gerenutti <william.alves@colaborador.embrapa.br>
 */
class ComissoesController extends ActionController {
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
	 * Mostra as comissoes cadastrados
	 *
	 * @return void
	 */
	public function indexAction() {
		$comissoes = $this->getEntityManager ()->getRepository ( "Application\Model\Comissoes" )->findAll ( array (), array (
				'numeroOs' => 'ASC' 
		) );
		
		// adiciona os arquivos indexcomum.js e jquery.dataTable.min.js
		// ao head da página
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/indexcomum.js' );
		return new ViewModel ( array (
				'comissoes' => $comissoes 
		) );
	}
	public function saveAction() {
		$form = new ComissoesForm ( $this->getEntityManager () );
		// Hidratação para verificar o nome das classes
		$form->setHydrator ( new \Zend\Stdlib\Hydrator\ClassMethods ( false ) );
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$comissoes = new Comissoes ();
			$form->setInputFilter ( $comissoes->getInputFilter () );
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$data = $form->getData ();
				$ano = new \DateTime($this->params()->fromPost("ano"));
				unset ($data["ano"]);
				unset ($data["submit"]);
				if (isset ( $data ['id'] ) && $data ['id'] > 0) {
					$comissoes = $this->getEntityManager ()->find ( 'Application\Model\Comissoes', $data ['id'] );
				}
				$comissoes->setData ( $data );
				$comissoes->setAno($ano);	
				$this->getEntityManager ()->persist ( $comissoes );
				$this->getEntityManager ()->flush ();
				return $this->redirect ()->toUrl ( '/application/comissoes' );
			}
		}
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id > 0) {
			$comissoes = $this->getEntityManager ()->find ( 'Application\Model\Comissoes', $id );
			$form->bind ( $comissoes );
			$form->get('ano') ->setAttribute( 'value', $comissoes->getAno());
			$form->get ( 'submit' )->setAttribute ( 'value', 'Edit' );
		}
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/jquery.mask.js' );
		return new ViewModel ( array (
				'form' => $form 
		) );
	}
	public function deleteAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			throw new \ErrorException ( "Código obrigatório" );
		}
		$comissoes = $this->getEntityManager ()->find ( 'Application\Model\Comissoes', $id );
		if ($comissoes) {
			$this->getEntityManager ()->remove ( $comissoes );
			$this->getEntityManager ()->flush ();
		}
		return $this->redirect ()->toUrl ( '/application/comissoes' );
	}
}