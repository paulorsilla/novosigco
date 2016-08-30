<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\CompetenciaTipo;
use Application\Form\CompetenciaTipo as CompetenciaTipoForm;
use Doctrine\ORM\EntityManager;

/**
 * Controlador que gerencia o cadastro de tipo de competencias
 *
 * @category Application
 * @package Controller
 * @author Paulo R. Silla <paulo.silla@embrapa.br>
 * @author William Gerenutti <william.alves@colaborador.embrapa.br>
 */
class CompetenciaTipoController extends ActionController {
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
	 * Mostra os Tipos de Competencias cadastradas
	 *
	 * @return void
	 */
	public function indexAction() {
		$competenciasTipo = $this->getEntityManager ()->getRepository ( "Application\Model\CompetenciaTipo" )->findAll ( array (), array (
				'titulo' => 'ASC'
		) );

		// adiciona os arquivos indexcomum.js e jquery.dataTable.min.js
		// ao head da página
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/indexcomum.js' );
		return new ViewModel ( array (
				'competenciasTipo' => $competenciasTipo
		) );
	}
	
	public function saveAction() {
		$form = new CompetenciaTipoForm ();
		$request = $this->getRequest ();
		//Hidratar classe
		$form->setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods(false));
		if ($request->isPost ()) {
			$competenciaTipo = new CompetenciaTipo ();
			$form->setInputFilter ( $competenciaTipo->getInputFilter () );
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$data = $form->getData ();
				unset ( $data ['submit'] );
				if (isset ( $data ['id'] ) && $data ['id'] > 0) {
					$competenciaTipo = $this->getEntityManager ()->find ( 'Application\Model\CompetenciaTipo', $data ['id'] );
				}
				$competenciaTIpo->setData ( $data );
				$this->getEntityManager ()->persist ( $competenciaTipo );
				$this->getEntityManager ()->flush ();
				return $this->redirect ()->toUrl ( '/application/competencia-tipo' );
			}
		}
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id > 0) {
			$competenciaTipo = $this->getEntityManager ()->find ( 'Application\Model\CompetenciaTipo', $id );
			$form->bind ( $competenciaTipo );
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
		$competenciaTipo = $this->getEntityManager ()->find ( 'Application\Model\CompetenciaTipo', $id );
		if ($competenciaTipo) {
			$this->getEntityManager ()->remove ( $competenciaTipo );
			$this->getEntityManager ()->flush ();
		}
		return $this->redirect ()->toUrl ( '/application/competencia-tipo' );
	}
}