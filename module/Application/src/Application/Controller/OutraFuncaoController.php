<?php
namespace Application\Controller;
 
use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\OutraFuncao;
use Application\Form\OutraFuncao as FuncaoForm;
 
use Doctrine\ORM\EntityManager;
 
/**
* Controlador que gerencia o cadastro de Outras Funções
*
* @category Application
* @package Controller
* @author Paulo R. Silla <paulo.silla@embrapa.br>
*/
class OutraFuncaoController extends ActionController
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
	* Mostra as Outras Funcoes cadastradas
	* @return void
	*/
	public function indexAction()
	{
        $funcoes = $this->getEntityManager()
                      ->getRepository("Application\Model\OutraFuncao")
                      ->findAll(array(), array('descricao' => 'ASC'));

        //adiciona os arquivos indexcomum.js e jquery.dataTable.min.js
        //ao head da página
        $renderer = $this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer');
        $renderer->headScript()->appendFile('/js/jquery.dataTables.min.js');
        $renderer->headScript()->appendFile('/js/indexcomum.js');
        return new ViewModel(array(
			'funcoes' => $funcoes
		));
	}

	public function buscaoutrasfuncoesAction() {
		$request = $this->getRequest();
		$response = $this->getResponse();
		$response->setContent(\Zend\Json\Json::encode(array('dataType' => 'json', 'response' => false)));
		if ($request->isPost()) {
			$outrasFuncoes = $this->getEntityManager()->getRepository("Application\Model\OutraFuncao")
													  ->findAll(array(), array('descricao' => 'ASC'));
			$funcoesOption = "<option value=''>Selecione uma outra função...</option>";
			foreach($outrasFuncoes as $outraFuncao) {
				$funcoesOption .= "<option value='".$outraFuncao->getId()."'>".$outraFuncao->getDescricao()."</option>";
			}
			$response->setContent(\Zend\Json\Json::encode(array('dataType' => 'json',
					'response' => true,
					'outrasFuncoes' => $funcoesOption)));
		}
		return $response;
	}
	
	/**
	* Cria ou edita uma OutraFuncao
	* @return void
	*/
	public function saveAction()
	{
        $form = new FuncaoForm();
		$request = $this->getRequest();
		if ($request->isPost()) {
			$funcao = new OutraFuncao();
			$form->setInputFilter($funcao->getInputFilter());
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$data = $form->getData();
				unset($data['submit']);
				if (isset($data['id']) && $data['id'] > 0) {
					$funcao = $this->getEntityManager()->find('Application\Model\OutraFuncao', $data['id']);
				}
				$funcao->setData($data);
				$this->getEntityManager()->persist($funcao);
				$this->getEntityManager()->flush();
				
				return $this->redirect()->toUrl('/application/outra-funcao');
			}
		}
		$id = (int) $this->params()->fromRoute('id', 0);
		if ($id > 0) {
			$funcao = $this->getEntityManager()->find('Application\Model\OutraFuncao', $id);
			$form->bind($funcao);
			$form->get('submit')->setAttribute('value', 'Edit');
		}
		return new ViewModel(
			array('form' => $form)
		);
	}

	/**
	* Exclui uma OutraFuncao
	* @return void
	*/
	public function deleteAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if ($id == 0) {
			throw new \ErrorException("Código obrigatório");
		}
		$funcao = $this->getEntityManager()->find('Application\Model\OutraFuncao', $id);
		if ($funcao) {
			$this->getEntityManager()->remove($funcao);
			$this->getEntityManager()->flush();
		}
		return $this->redirect()->toUrl('/application/outra-funcao');
	}
}
