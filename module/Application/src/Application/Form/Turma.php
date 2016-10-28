<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;

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
		
		$this->add ( array (
				'name' => 'nome',
				'attributes' => array (
						'style' => 'width:780px',
						'type' => 'text',
						'required' => true 
				),
				'options' => array (
						'label' => 'Nome da turma:*' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'aplicacao',
				'type' => 'Zend\Form\Element\Select', 
				'attributes' => array (
						'id' => 'aplicacao',
						'style' => 'width:800px',
						'required' => false,
						'options' => array(
							'empty_option' => '--- Seleciona uma aplicação ---',
							'1' => 'À Distância',
							'2' => 'Presencial',
						),
				),
				'options' => array (
						'label' => 'Aplicação:' 
				) 
				
		) );
		
		$this->add ( array (
				'name' => 'inicial',
				'attributes' => array (
						'style' => 'width:100px',
						'type' => 'text',
						'id' => 'inicial',
						'required' => true 
				),
				'options' => array (
						'label' => 'Data Inicial:*' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'final',
				'attributes' => array (
						'style' => 'width:100px',
						'type' => 'text',
						'id' => 'final',
						'required' => true 
				),
				'options' => array (
						'label' => 'Data Final:*' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'valor',
				'attributes' => array (
						'style' => 'width:780px',
						'type' => 'text',
						'required' => false 
				),
				'options' => array (
						'label' => 'Valor:' 
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
						'id' => 'instituicao',
						'required' => true 
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
				'type' => 'DoctrineModule\Form\Element\ObjectSelect',
				'name' => 'coordenacao',
				'attributes' => array (
						'style' => 'width: 800px',
						'id' => 'coordenacao',
						'required' => true 
				),
				'options' => array (
						'label' => 'Coordenação técnica:*',
						'empty_option' => '--- Escolha um coordenador ---',
						'object_manager' => $em,
						'target_class' => 'Application\Model\Empregado',
						'property' => 'nome',
						'find_method' => array (
								'name' => 'getEmpregados' 
						) 
				) 
		) );
		
		$this->add ( array (
				'name' => 'instrutor',
				'type' => 'DoctrineModule\Form\Element\ObjectSelect',
				'attributes' => array (
						'style' => 'width:800px',
						'required' => false,
						'id' => 'instrutor' 
				),
				'options' => array (
						'label' => 'Instrutor:',
						'empty_option' => '--- Escolha um Instrutor ---',
						'object_manager' => $em,
						'target_class' => 'Application\Model\Instrutor',
						'property' => 'nome' 
				) 
		) );		
		
		$this->add ( array (
				'name' => 'dataRealizacao',
				'attributes' => array (
						'id' => 'dataRealizacao',
						'style' => 'width:210px',
						'type' => 'text',
						'required' => true
				),
				'options' => array (
						'label' => 'Data de realização:*'
				)
		) );
		
		$this->add ( array (
				'name' => 'horaInicial',
				'attributes' => array (
						'id' => 'horaInicial',
						'style' => 'width:250px',
						'type' => 'text',
						'required' => true
				),
				'options' => array (
						'label' => 'Horario de inicio:*'
				)
		) );
		
		$this->add ( array (
				'name' => 'horaFinal',
				'attributes' => array (
						'id' => 'horaFinal',
						'style' => 'width:250px',
						'type' => 'text',
						'required' => true
				),
				'options' => array (
					'label' => 'Horario final:*'
				)
		) );
		
		$this->add ( array (
				'name' => 'local',
				'attributes' => array (
						'id' => 'local',
						'style' => 'width:550px',
						'type' => 'text',
						'required' => true
				),
				'options' => array (
					'label' => 'Local de realização:*'
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