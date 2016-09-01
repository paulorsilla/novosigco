<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\Instrutor;
use Application\Form\Instrutor as InstrutorForm;
use Doctrine\ORM\EntityManager;

/**
 * Controlador que gerencia o cadastro de Instrutores
 *
 * @category Application
 * @package Controller
 * @author Paulo R. Silla <paulo.silla@embrapa.br>
 * @author William Gerenutti <william.alves@colaborador.embrapa.br>
 */
class InstrutorController extends ActionController {
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
	protected $em2;
	public function setEntityManager2(EntityManager $em2) {
		$this->em2 = $em2;
	}
	public function getEntityManager2() {
		if (null === $this->em2) {
			$this->em2 = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_nco' );
		}
		return $this->em2;
	}
	
	public function indexAction() {
		$instrutores = $this->getEntityManager ()->getRepository ( "Application\Model\Instrutor" )->findAll ( array (), array (
				'ordem' => 'ASC' 
		) );
		// adiciona os arquivos indexcomum.js e jquery.dataTable.min.js
		// ao head da página
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/indexcomum.js' );
		return new ViewModel ( array (
				'instrutores' => $instrutores,
		) );
	}
	public function saveAction() {
		$form = new InstrutorForm ($this->getEntityManager2());
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$instrutor = new Instrutor ();
			$form->setInputFilter ( $instrutor->getInputFilter () );
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$data = $form->getData ();
//				$nascimento = new \DateTime($this->params()->fromPost("nascimento"));
//				$cpf = preg_replace('/[^0-9]/', '',  $this->params()->fromPost("cpf"));
				$instituicao_id = $this->params()->fromPost("instituicao");
				$instituicao = $this->getEntityManager()->find ('Application\Model\Instituicao', $instituicao_id);
				unset ( $data ['submit'] );
// 				unset ($data["nascimento"]);
// 				unset ($data["cpf"]);
				unset ($data["instituicao"]);
				if (isset ( $data ['id'] ) && $data ['id'] > 0) {
					$instrutor = $this->getEntityManager ()->find ( 'Application\Model\Instrutor', $data ['id'] );
				}
				$instrutor->setData ( $data );
//				$instrutor->setNascimento($nascimento);
//				$instrutor->setCpf($cpf);
				$instrutor->setInstituicao($instituicao);
				$this->getEntityManager ()->persist ( $instrutor );
				$this->getEntityManager ()->flush ();
				return $this->redirect ()->toUrl ( '/application/instrutor' );
			}
		}
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id > 0) {
			$instrutor = $this->getEntityManager ()->find ( 'Application\Model\Instrutor', $id );
			$form->bind ( $instrutor );
//			$form->get('nascimento') ->setAttribute( 'value', $instrutor->getNascimento());
			$form->get ( 'submit' )->setAttribute ( 'value', 'Edit' );
		}
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.mask.js' );
		return new ViewModel ( array (
				'form' => $form,
		) );
	}
	/**
	 * Exclui um Instrutor
	 *
	 * @return void
	 */
	public function deleteAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			throw new \exception ( "Código obrigatório" );
		}
		$instrutor = $this->getEntityManager ()->find ( 'Application\Model\Instrutor', $id );
		if ($instrutor) {
			$this->getEntityManager ()->remove ( $instrutor );
			$this->getEntityManager ()->flush ();
		}
		return $this->redirect ()->toUrl ( '/application/instrutor' );
	}
}