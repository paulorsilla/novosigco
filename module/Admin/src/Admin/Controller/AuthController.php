<?php
namespace Admin\Controller;
 
use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Admin\Form\Login;
use Doctrine\ORM\EntityManager;
 
/**
* Controlador que gerencia a autenticação do usuário
*
* @category Admin
* @package Controller
* @author Paulo R. Silla<paulo.silla@embrapa.br>
*/
class AuthController extends ActionController {
	
	/**
	 * @var DoctrineORMEntityManager
	 */
	protected $em;
	
	public function getEntityManager() {
		if (null === $this->em) {
			$this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		}
		return $this->em;
	}
	
	/**
	* Mostra o formulário de login
	* @return void
	*/
	public function indexAction()
	{
		$form = new Login();
		//adiciona o arquivo login.js ao head da página
		$renderer = $this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer');
		$renderer->headScript()->appendFile('/js/login.js');
		
        return new ViewModel(array(
			'form' => $form
		));
	}
	
	/**
	* Faz o login do usuário
	* @return void
	*/
	public function loginAction()
	{
		$request = $this->getRequest();
		if (!$request->isPost()) {
			throw new \exception('Acesso inválido');
		}
        
        $url = "/";
		$data = $request->getPost();
        $em = $this->getEntityManager();
        $service = $this->getService('Admin\Service\Auth');
        $auth = $service->authenticate(array('nome' => $data['nome'], 'senha' => $data['senha']), $em);
        return $this->redirect()->toUrl($url);
	}
	
	/**
	* Faz o logout do usuário
	* @return void
	*/
	public function logoutAction()
	{
		$service = $this->getService('Admin\Service\Auth');
		$auth = $service->logout();
		return $this->redirect()->toUrl('/');
	}
}