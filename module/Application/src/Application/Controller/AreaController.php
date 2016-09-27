<?php
namespace Application\Controller;
 
use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\Area;
use Application\Form\Area as AreaForm;
 
use Doctrine\ORM\EntityManager;
 
/**
* Controlador que gerencia o cadastro de Areas
*
* @category Application
* @package Controller
* @author Paulo R. Silla <paulo.silla@embrapa.br>
*/
class AreaController extends ActionController
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
	* Mostra as areas cadastrados
	* @return void
	*/
	public function indexAction()
	{
        $areas = $this->getEntityManager()
                      ->getRepository("Application\Model\Area")
                      ->findAll(array(), array('descricao' => 'ASC'));

        //adiciona os arquivos indexcomum.js e jquery.dataTable.min.js
        //ao head da página
        $renderer = $this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer');
        $renderer->headScript()->appendFile('/js/jquery.dataTables.min.js');
        $renderer->headScript()->appendFile('/js/indexcomum.js');
        return new ViewModel(array(
			'areas' => $areas
		));
	}
	
	public function buscaareasAction() 
	{
		$request = $this->getRequest();
		$response = $this->getResponse();
		$response->setContent(\Zend\Json\Json::encode(array('dataType' => 'json', 'response' => false)));
		if ($request->isPost()) {
			$areas = $this->getEntityManager()->getRepository('Application\Model\Area')->findAll(array(), array('descricao' => 'ASC'));
			$areasOption = "<option value=''>--- Selecione uma Área ---</option>";
			foreach($areas as $area) {
				$areasOption .= "<option value='".$area->getId()."'>".$area->getDescricao()."</option>";
			}
			$response->setContent(\Zend\Json\Json::encode(array('dataType' => 'json',
																'response' => true,
																'areas' => $areasOption)));
		}
		return $response;
	}

	/**
	* Cria ou edita um Area
	* @return void
	*/
	public function saveAction()
	{
        $form = new AreaForm();
		$request = $this->getRequest();
		if ($request->isPost()) {
			$area = new Area();
			$form->setInputFilter($area->getInputFilter());
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$data = $form->getData();
				unset($data['submit']);
				if (isset($data['id']) && $data['id'] > 0) {
					$area = $this->getEntityManager()->find('Application\Model\Area', $data['id']);
				}
				$area->setData($data);
				$this->getEntityManager()->persist($area);
				$this->getEntityManager()->flush();
				
				return $this->redirect()->toUrl('/application/area');
			}
		}
		$id = (int) $this->params()->fromRoute('id', 0);
		if ($id > 0) {
			$area = $this->getEntityManager()->find('Application\Model\Area', $id);
			$form->bind($area);
			$form->get('submit')->setAttribute('value', 'Edit');
		}
		return new ViewModel(
			array('form' => $form)
		);
	}

	/**
	* Exclui um Area
	* @return void
	*/
	public function deleteAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if ($id == 0) {
			throw new \exception("Código obrigatório");
		}
		$area = $this->getEntityManager()->find('Application\Model\Area', $id);
		if ($area) {
			$this->getEntityManager()->remove($area);
			$this->getEntityManager()->flush();
		}
		return $this->redirect()->toUrl('/application/area');
	}
}