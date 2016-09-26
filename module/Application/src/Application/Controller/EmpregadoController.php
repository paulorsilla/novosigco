<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\Empregado;
use Application\Form\Empregado as EmpregadoForm;
use Application\Model\EmpregadoAreaSubarea;
use Application\Model\EmpregadoCargo;
use Application\Model\EmpregadoFuncao;
use Application\Model\EmpregadoOutraFuncao;
use Application\Model\EmpregadoEquipeTecnica;
use Application\Model\EmpregadoSublotacao;
use Application\Model\EmpregadoEscolaridade;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Application;
use Application\Model\EmpregadoLotacaoAnterior;

/**
 * Controlador que gerencia os empregados da Embrapa Soja
 *
 * @category Application
 * @package Controller
 * @author Paulo R. Silla <paulo.silla@embrapa.br>
 * @author William Gerenutti <william.alves@colaborador.embrapa.br>
 *        
 */
class EmpregadoController extends ActionController {
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
			$this->em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_rh' );
		}
		return $this->em;
	}
	
	/**
	 * Mostra os empregados da Embrapa Soja cadastrados
	 *
	 * @return void
	 */
	public function indexAction() {
		// $empregados = $this->getEntityManager()->getRepository('Application\Model\EmpregadoSoja')->findBy(array('' => ), array('nome' => 'ASC'));
		$qb = $this->getEntityManager ()->createQueryBuilder ();
		$qb->select ( 'e' )->from ( 'Application\Model\Empregado', 'e' )->where ( 'e.matricula < 500000' )->andWhere ( 'e.ativo = :ativo' )->setParameter ( "ativo", "S" )->orderby ( 'e.nome' );
		$empregados = $qb->getQuery ()->getResult ();
		
		// adiciona os arquivos indexcomum.js e jquery.dataTable.min.js ao head da página
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		// $renderer->headScript()->appendFile('/js/indexcomum.js');
		return new ViewModel ( array (
				'empregados' => $empregados 
		) );
	}
	public function buscaempregadosAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$qb = $this->getEntityManager ()->createQueryBuilder ();
			$qb->select ( 'e' )->from ( 'Application\Model\Empregado', 'e' )->where ( 'e.matricula < 500000' )->andWhere ( 'e.ativo = :ativo' )->setParameter ( "ativo", "S" )->orderby ( 'e.nome' );
			$empregados = $qb->getQuery ()->getResult ();
			$stringEmpregados = '[';
			foreach ( $empregados as $key => $empregado ) { // array de tipoCompetencia definido na linha 60
				$stringEmpregados .= '{"matricula": "' . $empregado->getMatricula () . '", "nome": "' . $empregado->getNome () . '"}';
				if (isset ( $empregados [$key + 1] )) {
					$stringEmpregados .= ',';
				}
			}
			$stringEmpregados .= ']';
			$response->setContent ( \Zend\Json\Json::encode ( array (
					'dataType' => 'json',
					'response' => true,
					'empregados' => $stringEmpregados 
			) ) );
		}
		return $response;
	}
	public function buscaempregadoAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$matricula = $this->params ()->fromPost ( "matricula" );
			$empregado = $this->getEntityManager ()->find ( "Application\Model\Empregado", $matricula );
			$response->setContent ( \Zend\Json\Json::encode ( array (
					'dataType' => 'json',
					'response' => true,
					'empregado' => $empregado->getNome () 
			) ) );
		}
		return $response;
	}
	public function saveAction() {
		$form = new EmpregadoForm ();
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$matricula = $this->params ()->fromPost ( "matricula" );
			$matriculaSupervisor = $this->params ()->fromPost ( "supervisor" );
			$empregado = $this->getEntityManager ()->find ( 'Application\Model\Empregado', $matricula );
			$supervisor = $this->getEntityManager ()->find ( 'Application\Model\Empregado', $matriculaSupervisor );
			$empregado->setSupervisorSaad ( $supervisor );
			$this->getEntityManager ()->persist ( $empregado );
			$this->getEntityManager ()->flush ();
			
			// $form->setInputFilter ( $empregado->getInputFilter () );
			// $form->setData ( $request->getPost () );
			// if ($form->isValid ()) {
			// $data = $form->getData ();
			// unset ( $data ['submit'] );
			// if (isset ( $data ['matricula'] ) && $data ['matricula'] > 0) {
			// $empregado = $this->getEntityManager ()->find ( 'Application\Model\Empregado', $data ['matricula'] );
			// }
			// $empregado->setData ( $data );
			// $this->getEntityManager ()->persist ( $empregado );
			// $this->getEntityManager ()->flush ();
			
			// return $this->redirect ()->toUrl ( '/application/empregado' );
			// }
		}
		$id = ( int ) $this->params ()->fromRoute ( 'matricula', 0 );
		if ($id > 0) {
			$empregado = $this->getEntityManager ()->find ( 'Application\Model\Empregado', $id );
			$form->bind ( $empregado );
			$form->get ( 'submit' )->setAttribute ( 'value', 'Edit' );
		}
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/empregado.js' );
		$empregados = $this->getEntityManager ()->getRepository ( 'Application\Model\Empregado' )->getEmpregados ();
		$optionEmpregados = "";
		foreach ( $empregados as $e ) {
			if ($e == $empregado->getSupervisorSaad ()) {
				$optionEmpregados .= "<option value='" . $e->getMatricula () . "'selected>" . $e->getNome () . "</option>";
			} else {
				$optionEmpregados .= "<option value='" . $e->getMatricula () . "'>" . $e->getNome () . "</option>";
			}
		}
		return new ViewModel ( array (
				'form' => $form,
				'optionEmpregados' => $optionEmpregados 
		) );
	}
	public function addcargoAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
			
			$matricula = $this->params ()->fromPost ( 'matricula' );
			$cargo_id = $this->params ()->fromPost ( 'cargo' );
			
			$dataInicial = $this->params ()->fromPost ( "dataInicialCargo" );
			$dataFinal = $this->params ()->fromPost ( "dataFinalCargo" );
				
			if ($dataInicial != "") {
				$dataInicial = \DateTime::createFromFormat ( "d/m/Y", $dataInicial );
			} else {
				$dataInicial = null;
			}
			if ($dataFinal != "") {
				$dataFinal = \DateTime::createFromFormat ( "d/m/Y", $dataFinal ); 
			} else {
				$dataFinal = null;
			}
				
			$cargo = $em->find ( 'Application\Model\Cargo', $cargo_id );
			
			$id = $this->params ()->fromPost ( 'id' );
			if ($id > 0) {
				$empregadocargo = $em->find ( "Application\Model\EmpregadoCargo", $id );
			} else {
				$empregadocargo = new EmpregadoCargo ();
			}
				
			$empregadocargo->setEmpregado ( $matricula );
			$empregadocargo->setCargo ( $cargo );
			$empregadocargo->setDataInicial ( $dataInicial );
			$empregadocargo->setDataFinal ( $dataFinal );
			$em->persist ( $empregadocargo );
			$em->flush ();
				
			$response->setContent ( \Zend\Json\Json::encode ( array (
					'dataType' => 'json',
					'response' => true 
			) ) );
		}
		return $response;
	}
	public function addareasubareaAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
			
			$matricula = $this->params ()->fromPost ( 'matricula' );
			$area_id = $this->params ()->fromPost ( 'area' );
			$subarea_id = $this->params ()->fromPost ( 'subarea' );
			$dataInicial = \Admin\Model\Util::converteData ( $this->params ()->fromPost ( "dataInicialArea" ) );
			$dataFinal = \Admin\Model\Util::converteData ( $this->params ()->fromPost ( "dataFinalArea" ) );
			
			$area = $em->find ( 'Application\Model\Area', $area_id );
			$subarea = $em->find ( 'Application\Model\Subarea', $subarea_id );
			
			$id = $this->params ()->fromPost ( 'id' );
			if ($id > 0) {
				$empregadoareasubarea = $em->find ( "Application\Model\EmpregadoAreaSubarea", $id );
			} else {
				$empregadoareasubarea = new EmpregadoAreaSubarea ();
			}
			
			$empregadoareasubarea->setEmpregado ( $matricula );
			$empregadoareasubarea->setArea ( $area );
			$empregadoareasubarea->setSubarea ( $subarea );
			$empregadoareasubarea->setDataInicial ( $dataInicial );
			$empregadoareasubarea->setDataFinal ( $dataFinal );
			$em->persist ( $empregadoareasubarea );
			$em->flush ();
			
			$response->setContent ( \Zend\Json\Json::encode ( array (
					'dataType' => 'json',
					'response' => true 
			) ) );
		}
		return $response;
	}
	public function addfuncaoAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
			
			$matricula = $this->params ()->fromPost ( 'matricula' );
			$funcao_id = $this->params ()->fromPost ( 'funcao' );
			$dataInicial = \Admin\Model\Util::converteData ( $this->params ()->fromPost ( "dataInicialFuncao" ) );
			$dataFinal = \Admin\Model\Util::converteData ( $this->params ()->fromPost ( "dataFinalFuncao" ) );
			$funcao = $em->find ( 'Application\Model\Funcao', $funcao_id );
			
			$id = $this->params ()->fromPost ( 'id' );
			if ($id > 0) {
				$empregadofuncao = $em->find ( "Application\Model\EmpregadoFuncao", $id );
			} else {
				$empregadofuncao = new EmpregadoFuncao ();
			}
			
			$empregadofuncao->setEmpregado ( $matricula );
			$empregadofuncao->setFuncao ( $funcao );
			$empregadofuncao->setDataInicial ( $dataInicial );
			$empregadofuncao->setDataFinal ( $dataFinal );
			$em->persist ( $empregadofuncao );
			$em->flush ();
			
			$response->setContent ( \Zend\Json\Json::encode ( array (
					'dataType' => 'json',
					'response' => true 
			) ) );
		}
		return $response;
	}
	public function addoutrafuncaoAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
			
			$matricula = $this->params ()->fromPost ( 'matricula' );
			$outrafuncao_id = $this->params ()->fromPost ( 'outraFuncao' );
			$dataInicial = \Admin\Model\Util::converteData ( $this->params ()->fromPost ( "dataInicialOutraFuncao" ) );
			$dataFinal = \Admin\Model\Util::converteData ( $this->params ()->fromPost ( "dataFinalOutraFuncao" ) );
			$outraFuncao = $em->find ( 'Application\Model\OutraFuncao', $outrafuncao_id );
			$id = $this->params ()->fromPost ( 'id' );
			
			if ($id > 0) {
				$empregadooutrafuncao = $em->find ( "Application\Model\EmpregadoOutraFuncao", $id );
			} else {
				$empregadooutrafuncao = new EmpregadoOutraFuncao ();
			}
			
			$empregadooutrafuncao->setEmpregado ( $matricula );
			$empregadooutrafuncao->setOutraFuncao ( $outraFuncao );
			$empregadooutrafuncao->setDataInicial ( $dataInicial );
			$empregadooutrafuncao->setDataFinal ( $dataFinal );
			$em->persist ( $empregadooutrafuncao );
			$em->flush ();
			
			$response->setContent ( \Zend\Json\Json::encode ( array (
					'dataType' => 'json',
					'response' => true 
			) ) );
		}
		return $response;
	}
	public function addequipetecnicaAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
			
			$matricula = $this->params ()->fromPost ( 'matricula' );
			$equipeTecnicaId = $this->params ()->fromPost ( 'equipeTecnica' );
			$dataInicial = \Admin\Model\Util::converteData ( $this->params ()->fromPost ( "dataInicialEquipeTecnica" ) );
			$dataFinal = \Admin\Model\Util::converteData ( $this->params ()->fromPost ( "dataFinalEquipeTecnica" ) );
			$equipeTecnica = $em->find ( 'Application\Model\EquipeTecnica', $equipeTecnicaId );
			$id = $this->params ()->fromPost ( 'id' );
			
			if ($id > 0) {
				$empregadoequipetecnica = $em->find ( "Application\Model\EmpregadoEquipeTecnica", $id );
			} else {
				$empregadoequipetecnica = new EmpregadoEquipeTecnica ();
			}
			
			$empregadoequipetecnica->setEmpregado ( $matricula );
			$empregadoequipetecnica->setEquipeTecnica ( $equipeTecnica );
			$empregadoequipetecnica->setDataInicial ( $dataInicial );
			$empregadoequipetecnica->setDataFinal ( $dataFinal );
			$em->persist ( $empregadoequipetecnica );
			$em->flush ();
			
			$response->setContent ( \Zend\Json\Json::encode ( array (
					'dataType' => 'json',
					'response' => true 
			) ) );
		}
		return $response;
	}
	public function addsublotacaoAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
			
			$matricula = $this->params ()->fromPost ( 'matricula' );
			$sublotacaoId = $this->params ()->fromPost ( 'sublotacao' );
			$dataInicial = \Admin\Model\Util::converteData ( $this->params ()->fromPost ( "dataInicialSublotacao" ) );
			$dataFinal = \Admin\Model\Util::converteData ( $this->params ()->fromPost ( "dataFinalSublotacao" ) );
			$sublotacao = $em->find ( 'Application\Model\Sublotacao', $sublotacaoId );
			$id = $this->params ()->fromPost ( 'id' );
			
			if ($id > 0) {
				$empregadosublotacao = $em->find ( "Application\Model\EmpregadoSublotacao", $id );
			} else {
				$empregadosublotacao = new EmpregadoSublotacao ();
			}
			
			$empregadosublotacao->setEmpregado ( $matricula );
			$empregadosublotacao->setSublotacao ( $sublotacao );
			$empregadosublotacao->setDataInicial ( $dataInicial );
			$empregadosublotacao->setDataFinal ( $dataFinal );
			$em->persist ( $empregadosublotacao );
			$em->flush ();
			
			$response->setContent ( \Zend\Json\Json::encode ( array (
					'dataType' => 'json',
					'response' => true 
			) ) );
		}
		return $response;
	}
	public function addescolaridadeAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
			
			
			$matricula = $this->params ()->fromPost ( 'matricula' );
			$escolaridadeId = $this->params ()->fromPost ( 'escolaridade' );
			$instituicaoId = $this->params ()->fromPost ( 'instituicao' );
			$curso = $this->params ()->fromPost ( 'curso' );
			$anoconclusao = $this->params ()->fromPost ( 'anoconclusao' );
			error_log('aqui -->'.$anoconclusao);
			if ($anoconclusao == "")
				$anoconclusao = null;
			$escolaridade = $em->find ( 'Application\Model\Escolaridade', $escolaridadeId );
			$id = $this->params ()->fromPost ( 'id' );
			
			if ($id > 0) {
				$empregadoescolaridade = $em->find ( "Application\Model\EmpregadoEscolaridade", $id );
			} else {
				$empregadoescolaridade = new EmpregadoEscolaridade ();
			}
			
			$empregadoescolaridade->setEmpregado ( $matricula );
			$empregadoescolaridade->setEscolaridade ( $escolaridade );
			$empregadoescolaridade->setInstituicao ( $instituicaoId );
			$empregadoescolaridade->setCurso ( $curso );
			$empregadoescolaridade->setAnoConclusao ( $anoconclusao );
			$em->persist ( $empregadoescolaridade );
			$em->flush ();
				
			$response->setContent ( \Zend\Json\Json::encode ( array (
					
					'dataType' => 'json',
					'response' => true 
			) ) );
		}
		return $response;
	}
	public function addlotacaoanteriorAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
			$matricula = $this->params ()->fromPost ( 'matricula' );
			$instituicao_id = $this->params ()->fromPost ( 'instituicao' );
			$dataInicial = \Admin\Model\Util::converteData ( $this->params ()->fromPost ( "dataInicial" ) );
			$dataFinal = \Admin\Model\Util::converteData ( $this->params ()->fromPost ( "dataFinal" ) );
			// $cargo = $em->find ( 'Application\Model\Cargo', $cargo_id );
			
			$id = $this->params ()->fromPost ( 'id' );
			if ($id > 0) {
				$empregadolotacaoanterior = $em->find ( "Application\Model\EmpregadoLotacaoAnterior", $id );
			} else {
				$empregadolotacaoanterior = new EmpregadoLotacaoAnterior ();
			}
			
			$empregadolotacaoanterior->setEmpregado ( $matricula );
			$empregadolotacaoanterior->setInstituicao ( $instituicao_id );
			$empregadolotacaoanterior->setDataInicial ( $dataInicial );
			$empregadolotacaoanterior->setDataFinal ( $dataFinal );
			
			$em->persist ( $empregadolotacaoanterior );
			
			$em->flush ();
			
			$response->setContent ( \Zend\Json\Json::encode ( array (
					'dataType' => 'json',
					'response' => true 
			) ) );
		}
		return $response;
	}
	public function buscacargosAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
			$matricula = $this->params ()->fromPost ( 'matricula' );
			$empregadoCargos = $em->getRepository ( 'Application\Model\EmpregadoCargo' )->findBy ( array (
					'empregado' => $matricula 
			), array (
					'dataInicial' => 'DESC' 
			) );
			$cargos = array ();
			foreach ( $empregadoCargos as $empregadoCargo ) {
				($empregadoCargo->getDataInicial() != null) ? $dataInicial = $empregadoCargo->getDataInicial()->format("d/m/Y") : $dataInicial = "";
				($empregadoCargo->getDataFinal() != null) ? $dataFinal = $empregadoCargo->getDataFinal ()->format("d/m/Y"): $dataFinal = "";
				array_push ( $cargos, $empregadoCargo->getId () . ";" . $empregadoCargo->getCargo ()->getDescricao () . " - " . $empregadoCargo->getCargo ()->getPce () . ";" . $dataInicial . ";" . $dataFinal . ";" . $empregadoCargo->getCargo ()->getId () );
			}
			
			$response->setContent ( \Zend\Json\Json::encode ( array (
					'dataType' => 'json',
					'response' => true,
					'cargos' => $cargos 
			) ) );
		}
		return $response;
	}
	public function buscaareasAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
			$matricula = $this->params ()->fromPost ( 'matricula' );
			$empregadoAreas = $em->getRepository ( 'Application\Model\EmpregadoAreaSubarea' )->findBy ( array (
					'empregado' => $matricula 
			), array (
					'dataInicial' => 'DESC' 
			) );
			
			$areas = array ();
			foreach ( $empregadoAreas as $empregadoArea ) {
				$dataInicial = \Admin\Model\Util::converteData ( str_replace ( "-", "/", $empregadoArea->getDataInicial () ) );
				$dataFinal = \Admin\Model\Util::converteData ( str_replace ( "-", "/", $empregadoArea->getDataFinal () ) );
				array_push ( $areas, $empregadoArea->getId () . ";" . $empregadoArea->getArea ()->getDescricao () . ";" . $empregadoArea->getSubarea ()->getDescricao () . ";" . $dataInicial . ";" . $dataFinal . ";" . $empregadoArea->getArea ()->getId () . ";" . $empregadoArea->getSubarea ()->getId () );
			}
			
			$response->setContent ( \Zend\Json\Json::encode ( array (
					'dataType' => 'json',
					'response' => true,
					'areas' => $areas 
			) ) );
		}
		return $response;
	}
	public function buscafuncoesAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
			$matricula = $this->params ()->fromPost ( 'matricula' );
			$empregadoFuncoes = $em->getRepository ( 'Application\Model\EmpregadoFuncao' )->findBy ( array (
					'empregado' => $matricula 
			), array (
					'dataInicial' => 'DESC' 
			) );
			
			$funcoes = array ();
			foreach ( $empregadoFuncoes as $empregadoFuncao ) {
				$dataInicial = \Admin\Model\Util::converteData ( str_replace ( "-", "/", $empregadoFuncao->getDataInicial () ) );
				$dataFinal = \Admin\Model\Util::converteData ( str_replace ( "-", "/", $empregadoFuncao->getDataFinal () ) );
				array_push ( $funcoes, $empregadoFuncao->getId () . ";" . $empregadoFuncao->getFuncao ()->getDescricao () . ";" . $dataInicial . ";" . $dataFinal . ";" . $empregadoFuncao->getFuncao ()->getId () );
			}
			
			$response->setContent ( \Zend\Json\Json::encode ( array (
					'dataType' => 'json',
					'response' => true,
					'funcoes' => $funcoes 
			) ) );
		}
		return $response;
	}
	public function buscaoutrasfuncoesAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
			$matricula = $this->params ()->fromPost ( 'matricula' );
			$empregadoOutrasFuncoes = $em->getRepository ( 'Application\Model\EmpregadoOutraFuncao' )->findBy ( array (
					'empregado' => $matricula 
			), array (
					'dataInicial' => 'DESC' 
			) );
			
			$outrasFuncoes = array ();
			foreach ( $empregadoOutrasFuncoes as $empregadoOutraFuncao ) {
				$dataInicial = \Admin\Model\Util::converteData ( str_replace ( "-", "/", $empregadoOutraFuncao->getDataInicial () ) );
				$dataFinal = \Admin\Model\Util::converteData ( str_replace ( "-", "/", $empregadoOutraFuncao->getDataFinal () ) );
				array_push ( $outrasFuncoes, $empregadoOutraFuncao->getId () . ";" . $empregadoOutraFuncao->getOutraFuncao ()->getDescricao () . ";" . $dataInicial . ";" . $dataFinal . ";" . $empregadoOutraFuncao->getOutraFuncao ()->getId () );
			}
			
			$response->setContent ( \Zend\Json\Json::encode ( array (
					'dataType' => 'json',
					'response' => true,
					'outrasFuncoes' => $outrasFuncoes 
			) ) );
		}
		return $response;
	}
	public function buscaequipestecnicasAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
			$matricula = $this->params ()->fromPost ( 'matricula' );
			$empregadoEquipesTecnicas = $em->getRepository ( 'Application\Model\EmpregadoEquipeTecnica' )->findBy ( array (
					'empregado' => $matricula 
			), array (
					'dataInicial' => 'DESC' 
			) );
			
			$equipesTecnicas = array ();
			foreach ( $empregadoEquipesTecnicas as $empregadoEquipeTecnica ) {
				$dataInicial = \Admin\Model\Util::converteData ( str_replace ( "-", "/", $empregadoEquipeTecnica->getDataInicial () ) );
				$dataFinal = \Admin\Model\Util::converteData ( str_replace ( "-", "/", $empregadoEquipeTecnica->getDataFinal () ) );
				array_push ( $equipesTecnicas, $empregadoEquipeTecnica->getId () . ";" . $empregadoEquipeTecnica->getEquipeTecnica ()->getDescricao () . ";" . $dataInicial . ";" . $dataFinal . ";" . $empregadoEquipeTecnica->getEquipeTecnica ()->getId () );
			}
			
			$response->setContent ( \Zend\Json\Json::encode ( array (
					'dataType' => 'json',
					'response' => true,
					'equipesTecnicas' => $equipesTecnicas 
			) ) );
		}
		return $response;
	}
	public function buscasublotacoesAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
			$matricula = $this->params ()->fromPost ( 'matricula' );
			$empregadoSublotacoes = $em->getRepository ( 'Application\Model\EmpregadoSublotacao' )->findBy ( array (
					'empregado' => $matricula 
			), array (
					'dataInicial' => 'DESC' 
			) );
			
			$sublotacoes = array ();
			foreach ( $empregadoSublotacoes as $empregadoSublotacao ) {
				$dataInicial = \Admin\Model\Util::converteData ( str_replace ( "-", "/", $empregadoSublotacao->getDataInicial () ) );
				$dataFinal = \Admin\Model\Util::converteData ( str_replace ( "-", "/", $empregadoSublotacao->getDataFinal () ) );
				array_push ( $sublotacoes, $empregadoSublotacao->getId () . ";" . $empregadoSublotacao->getSublotacao ()->getDescricao () . ";" . $dataInicial . ";" . $dataFinal . ";" . $empregadoSublotacao->getSublotacao ()->getId () . ";" . $empregadoSublotacao->getSublotacao ()->getSigla () );
			}
			
			$response->setContent ( \Zend\Json\Json::encode ( array (
					'dataType' => 'json',
					'response' => true,
					'sublotacoes' => $sublotacoes 
			) ) );
		}
		return $response;
	}
	public function buscaescolaridadesAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
			$em2 = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_nco' );
			$matricula = $this->params ()->fromPost ( 'matricula' );
			$empregadoEscolaridades = $em->getRepository ( 'Application\Model\EmpregadoEscolaridade' )->findBy ( array (
					'empregado' => $matricula 
			), array (
					'anoConclusao' => 'DESC' 
			) );
			$escolaridades = array ();
			foreach ( $empregadoEscolaridades as $empregadoEscolaridade ) {
				// $dataInicial = \Admin\Model\Util::converteData ( str_replace ( "-", "/", $empregadoEscolaridade->getDataInicial () ) );
				// $dataConclusao = \Admin\Model\Util::converteData ( str_replace ( "-", "/", $empregadoEscolaridade->getDataConclusao () ) );
				$instituicao = $em2->find ( "Application\Model\Instituicao", $empregadoEscolaridade->getInstituicao () );
				if ($instituicao) {
					$razaoInstituicao = $instituicao->getRazao ();
					$codigoInstituicao = $instituicao->getCodigo ();
				} else {
					$razaoInstituicao = "";
					$codigoInstituicao = null;
				}
				array_push ( $escolaridades, $empregadoEscolaridade->getId () . ";" . $empregadoEscolaridade->getEscolaridade ()->getDescricao () . ";" . $razaoInstituicao . ";" . $empregadoEscolaridade->getCurso () . ";" . $empregadoEscolaridade->getAnoConclusao () . ";" . $empregadoEscolaridade->getEscolaridade ()->getId () . ";" . $codigoInstituicao );
			}
			$response->setContent ( \Zend\Json\Json::encode ( array (
					'dataType' => 'json',
					'response' => true,
					'escolaridades' => $escolaridades 
			) ) );
		}
		return $response;
	}
	public function buscalotacoesanterioresAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
			$em2 = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_nco' );
			$matricula = $this->params ()->fromPost ( 'matricula' );
			$empregadosLotacoesAnteriores = $em->getRepository ( 'Application\Model\EmpregadoLotacaoAnterior' )->findBy ( array (
					'empregado' => $matricula 
			), array (
					'dataInicial' => 'DESC' 
			) );
			$lotacoes = array ();
			foreach ( $empregadosLotacoesAnteriores as $empregadoLotacaoAnterior ) {
				$instituicao = $em2->find ( "Application\Model\Instituicao", $empregadoLotacaoAnterior->getInstituicao () );
				if ($instituicao) {
					$razaoInstituicao = $instituicao->getRazao ();
					$codigoInstituicao = $instituicao->getCodigo ();
				} else {
					$razaoInstituicao = "";
					$codigoInstituicao = null;
				}
				$dataInicial = \Admin\Model\Util::converteData ( str_replace ( "-", "/", $empregadoLotacaoAnterior->getDataInicial () ) );
				$dataFinal = \Admin\Model\Util::converteData ( str_replace ( "-", "/", $empregadoLotacaoAnterior->getDataFinal () ) );
				array_push ( $lotacoes, $empregadoLotacaoAnterior->getId () . ";" . $razaoInstituicao . ";" . $codigoInstituicao . ";" . $dataInicial . ";" . $dataFinal );
			}
			
			$response->setContent ( \Zend\Json\Json::encode ( array (
					'dataType' => 'json',
					'response' => true,
					'lotacoes' => $lotacoes 
			) ) );
		}
		return $response;
	}
	public function deletecargoAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
			$id = $this->params ()->fromPost ( 'id' );
			$empregadoCargo = $em->find ( 'Application\Model\EmpregadoCargo', $id );
			if ($empregadoCargo) {
				$em->remove ( $empregadoCargo );
				$em->flush ();
				$response->setContent ( \Zend\Json\Json::encode ( array (
						'dataType' => 'json',
						'response' => true 
				) ) );
			}
		}
		return $response;
	}
	public function deleteareaAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
			$id = $this->params ()->fromPost ( 'id' );
			$empregadoArea = $em->find ( 'Application\Model\EmpregadoAreaSubarea', $id );
			if ($empregadoArea) {
				$em->remove ( $empregadoArea );
				$em->flush ();
				$response->setContent ( \Zend\Json\Json::encode ( array (
						'dataType' => 'json',
						'response' => true 
				) ) );
			}
		}
		return $response;
	}
	public function deletefuncaoAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
			$id = $this->params ()->fromPost ( 'id' );
			$empregadoFuncao = $em->find ( 'Application\Model\EmpregadoFuncao', $id );
			if ($empregadoFuncao) {
				$em->remove ( $empregadoFuncao );
				$em->flush ();
				$response->setContent ( \Zend\Json\Json::encode ( array (
						'dataType' => 'json',
						'response' => true 
				) ) );
			}
		}
		return $response;
	}
	public function deleteoutrafuncaoAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
			$id = $this->params ()->fromPost ( 'id' );
			$empregadoOutraFuncao = $em->find ( 'Application\Model\EmpregadoOutraFuncao', $id );
			if ($empregadoOutraFuncao) {
				$em->remove ( $empregadoOutraFuncao );
				$em->flush ();
				$response->setContent ( \Zend\Json\Json::encode ( array (
						'dataType' => 'json',
						'response' => true 
				) ) );
			}
		}
		return $response;
	}
	public function deleteequipetecnicaAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
			$id = $this->params ()->fromPost ( 'id' );
			$empregadoEquipeTecnica = $em->find ( 'Application\Model\EmpregadoEquipeTecnica', $id );
			if ($empregadoEquipeTecnica) {
				$em->remove ( $empregadoEquipeTecnica );
				$em->flush ();
				$response->setContent ( \Zend\Json\Json::encode ( array (
						'dataType' => 'json',
						'response' => true 
				) ) );
			}
		}
		return $response;
	}
	public function deletesublotacaoAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
			$id = $this->params ()->fromPost ( 'id' );
			$empregadoSublotacao = $em->find ( 'Application\Model\EmpregadoSublotacao', $id );
			if ($empregadoSublotacao) {
				$em->remove ( $empregadoSublotacao );
				$em->flush ();
				$response->setContent ( \Zend\Json\Json::encode ( array (
						'dataType' => 'json',
						'response' => true 
				) ) );
			}
		}
		return $response;
	}
	public function deleteescolaridadeAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
			$id = $this->params ()->fromPost ( 'id' );
			$empregadoEscolaridade = $em->find ( 'Application\Model\EmpregadoEscolaridade', $id );
			if ($empregadoEscolaridade) {
				$em->remove ( $empregadoEscolaridade );
				$em->flush ();
				$response->setContent ( \Zend\Json\Json::encode ( array (
						'dataType' => 'json',
						'response' => true 
				) ) );
			}
		}
		return $response;
	}
	public function deletelotacaoanteriorAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
			$id = $this->params ()->fromPost ( 'id' );
			$empregadoLotacaoAnterior = $em->find ( 'Application\Model\EmpregadoLotacaoAnterior', $id );
			if ($empregadoLotacaoAnterior) {
				$em->remove ( $empregadoLotacaoAnterior );
				$em->flush ();
				$response->setContent ( \Zend\Json\Json::encode ( array (
						'dataType' => 'json',
						'response' => true 
				) ) );
			}
		}
		return $response;
	}
}
