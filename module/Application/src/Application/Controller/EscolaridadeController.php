<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\Escolaridade;
use Application\Form\Escolaridade as EscolaridadeForm;
use Doctrine\ORM\EntityManager;

/**
 * Controlador que gerencia o cadastro de Escolaridades
 *
 * @category Application
 * @package Controller
 * @author Paulo R. Silla <paulo.silla@embrapa.br>
 *        
 */
class EscolaridadeController extends ActionController {
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
	 * Mostra as Escolaridades cadastrados
	 *
	 * @return void
	 */
	public function indexAction() {
		$escolaridades = $this->getEntityManager ()->getRepository ( "Application\Model\Escolaridade" )->findAll ( array (), array (
				'ordem' => 'ASC' 
		) );
		
		// adiciona os arquivos indexcomum.js e jquery.dataTable.min.js
		// ao head da página
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/indexcomum.js' );
		return new ViewModel ( array (
				'escolaridades' => $escolaridades 
		) );
	}
	public function buscaescolaridadesAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$qb = $this->getEntityManager ()->createQueryBuilder ();
			$qb->select ( 'e' )->from ( 'Application\Model\Escolaridade', 'e' )->orderBy ( 'e.ordem', 'DESC' );
			$escolaridades = $qb->getQuery ()->getResult ();
			
			$escolaridadesOption = "<option value=''>Selecione uma escolaridade...</option>";
			foreach ( $escolaridades as $escolaridade ) {
				$escolaridadesOption .= "<option value='" . $escolaridade->getId () . "'>" . $escolaridade->getDescricao () . "</option>";
			}
			$response->setContent ( \Zend\Json\Json::encode ( array (
					'dataType' => 'json',
					'response' => true,
					'escolaridades' => $escolaridadesOption 
			) ) );
		}
		return $response;
	}
	
	/**
	 * Cria ou edita um Escolaridade
	 *
	 * @return void
	 */
	public function saveAction() {
		$form = new EscolaridadeForm ();
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$escolaridade = new Escolaridade ();
			$form->setInputFilter ( $escolaridade->getInputFilter () );
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$data = $form->getData ();
				unset ( $data ['submit'] );
				if (isset ( $data ['id'] ) && $data ['id'] > 0) {
					$escolaridade = $this->getEntityManager ()->find ( 'Application\Model\Escolaridade', $data ['id'] );
				}
				$escolaridade->setData ( $data );
				$this->getEntityManager ()->persist ( $escolaridade );
				$this->getEntityManager ()->flush ();
				
				return $this->redirect ()->toUrl ( '/application/escolaridade' );
			}
		}
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id > 0) {
			$escolaridade = $this->getEntityManager ()->find ( 'Application\Model\Escolaridade', $id );
			$form->bind ( $escolaridade );
			$form->get ( 'submit' )->setAttribute ( 'value', 'Edit' );
		}
		return new ViewModel ( array (
				'form' => $form 
		) );
	}
	
	/**
	 * Exclui uma Escolaridade
	 *
	 * @return void
	 */
	public function deleteAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			throw new \ErrorException ( "Código obrigatório" );
		}
		$escolaridade = $this->getEntityManager ()->find ( 'Application\Model\Escolaridade', $id );
		if ($escolaridade) {
			$this->getEntityManager ()->remove ( $escolaridade );
			$this->getEntityManager ()->flush ();
		}
		return $this->redirect ()->toUrl ( '/application/escolaridade' );
	}
}
