<?php
namespace Application\Controller;
 
use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\Subarea;
use Application\Form\Subarea as SubareaForm;
 
use Doctrine\ORM\EntityManager;
use Application\Model\Area;
 
/**
* Controlador que gerencia o cadastro de Subárias
*
* @category Application
* @package Controller
* @author Paulo R. Silla <paulo.silla@embrapa.br>
*/
class SubareaController extends ActionController
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
	* Mostra as Subáreas cadastrados
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
        return new ViewModel(array(
			'areas' => $areas
		));
	}

	public function buscasubareasAction()
	{
		$request = $this->getRequest();
		$response = $this->getResponse();
		$response->setContent(\Zend\Json\Json::encode(array('dataType' => 'json', 'response' => false)));
		if ($request->isPost()) {
			$area = $this->params()->fromPost("area");
			$subareas = $this->getEntityManager()->getRepository('Application\Model\Subarea')->findBy(array('area' => $area), array('descricao' => 'ASC'));
			$subareasOption = "<option value=''>--- Selecione uma Subárea ---</option>";
			foreach($subareas as $subarea) {
				$subareasOption .= "<option value='".$subarea->getId()."'>".$subarea->getDescricao()."</option>";
			}
			$response->setContent(\Zend\Json\Json::encode(array('dataType' => 'json',
					'response' => true,
					'subareas' => $subareasOption)));
		}
		return $response;
	}
	
	/**
	* Cria ou edita um Area
	* @return void
	*/
	public function saveAction()
	{
        $form = new SubareaForm($this->getEntityManager());
		$request = $this->getRequest();
		if ($request->isPost()) {
			$subarea = new Subarea();
			$form->setInputFilter($subarea->getInputFilter());
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$data = $form->getData();
				$area = $this->getEntityManager()->find('Application\Model\Area', $data['area']);
				unset($data['area']);
				unset($data['submit']);
				if (isset($data['id']) && $data['id'] > 0) {
					$subarea = $this->getEntityManager()->find('Application\Model\Subarea', $data['id']);
				}
				$subarea->setData($data);
				$subarea->setArea($area);
				$this->getEntityManager()->persist($subarea);
				$this->getEntityManager()->flush();
				
				return $this->redirect()->toUrl('/application/subarea');
			}
		}
		$id = (int) $this->params()->fromRoute('id', 0);
		if ($id > 0) {
			$subarea = $this->getEntityManager()->find('Application\Model\Subarea', $id);
			$form->bind($subarea);
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
		$subarea = $this->getEntityManager()->find('Application\Model\Subarea', $id);
		if ($subarea) {
			$this->getEntityManager()->remove($subarea);
			$this->getEntityManager()->flush();
		}
		return $this->redirect()->toUrl('/application/subarea');
	}
}
