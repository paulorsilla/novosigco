<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Stdlib\Hydrator\ClassMethods;
use Application\Validator\Cnpj;
use Zend\InputFilter\InputFilterProviderInterface;

class Instituicao extends Form implements InputFilterProviderInterface {
	
	public function __construct() {
		parent::__construct ( 'Instituicao' );
		$this->setHydrator ( new ClassMethods () );
		$this->setAttribute ( 'method', 'post' );
		$this->setAttribute ( 'action', '/application/instituicao/save' );
		
		$this->add ( array (
				'name' => 'codigo',
				'attributes' => array (
						'type' => 'hidden' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'razao',
				'attributes' => array (
						'type' => 'text',
						'style' => 'width:800px',
						'required' => true, 
						'id' => 'razao' 
				),
				'options' => array (
						'label' => 'Razão Social:*' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'cnpj',
				'attributes' => array (
						'type' => 'text',
						'style' => 'width:800px',
						'required' => true,
						'id' => 'cnpj' 
				),
				'options' => array (
						'label' => 'CNPJ:*' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'endereco',
				'attributes' => array (
						'type' => 'text',
						'style' => 'width:800px',
						'required' => true,
						'id' => 'endereco' 
				),
				'options' => array (
						'label' => 'Endereço:*' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'caixaPostal',
				'attributes' => array (
						'type' => 'text',
						'style' => 'width:800px',
						'required' => false,
						'id' => 'caixaPostal' 
				),
				'options' => array (
						'label' => 'Caixa Postal:' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'cidade',
				'attributes' => array (
						'type' => 'text',
						'style' => 'width:800px',
						'required' => true, 
						'id' => 'cidade' 
				),
				'options' => array (
						'label' => 'Cidade:' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'pais',
				'attributes' => array (
						'type' => 'text',
						'style' => 'width:800px',
						'required' => true,
						'id' => 'pais' 
				),
				'options' => array (
						'label' => 'País:' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'email',
				'attributes' => array (
						'type' => 'text',
						'style' => 'width:800px',
						'required' => true, 
						'type' => 'Zend\Form\Element\Email',
						'id' => 'email' 
				),
				'options' => array (
						'label' => 'Email:*' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'observacao',
				'attributes' => array (
						'type' => 'text',
						'style' => 'width:800px',
						'required' => false,
						'id' => 'observacao' 
				),
				'options' => array (
						'label' => 'Observação:' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'fantasia',
				'attributes' => array (
						'type' => 'text',
						'style' => 'width:800px',
						'required' => true, 
						'id' => 'fantasia' 
				),
				'options' => array (
						'label' => 'Nome Fantasia:' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'inscricaoEstadual',
				'attributes' => array (
						'type' => 'text',
						'style' => 'width:800px',
						'required' => false, 
						'id' => 'inscricaoEstadual' 
				),
				'options' => array (
						'label' => 'Inscrição Estadual:*' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'bairro',
				'attributes' => array (
						'type' => 'text',
						'style' => 'width:800px',
						'required' => true, 
						'id' => 'bairro' 
				),
				'options' => array (
						'label' => 'Bairro:' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'cep',
				'attributes' => array (
						'type' => 'text',
						'style' => 'width:800px',
						'required' => true, 
						'id' => 'cep' 
				),
				'options' => array (
						'label' => 'CEP:' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'uf',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array (
						'style' => 'width:818px',
						'required' => true, 
						'id' => 'uf' 
				),
				'options' => array (
						'label' => 'UF:',
						'options' => \Admin\Model\Util::getEstadosBr () 
				) 
		) );
		
		$this->add ( array (
				'name' => 'telefone',
				'attributes' => array (
						'type' => 'text',
						'style' => 'width:800px',
						'required' => true, 
						'id' => 'telefone' 
				),
				'options' => array (
						'label' => 'Telefone:' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'homepage',
				'attributes' => array (
						'type' => 'text',
						'style' => 'width:800px',
						'required' => false,
						'id' => 'homepage' 
				),
				'options' => array (
						'label' => 'Homepage:' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'submit',
				'attributes' => array (
						'type' => 'submit',
						'value' => 'Enviar',
						'id' => 'submit' 
				) 
		) );
	}
	
	public function getInputFilterSpecification() {
		return array (
				array (
						'name' => 'cnpj',
						'required' => true,
						'validators' => array (
								array (
										'name' => 'Application\Validator\Cnpj' 
								) 
						) 
				) 
		);
	}
}