<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Stdlib\Hydrator\ClassMethods;

class Competencia extends Form {
	public function __construct($em) {
		parent::__construct ( 'Competencia' );
		$this->setHydrator ( new ClassMethods () );
		$this->setAttribute ( 'method', 'post' );
		$this->setAttribute ( 'action', '/application/competencia/save' );
		
		$this->add(array(
				'name'=> 'id',
				'attributes' => array(
				'type' => 'hidden'
				),
		));			
		$this->add(array(
				'name' => 'titulo',
				'attributes' => array(
						'style' => 'width:800px',
						'type'=> 'text',
				),
				'options' => array(
						'label' => 'Competência:'
				)));
		
		$this->add ( array (
				'name' => 'modalidade',
		
		
				'type' => 'DoctrineModule\Form\Element\ObjectSelect',
				'attributes' => array (
						'style' => 'width:800px',
						'required' => true,
						'id' => 'modalidade'
				),
				'options' => array (
						'label' => 'Modalidade:*',
						'empty_option' => '--- Escolha uma modalidade ---',
						'object_manager' => $em,
						'target_class' => 'Application\Model\Modalidade',
						'property' => 'titulo'
				)
		) );
		$this->add(array(
				'name'=>'submit',
				'attributes' => array(
						'type'=>'submit',
						'value'=>'Enviar',
						'id'=>'submit',
				),
		));
	}
}

