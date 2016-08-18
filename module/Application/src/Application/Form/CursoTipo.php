<?php

namespace Application\Form;

use Zend\Form\Form;

class CursoTipo extends Form {
	public function __construct() {
		parent::__construct ( 'CursoTipo' );
		$this->setAttribute ( 'method', 'post' );
		$this->setAttribute ( 'action', '/application/curso-tipo/save' );
		
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
						