<?php

namespace Application\Form;

use Zend\Form\Form;

class CapacitacaoTipo extends Form {
	public function __construct() {
		parent::__construct ( 'CapacitacaoTipo' );
		$this->setAttribute ( 'method', 'post' );
		$this->setAttribute ( 'action', '/application/capacitacao-tipo/save' );
		
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
						'style' => 'width:800px',
						'type' => 'text' 
				),
				'options' => array (
						'label' => 'Descricao:' 
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
						