<?php
namespace Application\Controller;
 
use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\Instituicao;
use Application\Form\Instituicao as InstituicaoForm;
use Doctrine\ORM\EntityManager;

/**
* Controlador que gerencia as instituições
*
* @category Application
* @package Controller
* @author Paulo R. Silla <paulo.silla@embrapa.br>
*/
class InstituicaoController extends ActionController
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
			$this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_nco');
		}
		return $this->em;
	}
	
	
	/**
	* Mostra as instituições cadastradas
	* @return void
	*/
	public function indexAction()
	{
//		$instituicoes = $this->getEntityManager()->getRepository('Application\Model\Instituicao')->findBy(array(), array('razao' => 'ASC')); 

//        $qb = $this->getEntityManager()->createQueryBuilder();
//         $expr = $qb->expr();
// 		$qb->select('i')
//    		   ->from('Application\Model\Instituicao', 'i')
// 		   ->where($expr->neq('i.cnpj', 0))
// 		   ->orderBy('i.razao', 'ASC');

		$instituicoes = $this->getEntityManager ()->getRepository ( "Application\Model\Instituicao" )->findBy ( array ('tipoPessoa' => 'Pessoa Jurídica'), array (	'razao' => 'ASC') );
        
        //adiciona os arquivos indexcomum.js e jquery.dataTable.min.js
        //ao head da página
        $renderer = $this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer');
        $renderer->headScript()->appendFile('/js/jquery.dataTables.min.js');
        $renderer->headScript()->appendFile('/js/indexcomum.js');
        return new ViewModel(array(
			'instituicoes' => $instituicoes
		));
	}
	
	public function buscaempregadosAction()
	{
		$request = $this->getRequest();
		$response = $this->getResponse();
		$response->setContent(\Zend\Json\Json::encode(array('dataType' => 'json', 'response' => false)));
		if ($request->isPost()) {
			$instituicao_id = $this->params()->fromPost('codigo');
			
			$instituicao = $this->getEntityManager()->find("Application\Model\Instituicao", $instituicao_id);
 			$empregados = $instituicao->getEmpregados();
 			$representantes = array();
  			foreach($empregados as $key => $empregado) {
  				$representantes[$key] = $empregado->getMatricula()."&".$empregado->getNome()."&".$empregado->getCargo()->cargo."&".
  				                        $empregado->getEmail()."&".$empregado->getTelefone()."&".$empregado->getTelefoneCelular();
  			}
			$response->setContent(\Zend\Json\Json::encode(array('dataType' => 'json',
																'response' => true,
																'empregados' => $representantes)));
		}
		return $response;
	}
	
	public function buscainstituicoesAction()
	{
		$request = $this->getRequest();
		$response = $this->getResponse();
		$response->setContent(\Zend\Json\Json::encode(array('dataType' => 'json', 'response' => false)));
		if ($request->isPost()) {
			$instituicoes = $this->getEntityManager()->getRepository('Application\Model\Instituicao')->findBy(array(), array('razao' => 'ASC'));
			$instituicoesPesquisa = $this->getEntityManager()->getRepository('Application\Model\Instituicao')->findBy(array ('subcategoria' => 45), array('razao' => 'ASC'));
			$optionInstituicoes = "<option value=''>Selecione uma instituição</option>";
			foreach($instituicoes as $instituicao) {
				if(($instituicao->getRazao() !== "") && (strlen($instituicao->getCnpj()) >= 14))
					$optionInstituicoes .= "<option value='" . $instituicao->getCodigo () . "'>" . $instituicao->getRazao () . "</option>";
			}
			
				$optionInstituicoesPesquisa = "<option value=''>Selecione uma instituição</option>";
				foreach ( $instituicoesPesquisa as $instituicaoPesquisa ) {
					if(($instituicaoPesquisa->getRazao() !== "") && (strlen($instituicaoPesquisa->getCnpj()) >= 14)){
						$optionInstituicoesPesquisa .= "<option value='" . $instituicaoPesquisa->getCodigo () . "'>" . $instituicaoPesquisa->getRazao () . "</option>";
				}
				$response->setContent ( \Zend\Json\Json::encode ( array (
						'dataType' => 'json',
						'response' => true,
						'instituicoes' => $optionInstituicoes,
						'instituicoesPesquisa' => $optionInstituicoesPesquisa )));
			}		
		}	
		return $response;
		
	}
	
	public function buscainstituicaoprincipalAction()
	{
		$request = $this->getRequest();
		$response = $this->getResponse();
		$response->setContent(\Zend\Json\Json::encode(array('dataType' => 'json', 'response' => false)));
		if ($request->isPost()) {
			$implantacao = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default')->getRepository('Admin\Model\Implantacao')->findAll();
			$instituicao = "";
			foreach($implantacao as $i) {
				$instituicao = $this->getEntityManager()->find("Application\Model\Instituicao", $i->getInstituicao());
			}
			
 			$optionInstituicoes = "<option value=''>Selecione uma contraparte</option>";
			$optionInstituicoes .= "<option selected value='".$instituicao->getCodigo()."'>".$instituicao->getRazao()." - ".$instituicao->getCnpj()."</option>";
			$response->setContent(\Zend\Json\Json::encode(array('dataType' => 'json',
					'response' => true,
					'optionInstituicoes' => $optionInstituicoes)));
		}
		return $response;
	}
	
	public function buscadadosAction()
	{
		$request = $this->getRequest();
		$response = $this->getResponse();
		$response->setContent(\Zend\Json\Json::encode(array('dataType' => 'json', 'response' => false)));
		if ($request->isPost()) {
			$codigo = $this->params()->fromPost('codigo');
			$instituicao = $this->getEntityManager()->find("Application\Model\Instituicao", $codigo);
			
			$response->setContent(\Zend\Json\Json::encode(array('dataType' => 'json',
					'response'    => true,
					'razao'       => $instituicao->getRazao(),
					'fantasia'    => $instituicao->getFantasia(),
					'cnpj'        => $instituicao->getCnpj(),
					'ie'          => $instituicao->getInscricaoEstadual(),
					'endereco'    => $instituicao->getEndereco(),
					'bairro'	  => $instituicao->getBairro(),
					'caixaPostal' => $instituicao->getCaixaPostal(),
					'cidade'	  => $instituicao->getCidade(),
					'uf'		  => $instituicao->getUf(),
					'cep'		  => $instituicao->getCep(),
					'pais'		  => $instituicao->getPais(),
					'telefone1'   => $instituicao->getTelefone(),
					'telefone2'   => $instituicao->getTelefone2(),
					'telefone3'   => $instituicao->getTelefone3(),
					'fax'		  => $instituicao->getFax(),
					'email'		  => $instituicao->getEmail(),
					'homepage'    => $instituicao->getHomepage(),
					'observacao'  => $instituicao->getObservacao()
			)));
		}
		return $response;
	}
	
	public function saveAction()
	{  
		$form = new InstituicaoForm();
		$request = $this->getRequest();
		if ($request->isPost()) {
			$instituicao = new Instituicao();
			$form->setInputFilter ( $instituicao->getInputFilter () );
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$data = $form->getData();
				$cnpj = preg_replace('/[^0-9]/', '',  $this->params()->fromPost("cnpj"));
				unset($data['submit']);
				unset($data['cnpj']);
				
				//codigo para salvar seção caso haja alterações
				$session = $this->getServiceLocator()->get('Zend\ServiceManager\ServiceManager')->get('Session');
				$usuario = $session->offsetGet('user');
				$dataAtual = date("Y-m-d H:i:s");
				
				if (isset($data['codigo']) && $data['codigo'] > 0) {
					$instituicao = $this->getEntityManager()->find('Application\Model\Instituicao', $data['codigo']);
					//codigo para salvar seção caso haja alterações
					$instituicao->setAlteracao($usuario->getLogin());
					$instituicao->setDataAlteracao($dataAtual);
					$instituicao->setDataAtualizacao($dataAtual);
				}
				else {
					//codigo para salvar seção caso haja alterações
					$instituicao->setInclusao($usuario->getLogin());
					$instituicao->setDataInclusao($dataAtual);
					$instituicao->setRecebeNewsletter('N');
					$instituicao->setLideranca('N');
				}
				$instituicao->setData($data);
				$instituicao->setCnpj($cnpj);
				$instituicao->setTipoPessoa('Pessoa Jurídica');
				$this->getEntityManager()->persist($instituicao);
				$this->getEntityManager()->flush();
				return $this->redirect()->toUrl('/application/instituicao');
			} else {
			}
		}
		$codigo = (int) $this->params()->fromRoute('codigo', 0);
		if ($codigo > 0) {
			$instituicao = $this->getEntityManager()->find('Application\Model\Instituicao', $codigo);
			$form->bind($instituicao);
			$form->get('submit')->setAttribute('value', 'Edit');
		}
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.mask.js' );
		return new ViewModel(
			array('form' => $form
		));
	}	
}