<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Stdlib\Hydrator\ClassMethods;

class Capacitacao extends Form {
	public function __construct($em) {
		parent::__construct ( 'ListaEspera' );
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
				'name' => 'descricao',
				'attributes' => array (
						'required' => true,
						'style' => 'width:800px',
						'type' => 'text',
						'id' => 'descricao' 
				),
				'options' => array (
						'label' => 'Descricao:' 
				) 
		) );
		
		
		$this->add ( array (
				'name' => 'capacitacaoTipo',
				
				
				'type' => 'DoctrineModule\Form\Element\ObjectSelect',
				'attributes' => array (
						'style' => 'width:800px',
						'required' => true,
						'id' => 'capacitacaoTipo' 
				),
				'options' => array (
						'label' => 'Tipo de capacitação:*',
						'empty_option' => '--- Escolha um Tipo ---',
						'object_manager' => $em,
						'target_class' => 'Application\Model\CapacitacaoTipo',
						'property' => 'descricao' 
				) 
		) );
		
// 		$this->add ( array (
// 				'name' => 'cargaHoraria',
// 				'attributes' => array (
// 						'required' => true,
// 						'type' => 'text',
// 						'id' => 'cargaHoraria',
// 						'style' => 'width:800px'
// 				),
// 				'options' => array (
// 						'label' => 'Carga horaria:'
// 				)
// 		) );
		
		
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
