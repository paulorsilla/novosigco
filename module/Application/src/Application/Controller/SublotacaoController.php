<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\Sublotacao;
use Application\Form\Sublotacao as SublotacaoForm;
use Doctrine\ORM\EntityManager;

/**
 * Controlador que gerencia o cadastro de Sublotacaos
 *
 * @category Application
 * @package Controller
 * @author Paulo R. Silla <paulo.silla@embrapa.br>
 *        
 */
class SublotacaoController extends ActionController {
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
	 * Mostra as Sublotações cadastrados
	 * 
	 * @return void
	 */
	public function indexAction() {
		$sublotacoes = $this->getEntityManager ()->getRepository ( "Application\Model\Sublotacao" )->findAll ( array (), array (
				'descricao' => 'ASC' 
		) );
		
		// adiciona os arquivos indexcomum.js e jquery.dataTable.min.js
		// ao head da página
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/indexcomum.js' );
		return new ViewModel ( array (
				'sublotacoes' => $sublotacoes 
		) );
	}
	public function buscasublotacoesAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$sublotacoes = $this->getEntityManager ()->getRepository ( "Application\Model\Sublotacao" )->findAll ( array (), array (
					'descricao' => 'ASC' 
			) );
			$sublotacoesOption = "<option value=''>Selecione uma Sublotação...</option>";
			foreach ( $sublotacoes as $sublotacao ) {
				$sublotacoesOption .= "<option value='" . $sublotacao->getId () . "'>" . $sublotacao->getDescricao () . " - " . $sublotacao->getSigla () . "</option>";
			}
			$response->setContent ( \Zend\Json\Json::encode ( array (
					'dataType' => 'json',
					'response' => true,
					'sublotacoes' => $sublotacoesOption 
			) ) );
		}
		return $response;
	}
	
	/**
	 * Cria ou edita um Sublotacao
	 * 
	 * @return void
	 */
	public function saveAction() {
		$form = new SublotacaoForm ();
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$sublotacao = new Sublotacao ();
			$form->setInputFilter ( $sublotacao->getInputFilter () );
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$data = $form->getData ();
				unset ( $data ['submit'] );
				if (isset ( $data ['id'] ) && $data ['id'] > 0) {
					$sublotacao = $this->getEntityManager ()->find ( 'Application\Model\Sublotacao', $data ['id'] );
				}
				$sublotacao->setData ( $data );
				$this->getEntityManager ()->persist ( $sublotacao );
				$this->getEntityManager ()->flush ();
				
				return $this->redirect ()->toUrl ( '/application/sublotacao' );
			}
		}
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id > 0) {
			$sublotacao = $this->getEntityManager ()->find ( 'Application\Model\Sublotacao', $id );
			$form->bind ( $sublotacao );
			$form->get ( 'submit' )->setAttribute ( 'value', 'Edit' );
		}
		return new ViewModel ( array (
				'form' => $form 
		) );
	}
	
	/**
	 * Exclui uma Sublotaçao
	 * 
	 * @return void
	 */
	public function deleteAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			throw new \ErrorException ( "Código obrigatório" );
		}
		$sublotacao = $this->getEntityManager ()->find ( 'Application\Model\Sublotacao', $id );
		if ($sublotacao) {
			$this->getEntityManager()->remove($sublotacao);
			$this->getEntityManager()->flush();
		}
		return $this->redirect()->toUrl('/application/sublotacao');
	}
}
