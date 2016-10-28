<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\Turma;
use Application\Form\Turma as TurmaForm;
use Doctrine\ORM\EntityManager;
use Application\Model\TurmaProgramacao;

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
		error_log("1");
		$form->setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods(false));
		if ($request->isPost ()) {
			error_log("2");
			$turma = new Turma ();
			$form->setInputFilter ( $turma->getInputFilter () );
			$form->setData ( $request->getPost () );
			error_log("3");
			if ($form->isValid ()) {
				$data = $form->getData ();
				$horaInicial = $this->params()->fromPost('horaInicial');
				foreach($horaInicial as $i =>$hI){
					error_log($hI);
					error_log($horaInicial[$i]);
				}
				error_log("4");
				// inicial = data inicial, final = data final
//				$dataInicial = new \DateTime($this->params()->fromPost("dataInicial"));
				error_log("5");
//				$dataFinal = new \DateTime($this->params()->fromPost("dataFinal"));
				error_log("6");
				$matriculas = $this->params ()->fromPost ( "matricula" );
				unset($data["matricula"]);
				error_log("7");
				unset ($data["dataInicial"]);
				error_log("8");
				unset ($data["dataFinal"]);
				error_log("9");
				unset ( $data ['submit'] );
				if (isset ( $data ['id'] ) && $data ['id'] > 0) {
					error_log("10");
					$turma = $this->getEntityManager ()->find ( 'Application\Model\Turma', $data ['id'] );
					$turma = getMatricula()->clear();
				}
				error_log(11);
				foreach ( $matriculas as $matricula ) {
					error_log("12");
					$empregado = $this->getEntityManager ()->find ( "Application\Model\Empregado", $matricula );
					$turma->getMatricula ()->add ( $empregado);
				}
				$turma->setMatricula($matricula);
				error_log("13");
//				$turma->setInicial($dataInicial);
				error_log("14");
//				$turma->setFinal($dataFinal);
				error_log("15");
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
		$renderer->headScript ()->appendFile ( '/js/jquery.mask.js' );
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