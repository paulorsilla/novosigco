<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Stdlib\Hydrator\ClassMethods;

class ListaEspera extends Form {
	public function __construct($em) {
		parent::__construct ( 'espera' );
		$this->setHydrator ( new ClassMethods () );
		$this->setAttribute ( 'method', 'post' );
		$this->setAttribute ( 'action', '/application/lista-espera/save' );
		
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
				'name' => 'submit',
				'attributes' => array (
						'type' => 'submit',
						'value' => 'Enviar',
						'id' => 'submit'
				)
		) );
		
	
	}
}