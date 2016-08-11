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
				error_log($stringCompetencias);
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
		$form = new CursoForm ();
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$curso = new Curso ();
			$form->setInputFilter ( $curso->getInputFilter () );
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$data = $form->getData ();
				unset ( $data ['submit'] );
				$competencias = $this->params()->fromPost("competencia");
				if (isset ( $data ['id'] ) && $data ['id'] > 0) {
					$curso = $this->getEntityManager ()->find ( 'Application\Model\Curso', $data ['id'] );
					$curso->getCompetencias()->clear();
					}
				$curso->setData ( $data );
				foreach ($competencias as $competenciaid){
					$competencia = $this->getEntityManager()->find("Application\Model\Competencia",$competenciaid);
					$curso->getCompetencias()->add($competencia);
				}
				$this->getEntityManager ()->persist ( $curso );
				$this->getEntityManager ()->flush ();
				return $this->redirect ()->toUrl ( '/application/curso' );
			}
		}
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id > 0) {
			$curso = $this->getEntityManager ()->find ( 'Application\Model\Curso', $id );
			$form->bind ( $curso );
			$form->get ( 'submit' )->setAttribute ( 'value', 'Edit' );
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