<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\Curso;
use Application\Form\Curso as CursoForm;
use Doctrine\ORM\EntityManager;

/**
 * Controlador que gerencia o cadastro de cursos
 *
 * @category Application
 * @package Controller
 * @author Paulo R. Silla <paulo.silla@embrapa.br>
 * @author William Gerenutti <william.alves@colaborador.embrapa.br>
 */
class CursoController extends ActionController {
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
	 * Mostra os cursos cadastrados
	 *
	 * @return void
	 */
	public function indexAction() {
		$cursos = $this->getEntityManager ()->getRepository ( "Application\Model\Curso" )->findAll ( array (), array (
				'descricao' => 'ASC'
		) );
	
		// adiciona os arquivos indexcomum.js e jquery.dataTable.min.js
		// ao head da página
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/indexcomum.js' );
		return new ViewModel ( array (
				'cursos' => $cursos
		) );
	}
	public function buscacompetenciasAction(){
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false
		) ) );
		if ($request->isPost ()) {
			$cursoId = $this->params()->fromPost("cursoId");
			$curso = $this->getEntityManager()->find('Application\Model\Curso',$cursoId);
			if($curso){
				$stringCompetencias = '[';
				$competencias = $curso->getCompetencias();
				foreach ($curso->getCompetencias() as $key=>$competencia){																					//array de tipoCompetencia definido na linha 60
					$stringCompetencias .= '{"id": "' . $competencia->getId() . '"}';
					if(isset($competencias[$key+1])){
						$stringCompetencias.=',';
					}
				}
				
				$stringCompetencias.=']';
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
		error_log("1");
		$form = new CursoForm ($this->getEntityManager());
		$request = $this->getRequest ();
		error_log("2");
		if ($request->isPost ()) {
			error_log("3");
			$curso = new Curso ();
			error_log("4");
			$form->setInputFilter ( $curso->getInputFilter () );
			$form->setData ( $request->getPost () );
			error_log("5");
			if ($form->isValid ()) {
				error_log("6");
				$data = $form->getData ();
				error_log("7");
				unset ( $data ['submit'] );
				error_log("8");
			//	$curso = $this->params()->fromPost("curso");
				error_log("9");
				if (isset ( $data ['id'] ) && $data ['id'] > 0) {
					error_log("10");
					$curso = $this->getEntityManager ()->find ( 'Application\Model\Curso', $data ['id'] );
					error_log("11");
					$curso->getCompetencias()->clear();
					error_log("12");
					}
				$curso->setData ( $data );
				error_log("13");
				foreach ($competencias as $competenciaid){
					error_log("14");
					$competencia = $this->getEntityManager()->find("Application\Model\Competencia",$competenciaid);
					error_log("15");
					$curso->getCompetencias()->add($competencia);
					error_log("16");
				}
				$this->getEntityManager ()->persist ( $curso );
				error_log("17");
				$this->getEntityManager ()->flush ();
				return $this->redirect ()->toUrl ( '/application/curso' );
				error_log("18");
			}
		}
		error_log("19");
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id > 0) {
			error_log("20");
			$curso = $this->getEntityManager ()->find ( 'Application\Model\Curso', $id );
			$form->bind ( $curso );
			error_log("21");
			$form->get ( 'submit' )->setAttribute ( 'value', 'Edit' );
			error_log("22");
		}
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/curso.js' );
		return new ViewModel ( array (
				'form' => $form
		) );
	}
	public function deleteAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			throw new \exception ( "Código obrigatório" );
		}
		$curso = $this->getEntityManager ()->find ( 'Application\Model\Curso', $id );
		if ($curso) {
			$this->getEntityManager ()->remove ( $curso );
			$this->getEntityManager ()->flush ();
		}
		return $this->redirect ()->toUrl ( '/application/curso' );
	}
	
	
}