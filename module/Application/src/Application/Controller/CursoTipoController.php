<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\CursoTipo;
use Application\Form\CursoTipo as CursoTipoForm;
use Doctrine\ORM\EntityManager;

/**
 * Controlador que gerencia o cadastro de tipos de cursos
 *
 * @category Application
 * @package Controller
 * @author Paulo R. Silla <paulo.silla@embrapa.br>
 * @author William Gerenutti <william.alves@colaborador.embrapa.br>
 */
class CursoTipoController extends ActionController {
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
		$cursosTipo = $this->getEntityManager ()->getRepository ( "Application\Model\CursoTipo" )->findAll ( array (), array (
				'descricao' => 'ASC' 
		) );
		// adiciona os arquivos indexcomum.js e jquery.dataTable.min.js
		// ao head da página
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/indexcomum.js' );
		return new ViewModel ( array (
				'cursosTipo' => $cursosTipo 
		) );
	}
	public function saveAction() {
		$form = new CursoTipoForm ();
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$cursoTipo = new CursoTipo ();
			$form->setInputFilter ( $cursoTipo->getInputFilter () );
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$data = $form->getData ();
				unset ( $data ['submit'] );
				if (isset ( $data ['id'] ) && $data ['id'] > 0) {
					$cursoTipo = $this->getEntityManager ()->find ( 'Application\Model\CursoTipo', $data ['id'] );
				}
				$cursoTipo->setData ( $data );
				$this->getEntityManager ()->persist ( $cursoTipo );
				$this->getEntityManager ()->flush ();
				
				return $this->redirect ()->toUrl ( '/application/curso-tipo' );
			}
		}
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id > 0) {
			$cursoTipo = $this->getEntityManager ()->find ( 'Application\Model\CursoTipo', $id );
			$form->bind ( $cursoTipo );
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
		$cursoTipo = $this->getEntityManager ()->find ( 'Application\Model\CursoTipo', $id );
		if ($curso) {
			$this->getEntityManager ()->remove ( $cursoTipo );
			$this->getEntityManager ()->flush ();
		}
		return $this->redirect ()->toUrl ( '/application/curso-tipo' );
	}
}