<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\Funcao;
use Application\Form\Funcao as FuncaoForm;
use Doctrine\ORM\EntityManager;

/**
 * Controlador que gerencia o cadastro de Funções
 *
 * @category Application
 * @package Controller
 * @author Paulo R. Silla <paulo.silla@embrapa.br>
 *        
 */
class FuncaoController extends ActionController {
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
	 * Mostra as Funcaos cadastrados
	 * 
	 * @return void
	 */
	public function indexAction() {
		$funcoes = $this->getEntityManager ()->getRepository ( "Application\Model\Funcao" )->findAll ( array (), array (
				'descricao' => 'ASC' 
		) );
		
		// adiciona os arquivos indexcomum.js e jquery.dataTable.min.js
		// ao head da página
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/indexcomum.js' );
		return new ViewModel ( array (
				'funcoes' => $funcoes 
		) );
	}
	public function buscafuncoesAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			
			$funcoes = $this->getEntityManager ()->getRepository ( "Application\Model\Funcao" )->findAll ( array (), array (
					'descricao' => 'ASC' 
			) );
			$funcoesOption = "<option value=''>Selecione uma função...</option>";
			foreach ( $funcoes as $funcao ) {
				$funcoesOption .= "<option value='" . $funcao->getId () . "'>" . $funcao->getDescricao () . "</option>";
			}
			$response->setContent ( \Zend\Json\Json::encode ( array (
					'dataType' => 'json',
					'response' => true,
					'funcoes' => $funcoesOption 
			) ) );
		}
		return $response;
	}
	
	/**
	 * Cria ou edita um Funcao
	 * 
	 * @return void
	 */
	public function saveAction() {
		$form = new FuncaoForm ();
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$funcao = new Funcao ();
			$form->setInputFilter ( $funcao->getInputFilter () );
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$data = $form->getData ();
				unset ( $data ['submit'] );
				if (isset ( $data ['id'] ) && $data ['id'] > 0) {
					$funcao = $this->getEntityManager ()->find ( 'Application\Model\Funcao', $data ['id'] );
				}
				$funcao->setData ( $data );
				$this->getEntityManager ()->persist ( $funcao );
				$this->getEntityManager ()->flush ();
				
				return $this->redirect ()->toUrl ( '/application/funcao' );
			}
		}
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id > 0) {
			$funcao = $this->getEntityManager ()->find ( 'Application\Model\Funcao', $id );
			$form->bind ( $funcao );
			$form->get ( 'submit' )->setAttribute ( 'value', 'Edit' );
		}
		return new ViewModel ( array (
				'form' => $form 
		) );
	}
	
	/**
	 * Exclui um Funcao
	 * 
	 * @return void
	 */
	public function deleteAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			throw new \ErrorException ( "Código obrigatório" );
		}
		$funcao = $this->getEntityManager ()->find ( 'Application\Model\Funcao', $id );
		if ($funcao) {
			$this->getEntityManager ()->remove ( $funcao );
			$this->getEntityManager ()->flush ();
		}
		return $this->redirect ()->toUrl ( '/application/funcao' );
	}
}
