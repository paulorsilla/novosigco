<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\Turma;
use Application\Form\Turma as TurmaForm;
use Doctrine\ORM\EntityManager;

/**
 * Controlador que gerencia o cadastro de Turmas
 *
 * @category Application
 * @package Controller
 * @author Paulo R. Silla <paulo.silla@embrapa.br>
 * @author William Gerenutti <william.alves@colaborador.embrapa.br>
 */
class TurmaController extends ActionController {
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
	 * Mostra as turmas cadastradas
	 *
	 * @return void
	 */
	public function indexAction() {
		$turmas = $this->getEntityManager ()->getRepository ( "Application\Model\Turma" )->findAll ( array (), array (
				'inicial' => 'ASC'
		) );

		// adiciona os arquivos indexcomum.js e jquery.dataTable.min.js
		// ao head da página
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/indexcomum.js' );
		return new ViewModel ( array (
				'turmas' => $turmas
		) );
	}
	public function saveAction() {
		$form = new TurmaForm ( $this->getEntityManager () );
		$empregados = array();
		$request = $this->getRequest ();
		//Hidratar classe
		$form->setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods(false));
		if ($request->isPost ()) {
			$turma = new Turma ();
			$form->setInputFilter ( $turma->getInputFilter () );
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$data = $form->getData ();
				$matriculas = $this->params ()->fromPost ( "matricula" );
				unset ( $data ['submit'] );
				if (isset ( $data ['id'] ) && $data ['id'] > 0) {
					$turma = $this->getEntityManager ()->find ( 'Application\Model\Turma', $data ['id'] );
					$turma = getMatricula()->clear();
				}
				foreach ( $matriculas as $matricula ) {
					$empregado = $this->getEntityManager ()->find ( "Application\Model\Empregado", $matricula );
					$turma->getMatricula ()->add ( $empregado);
				}
				$turma->setData ( $data );
				$this->getEntityManager ()->persist ( $turma );
				$this->getEntityManager ()->flush ();
				return $this->redirect ()->toUrl ( '/application/turma' );
			}
		}
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id > 0) {
			$turma = $this->getEntityManager ()->find ( 'Application\Model\Turma', $id );
			$form->bind ( $turma );
			$empregados = $turma->getMatricula();
		}
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/turma.js' );
		return new ViewModel ( array (
				'form' => $form,
				'empregados' => $empregados
		) );
	}
	/**
	 * Exclui uma Turma
	 *
	 * @return void
	 */
	public function deleteAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			throw new \ErrorException ( "Código obrigatório" );
		}
		$turma = $this->getEntityManager ()->find ( 'Application\Model\Turma', $id );
		if ($turma) {
			$this->getEntityManager ()->remove ( $turma );
			$this->getEntityManager ()->flush ();
		}
		return $this->redirect ()->toUrl ( '/application/turma' );
	}
}