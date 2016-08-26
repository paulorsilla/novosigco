<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\Capacitacao;
use Application\Form\Capacitacao as CapacitacaoForm;
use Doctrine\ORM\EntityManager;

/**
 * Controlador que gerencia o cadastro de capacitações
 *
 * @category Application
 * @package Controller
 * @author Paulo R. Silla <paulo.silla@embrapa.br>
 * @author William Gerenutti <william.alves@colaborador.embrapa.br>
 */
class CapacitacaoController extends ActionController {
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
	 * Mostra as capacitações cadastrados
	 *
	 * @return void
	 */
	public function indexAction() {
		$capacitacoes = $this->getEntityManager ()->getRepository ( "Application\Model\Capacitacao" )->findAll ( array (), array (
				'descricao' => 'ASC' 
		) );
		
		// adiciona os arquivos indexcomum.js e jquery.dataTable.min.js
		// ao head da página
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/indexcomum.js' );
		return new ViewModel ( array (
				'capacitacoes' => $capacitacoes 
		) );
	}
	public function buscacompetenciasAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$capacitacaoId = $this->params ()->fromPost ( "capacitacaoId" );
			$capacitacao = $this->getEntityManager ()->find ( 'Application\Model\Capacitacao', $capacitacaoId );
			$stringCompetencias = '[';
			if ($capacitacao) {
				$competencias = $capacitacao->getCompetencias ();
				foreach ( $capacitacao->getCompetencias () as $key => $competencia ) { // array de tipoCompetencia definido na linha 60
					$stringCompetencias .= '{"id": "' . $competencia->getId () . '"}';
					if (isset ( $competencias [$key + 1] )) {
						$stringCompetencias .= ',';
					}
				}
				
				$stringCompetencias .= ']';
			}
			$response->setContent ( \Zend\Json\Json::encode ( array (
					'dataType' => 'json',
					'response' => true,
					'competencias' => $stringCompetencias 
			) ) );
		}
		return $response;
	}
	
	public function saveAction() {
		$form = new CapacitacaoForm ( $this->getEntityManager () );
		//Hidratação para verificar o nome das classes
		$form->setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods(false));
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$capacitacao = new Capacitacao ();
			$form->setInputFilter ( $capacitacao->getInputFilter () );
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$data = $form->getData ();
				$capacitacaoTipo = $this->getEntityManager ()->find ( 'Application\Model\CapacitacaoTipo', $data ['capacitacaoTipo'] );
				unset ( $data ['capacitacaoTipo'] );
				unset ( $data ['submit'] );
				$competencias = $this->params ()->fromPost ( "competencia" );
				if (isset ( $data ['id'] ) && $data ['id'] > 0) {
					$capacitacao = $this->getEntityManager ()->find ( 'Application\Model\Capacitacao', $data ['id'] );
					$capacitacao->getCompetencias ()->clear ();
				}
				$capacitacao->setData ( $data );
				$capacitacao->setCapacitacaoTipo ( $capacitacaoTipo );
				foreach ( $competencias as $competenciaid ) {
					$competencia = $this->getEntityManager ()->find ( "Application\Model\Competencia", $competenciaid );
					$capacitacao->getCompetencias ()->add ( $competencia );
				}
				$this->getEntityManager ()->persist ( $capacitacao );
				$this->getEntityManager ()->flush ();
				return $this->redirect ()->toUrl ( '/application/capacitacao' );
			}
		}
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id > 0) {
			$capacitacao = $this->getEntityManager ()->find ( 'Application\Model\Capacitacao', $id );
			$form->bind ( $capacitacao );
		}
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/capacitacao.js' );
		return new ViewModel ( array (
				'form' => $form 
		) );
	}
	public function deleteAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			throw new \exception ( "Código obrigatório" );
		}
		$capacitacao = $this->getEntityManager ()->find ( 'Application\Model\Capacitacao', $id );
		if ($capacitacao) {
			$this->getEntityManager ()->remove ( $capacitacao );
			$this->getEntityManager ()->flush ();
		}
		return $this->redirect ()->toUrl ( '/application/capacitacao' );
	}
	
	
}