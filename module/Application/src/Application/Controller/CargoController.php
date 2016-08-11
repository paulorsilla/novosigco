<?php
namespace Application\Controller;
 
use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\Cargo;
use Application\Form\Cargo as CargoForm;
 
use Doctrine\ORM\EntityManager;
 
/**
* Controlador que gerencia o cadastro de Cargos
*
* @category Application
* @package Controller
* @author Paulo R. Silla <paulo.silla@embrapa.br>
*/
class CargoController extends ActionController
{
	/**
	* @var Doctrine\ORM\EntityManager
	*/
	protected $em;
	
	public function setEntityManager(EntityManager $em)
	{
		$this->em = $em;
	}
	public function getEntityManager()
	{
		if (null === $this->em) {
			$this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		}
		return $this->em;
	}
	
	/**
	* Mostra os cargos cadastrados
	* @return void
	*/
	public function indexAction()
	{
        $cargos = $this->getEntityManager()
                       ->getRepository("Application\Model\Cargo")
                       ->findAll(array(), array('descricao' => 'ASC'));

        //adiciona os arquivos indexcomum.js e jquery.dataTable.min.js
        //ao head da página
        $renderer = $this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer');
        $renderer->headScript()->appendFile('/js/jquery.dataTables.min.js');
        $renderer->headScript()->appendFile('/js/indexcomum.js');
        return new ViewModel(array(
			'cargos' => $cargos
		));
	}
	
	public function buscacargosAction() {
		$request = $this->getRequest();
		$response = $this->getResponse();
		$response->setContent(\Zend\Json\Json::encode(array('dataType' => 'json', 'response' => false)));
		if ($request->isPost()) {
				
        	$cargos = $this->getEntityManager()
                           ->getRepository("Application\Model\Cargo")
                           ->findAll(array(), array('descricao' => 'ASC'));
			$cargosOption = "<option value=''>Selecione um cargo...</option>";
			foreach($cargos as $cargo) {
				$cargosOption .= "<option value='".$cargo->getId()."'>".$cargo->getDescricao()."</option>";
			}
			$response->setContent(\Zend\Json\Json::encode(array('dataType' => 'json',
					'response' => true,
					'cargos' => $cargosOption)));
		}
		return $response;
	}

	/**
	* Cria ou edita um Cargo
	* @return void
	*/
	public function saveAction()
	{
        $form = new CargoForm();
		$request = $this->getRequest();
		if ($request->isPost()) {
			$cargo = new Cargo();
			$form->setInputFilter($cargo->getInputFilter());
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$data = $form->getData();
				unset($data['submit']);
				if (isset($data['id']) && $data['id'] > 0) {
					$cargo = $this->getEntityManager()->find('Application\Model\Cargo', $data['id']);
				}
				$cargo->setData($data);
				$this->getEntityManager()->persist($cargo);
				$this->getEntityManager()->flush();
				
				return $this->redirect()->toUrl('/application/cargo');
			}
		}
		$id = (int) $this->params()->fromRoute('id', 0);
		if ($id > 0) {
			$cargo = $this->getEntityManager()->find('Application\Model\Cargo', $id);
			$form->bind($cargo);
			$form->get('submit')->setAttribute('value', 'Edit');
		}
		return new ViewModel(
			array('form' => $form)
		);
	}

	/**
	* Exclui um Cargo
	* @return void
	*/
	public function deleteAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if ($id == 0) {
			throw new \exception("Código obrigatório");
		}
		$Cargo = $this->getEntityManager()->find('Application\Model\Cargo', $id);
		if ($Cargo) {
			$this->getEntityManager()->remove($Cargo);
			$this->getEntityManager()->flush();
		}
		return $this->redirect()->toUrl('/application/cargo');
	}
}
