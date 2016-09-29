<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Stdlib\Hydrator\ClassMethods;

class Turma extends Form {
	public function __construct($em) {
		parent::__construct ( 'Turma' );
		$this->setAttribute ( 'method', 'post' );
		$this->setAttribute ( 'action', '/application/turma/save' );
		
		$this->add ( array (
				'name' => 'id',
				'attributes' => array (
						'type' => 'hidden' 
				) 
		) );
		
		$this->add(array(
				'name' => 'nome',
				'attributes' => array(
						'style' => 'width:780px',
						'type'=> 'text',
				),
				'options' => array(
						'label' => 'Nome da turma:'
				)));
		
		$this->add(array(
				'name' => 'forma',
				'attributes' => array(
						'style' => 'width:780px',
						'type'=> 'text',
				),
				'options' => array(
						'label' => 'Aplicação:'
				)));
		
		$this->add(array(
				'name' => 'local',
				'attributes' => array(
						'style' => 'width:780px',
						'type'=> 'text',
				),
				'options' => array(
						'label' => 'Local:'
				)));
		$this->add(array(
				'name' => 'inicial',
				'attributes' => array(
						'style' => 'width:100px',
						'type'=> 'text',
						'id' => 'inicial',
				),
				'options' => array(
						'label' => 'Data Inicial:'
				)));
		
		$this->add(array(
				'name' => 'final',
				'attributes' => array(
						'style' => 'width:100px',
						'type'=> 'text',
						'id' => 'final',
				),
				'options' => array(
						'label' => 'Data Final:'
				)));
		
		$this->add(array(
				'name' => 'valor',
				'attributes' => array(
						'style' => 'width:780px',
						'type'=> 'text',
				),
				'options' => array(
						'label' => 'Valor:'
				)));
		
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
						'empty_option' => '--- Escolha uma Capacitação ---',
						'object_manager' => $em,
						'target_class' => 'Application\Model\Capacitacao',
						'property' => 'descricao' 
				) 
		) );
		
		$this->add ( array (
				'type' => 'DoctrineModule\Form\Element\ObjectSelect',
				'name' => 'instituicao',
				'attributes' => array (
						'style' => 'width: 800px',
						'id' => 'instituicao' 
				),
				'options' => array (
						'label' => 'Instituição:*',
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
				'name' => 'instrutor',
				
				'type' => 'DoctrineModule\Form\Element\ObjectSelect',
				'attributes' => array (
						'style' => 'width:800px',
						'required' => true,
						'id' => 'instrutor' 
				),
				'options' => array (
						'label' => 'Instrutor:*',
						'empty_option' => '--- Escolha um Instrutor ---',
						'object_manager' => $em,
						'target_class' => 'Application\Model\Instrutor',
						'property' => 'nome' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'submit',
				'attributes' => array (
						'type' => 'submit',
						'value'=>'Enviar',
						'id'=>'submit',
				),
		));
	}
}