<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Stdlib\Hydrator\ClassMethods;
use Application\Validator\Cpf;
use Zend\InputFilter\InputFilterProviderInterface;

class Facilitador extends Form implements InputFilterProviderInterface {
	public function __construct($em) {
		parent::__construct ( 'Facilitador' );
		$this->setHydrator ( new ClassMethods () );
		$this->setAttribute ( 'method', 'post' );
		$this->setAttribute ( 'action', '/application/facilitador/save' );
		
		$this->add ( array (
				'name' => 'id',
				'attributes' => array (
						'type' => 'hidden' 
				) 
		) );
		$this->add ( array (
				'type' => 'DoctrineModule\Form\Element\ObjectSelect',
				'name' => 'instituicao',
				'attributes' => array (
						'style' => 'width: 400px',
						'id' => 'instituicao' 
				),
				'options' => array (
						'label' => 'Instituição',
						'empty_option' => '--- Escolha uma instituição ---',
						'object_manager' => $em,
						'target_class' => 'Application\Model\Instituicao',
						'property' => 'razao',
						'find_method' => array (
								'name' => 'getInstituicoes' 
						) 
				) 
		) );
		$this->add ( array (
				'name' => 'cpf',
				'attributes' => array (
						'type' => 'text',
						'style' => 'width:800px',
						'required' => true,
						'id' => 'cpf' 
				),
				'options' => array (
						'label' => 'CPF:*' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'nome',
				'attributes' => array (
						'required' => true,
						'style' => 'width:800px',
						'type' => 'text',
						'id' => 'nome' 
				),
				'options' => array (
						'label' => 'Nome:*' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'nascimento',
				'attributes' => array (
						'required' => true,
						'style' => 'width:800px',
						'type' => 'text',
						'id' => 'nascimento' 
				),
				'options' => array (
						'label' => 'Data de nascimento:*' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'email',
				'attributes' => array (
						'required' => true,
						'style' => 'width:800px',
						'type' => 'Zend\Form\Element\Email' 
				),
				'options' => array (
						'label' => 'Email:' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'telefone',
				'attributes' => array (
						'style' => 'width:800px',
						'type' => 'text',
						'id' => 'telefone' 
				),
				'options' => array (
						'label' => 'Telefone:' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'celular',
				'attributes' => array (
						'required' => true,
						'style' => 'width:800px',
						'type' => 'text',
						'id' => 'celular' 
				),
				'options' => array (
						'label' => 'Telefone celular:' 
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
						'name' => 'cpf',
						'required' => true,
						'validators' => array (
								array (
										'name' => 'Application\Validator\Cpf' 
								) 
						) 
				) 
		);
	}
}