<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\Competencia;
use Application\Form\Competencia as CompetenciaForm;
use Doctrine\ORM\EntityManager;

/**
 * Controlador que gerencia o cadastro de competencias
 *
 * @category Application
 * @package Controller
 * @author Paulo R. Silla <paulo.silla@embrapa.br>
 * @author William Gerenutti <william.alves@colaborador.embrapa.br>
 */
class CompetenciaController extends ActionController {
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
	 * Mostra as Competencias cadastradas
	 *
	 * @return void
	 */
	public function indexAction() {
		$competencias = $this->getEntityManager ()->getRepository ( "Application\Model\Competencia" )->findAll ( array (), array (
				'titulo' => 'ASC' 
		) );
		
		// adiciona os arquivos indexcomum.js e jquery.dataTable.min.js
		// ao head da página
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/indexcomum.js' );
		return new ViewModel ( array (
				'competencias' => $competencias 
		) );
	}
// 	public function buscacompetenciaAction()
// 	{
// 		$request = $this->getRequest();
// 		$response = $this->getResponse();
// 		$response->setContent(\Zend\Json\Json::encode(array('dataType' => 'json', 'response' => false)));
// 		if ($request->isPost()) {
// 			$competencias = $this->getEntityManager()->getRepository("Application\Model\Competencia")->findAll(array(), array('titulo' => 'ASC'));
// 			$tipoCompetencia = array("1"=> "Competência Comportamental", "2" => "Competêncial Gerencial", "3" => "Competência Técnica");
// 			$stringCompetencias = '[';
// 			foreach ($competencias as $key=>$competencia){																					//array de tipoCompetencia definido na linha 60
// 				$stringCompetencias .= '{"id": "' . $competencia->getId() .'", "titulo": "' . $competencia->getTitulo(). '", "tipo": " '. $tipoCompetencia [$competencia->getTipoCompetencia()]. '"}';
// 				if(isset($competencias[$key+1])){
// 					$stringCompetencias.=',';
// 				}
// 			}
// 			$stringCompetencias.=']';
// 			$response->setContent(\Zend\Json\Json::encode(array('dataType' => 'json', 'response' => true, 'competencias' => $stringCompetencias)));
// 		}
		
// 		return $response;
// 	}
	public function saveAction() {
		$form = new CompetenciaForm ($this->getEntityManager());
		//Hidratação para verificar o nome das classes
		$form->setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods(false));
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$competencia = new Competencia ();
			$form->setInputFilter ( $competencia->getInputFilter () );
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$data = $form->getData ();
				$competenciaTipo = $this->getEntityManager ()->find ( 'Application\Model\CompetenciaTipo', $data ['competenciaTipo'] );
				unset ( $data ['competenciaTipo'] );
				unset ( $data ['submit'] );
				if (isset ( $data ['id'] ) && $data ['id'] > 0) {
					$competencia = $this->getEntityManager ()->find ( 'Application\Model\Competencia', $data ['id'] );
					$capacitacao->getCompetencias ()->clear ();
				}
				$competencia->setData ( $data );
				$competencia->setCompetenciaTipo ( $competenciaTipo );
				$this->getEntityManager ()->persist ( $competencia );
				$this->getEntityManager ()->flush ();
				return $this->redirect ()->toUrl ( '/application/competencia' );
			}
		}
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id > 0) {
			$competencia = $this->getEntityManager ()->find ( 'Application\Model\Competencia', $id );
			$form->bind ( $competencia );
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
		$competencia = $this->getEntityManager ()->find ( 'Application\Model\Competencia', $id );
		if ($competencia) {
			$this->getEntityManager ()->remove ( $competencia );
			$this->getEntityManager ()->flush ();
		}
		return $this->redirect ()->toUrl ( '/application/competencia' );
	}
}