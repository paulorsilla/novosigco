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
	
	public function buscalistaesperaAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false
		) ) );
		if ($request->isPost ()) {
			$idCapacitacao = $this->params()->fromPost('idCapacitacao');
			$capacitacao = $this->getEntityManager()->find("Application\Model\Capacitacao",$idCapacitacao);
			error_log($idCapacitacao);
			$empregados = 	$capacitacao->getListaEspera()->getMatricula();
			$stringEmpregados = '[';
			foreach ( $empregados as $key => $empregado ) { 
				$stringEmpregados .= '{"matricula": "' . $empregado->getMatricula () . '", "nome": "' . $empregado->getNome () . '", "ramal": "' . $empregado->getRamal().'"}';
				if (isset ( $empregados [$key + 1] )) {
					$stringEmpregados .= ',';
				}
			}
			$stringEmpregados .= ']';
			$response->setContent ( \Zend\Json\Json::encode ( array (
					'dataType' => 'json',
					'response' => true,
					'empregados' => $stringEmpregados
			) ) );
		}
		return $response;
	}

	public function saveAction() {
		$form = new ListaEsperaForm ($this->getEntityManager ());
		$empregados = array();
		$request = $this->getRequest ();
		//Hidratar classe
		$form->setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods(false));
		if ($request->isPost ()) {
			$espera = new ListaEspera();
			$form->setInputFilter ( $espera->getInputFilter () );
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$data = $form->getData ();
				$capacitacao = $this->getEntityManager ()->find ( 'Application\Model\Capacitacao', $data ['capacitacao'] );
				unset ( $data ['capacitacao'] );
				unset ( $data ['submit'] );
				$matriculas = $this->params ()->fromPost ( "matricula" );
				if (isset ( $data ['id'] ) && $data ['id'] > 0) {
					$espera = $this->getEntityManager ()->find ( 'Application\Model\ListaEspera', $data ['id'] );
					$espera->getMatricula ()->clear ();
				}
				$espera->setData ( $data );
				$espera->setCapacitacao ( $capacitacao);
				foreach ( $matriculas as $matricula ) {
					$empregado = $this->getEntityManager ()->find ( "Application\Model\Empregado", $matricula );
					$espera->getMatricula ()->add ( $empregado);
				}
				$this->getEntityManager ()->persist ( $espera );
				$this->getEntityManager ()->flush ();
				return $this->redirect ()->toUrl ( '/application/lista-espera' );
			}
		}
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id > 0) {
			$espera = $this->getEntityManager ()->find ( 'Application\Model\ListaEspera', $id );
			$form->bind ( $espera);
			$empregados = $espera->getMatricula();
		}
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/listaEspera.js' );
		return new ViewModel ( array (
				'form' => $form,
				'empregados' => $empregados
		) );
	}
	public function deleteAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			throw new \ErrorException ( "Código obrigatório" );
		}
		$espera = $this->getEntityManager ()->find ( 'Application\Model\ListaEspera', $id );
		if ($espera) {
			$this->getEntityManager ()->remove ( $espera );
			$this->getEntityManager ()->flush ();
		}
		return $this->redirect ()->toUrl ( '/application/lista-espera' );
	}

}