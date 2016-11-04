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
		$request = $this->getRequest ();
		// Hidratar classe
		$turma = new Turma ();
		$form->setHydrator ( new \Zend\Stdlib\Hydrator\ClassMethods ( false ) );
		if ($request->isPost ()) {
			$form->setInputFilter ( $turma->getInputFilter () );
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$data = $form->getData ();
				$dataRealizacao = $this->params ()->fromPost ( 'dataRealizacao' );
				$horaInicial = $this->params ()->fromPost ( 'horaInicial' );
				$horaFinal = $this->params ()->fromPost ( 'horaFinal' );
				$local = $this->params ()->fromPost ( 'local' );
				$capacitacaoId = $this->params ()->fromPost ( 'capacitacao' );
				$capacitacao = $this->getEntityManager ()->find ( 'Application\Model\Capacitacao', $capacitacaoId );
				$codigo = $this->params ()->fromPost ( 'instituicao' );
				$instituicao = $this->getEntityManager ()->find ( 'Application\Model\Instituicao', $codigo );
				$coordenacaoId = $this->params ()->fromPost ( 'coordenacao' );
				$coordenacao = $this->getEntityManager ()->find ( 'Application\Model\Empregado', $coordenacaoId ); 	
				$instrutor = $this->getEntityManager ()->find ( 'Application\Model\Instrutor', $data ['id'] );
				foreach ( $horaInicial as $i => $hI ) {
					$programacao = new TurmaProgramacao ();
					$programacao->setHoraInicial ( $hI );
					$programacao->setHoraFinal ( $horaFinal [$i] );
					$programacao->setLocal ( $local [$i] );
					$realizacao = new \DateTime ( $dataRealizacao [$i] );
					$programacao->setDataRealizacao ( $realizacao );
					$this->getEntityManager ()->persist ( $programacao );
					$this->getEntityManager ()->flush ();
					$turma->getProgramacao ()->add ( $programacao );
				}
				$participantes = $this->params ()->fromPost ( "matricula" );
				foreach ( $participantes as $participanteId ) {
					$participante = $this->getEntityManager ()->find ( "Application\Model\Empregado", $participanteId );
					$turma->getParticipantes ()->add ( $participante );
				}
				unset ( $data ["matricula"] );
				unset ( $data ["coordenacao"] );
				unset ( $data ["dataInicial"] );
				unset ( $data ["instrutor"] );
				unset ( $data ["dataFinal"] );
				unset ( $data ["capacitacao"] );
				unset ( $data ["instituicao"] );
				unset ( $data ['submit'] );
				if (isset ( $data ['id'] ) && $data ['id'] > 0) {
					$turma = $this->getEntityManager ()->find ( 'Application\Model\Turma', $data ['id'] );
					$turma = getMatricula ()->clear ();
				}
				$turma->setData ( $data );
				$turma->setCapacitacao ( $capacitacao );
				$turma->setInstituicao ( $instituicao );
				$turma->setCoordenacao ( $coordenacao );
				$turma->setInstrutores ( $instrutor );
				$this->getEntityManager ()->persist ( $turma );
				$this->getEntityManager ()->flush ();
				return $this->redirect ()->toUrl ( '/application/turma' );
			}
		}
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id > 0) {
			$turma = $this->getEntityManager ()->find ( 'Application\Model\Turma', $id );
			$form->bind ( $turma );
		}
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/turma.js' );
		$renderer->headScript ()->appendFile ( '/js/jquery.mask.js' );
		return new ViewModel ( array (
				'form' => $form,
				'turma' => $turma
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