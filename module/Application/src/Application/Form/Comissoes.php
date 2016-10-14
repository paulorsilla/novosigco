<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class Comissoes extends Form {
	public function __construct($em) {
		parent::__construct ( 'Comissoes' );
		$this->setHydrator ( new ClassMethods () );
		$this->setAttribute ( 'method', 'post' );
		$this->setAttribute ( 'action', '/application/comissoes/save' );
		
		$this->add ( array (
				'name' => 'id',
				'attributes' => array (
						'type' => 'hidden' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'numeroOs',
				'attributes' => array (
						'required' => true,
						'style' => 'width:800px',
						'type' => 'text',
						'id' => 'numeroOs' 
				),
				'options' => array (
						'label' => 'Numero de Ordem de Serviço:*' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'ano',
				'attributes' => array (
						'required' => true,
						'style' => 'width:800px',
						'type' => 'text',
						'id' => 'ano' 
				),
				'options' => array (
						'label' => 'Ano:*' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'descricao',
				'attributes' => array (
						'type' => 'textarea',
						'style' => 'width:815px',
						'rows' => '3',
						'id' => 'descricao',
						'required' => false 
				),
				'options' => array (
						'label' => 'descricao:*' 
				) 
		) );
		$this->add ( array (
				'name' => 'submit',
				'attributes' => array (
						'type' => 'submit',
						'value' => 'Enviar',
						'id' => 'submit',
				),
		));
	}
}