<?php
namespace Application\Controller;
 
use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\EquipeTecnica;
use Application\Form\EquipeTecnica as EquipeTecnicaForm;
use Application\Repository\EmpregadoRepository;
 
use Doctrine\ORM\EntityManager;
 
/**
* Controlador que gerencia o cadastro de Areas
*
* @category Application
* @package Controller
* @author Paulo R. Silla <paulo.silla@embrapa.br>
*/
class EquipeTecnicaController extends ActionController
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
	* Mostra as equipes técnicas cadastradas
	* @return void
	*/
	public function indexAction()
	{
        $equipes = $this->getEntityManager()
                        ->getRepository("Application\Model\EquipeTecnica")
                        ->findAll(array(), array('descricao' => 'ASC'));
        $em2 = $this->getServiceLocator()->get('doctrine.entitymanager.orm_rh');
        
        $listaEmpregados = $em2->getRepository('Application\Model\Empregado')->getEmpregados();
        
        $empregados = array();
        
        foreach($listaEmpregados as $empregado ) {
        	$empregados[$empregado->getMatricula()] = $empregado->getNome();
        }

        //adiciona os arquivos indexcomum.js e jquery.dataTable.min.js
        //ao head da página
        $renderer = $this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer');
        $renderer->headScript()->appendFile('/js/jquery.dataTables.min.js');
        $renderer->headScript()->appendFile('/js/indexcomum.js');
        return new ViewModel(array(
			'equipes' => $equipes,
        	'empregados' => $empregados
		));
	}
	
	public function buscaequipestecnicasAction() {
		$request = $this->getRequest();
		$response = $this->getResponse();
		$response->setContent(\Zend\Json\Json::encode(array('dataType' => 'json', 'response' => false)));
		if ($request->isPost()) {
	
			$equipes = $this->getEntityManager()->getRepository("Application\Model\EquipeTecnica")
												->findAll(array(), array('descricao' => 'ASC'));
			$equipesOption = "<option value=''>Selecione uma equipe técnica...</option>";
			foreach($equipes as $equipe) {
				$equipesOption .= "<option value='".$equipe->getId()."'>".$equipe->getDescricao()."</option>";
			}
			$response->setContent(\Zend\Json\Json::encode(array('dataType' => 'json',
					'response' => true,
					'equipes' => $equipesOption)));
		}
		return $response;
	}
//parei aqui
	/**
	* Cria ou edita uma Equipe Técnica
	* @return void
	*/
	public function saveAction()
	{
		$em2 = $this->getServiceLocator()->get('doctrine.entitymanager.orm_rh');
        $form = new EquipeTecnicaForm($em2);
		$request = $this->getRequest();
		if ($request->isPost()) {
			$equipeTecnica = new EquipeTecnica();
			$form->setInputFilter($equipeTecnica->getInputFilter());
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$data = $form->getData();
				unset($data['submit']);
				if (isset($data['id']) && $data['id'] > 0) {
					$equipeTecnica = $this->getEntityManager()->find('Application\Model\EquipeTecnica', $data['id']);
				}
				$equipeTecnica->setData($data);
				$this->getEntityManager()->persist($equipeTecnica);
				$this->getEntityManager()->flush();
				
				return $this->redirect()->toUrl('/application/equipe-tecnica');
			}
		}
		$id = (int) $this->params()->fromRoute('id', 0);
		if ($id > 0) {
			$equipeTecnica = $this->getEntityManager()->find('Application\Model\EquipeTecnica', $id);
			$form->bind($equipeTecnica);
			$form->get('submit')->setAttribute('value', 'Edit');
		}
		return new ViewModel(
			array('form' => $form)
		);
	}

	/**
	* Exclui uma Equipe Técnica
	* @return void
	*/
	public function deleteAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if ($id == 0) {
			throw new \exception("Código obrigatório");
		}
		$equipeTecnica = $this->getEntityManager()->find('Application\Model\EquipeTecnica', $id);
		if ($equipeTecnica) {
			$this->getEntityManager()->remove($equipeTecnica);
			$this->getEntityManager()->flush();
		}
		return $this->redirect()->toUrl('/application/equipe-tecnica');
	}
}
