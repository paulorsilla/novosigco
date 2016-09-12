<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Stdlib\Hydrator\ClassMethods;

class ListaEspera extends Form {
	public function __construct($em) {
		parent::__construct ( 'Capacitacao' );
		$this->setHydrator ( new ClassMethods () );
		$this->setAttribute ( 'method', 'post' );
		$this->setAttribute ( 'action', '/application/capacitacao/save' );
		
		$this->add ( array (
				'name' => 'id',
				'attributes' => array (
						'type' => 'hidden',
						'id' => 'id' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'capacitacao',
				
				'type' => 'DoctrineModule\Form\Element\ObjectSelect',
				'attributes' => array (
						'style' => 'width:800px',
						'required' => true,
						'id' => 'capacitacao' 
				),
				'options' => array (
						'label' => 'Capacitação:*',
						'empty_option' => '--- Escolha um Tipo ---',
						'object_manager' => $em,
						'target_class' => 'Application\Model\Capacitacao',
						'property' => 'descricao' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'prioridade',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array (
						'style' => 'width:820px',
						'required' => true 
				),
				'options' => array (
						'label' => 'prioridade',
						'options' => array (
								'' => 'Selecione a prioridade',
								'1' => '1',
								'2' => '2',
								'3' => '3',
								'4' => '4',
								'5' => '5' 
						) 
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
}