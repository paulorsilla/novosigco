<?php
namespace Application\Form;

use Zend\Form\Form;

class Competencia extends Form{
	public function __construct()
	{
		parent::__construct('Competencia');
		$this->setAttribute('method', 'post');
		$this->setAttribute('action', '/application/competencia/save');
		
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
		
		$this->add(array(
						'name' => 'tipoCompetencia',
						'type' => 'Zend\Form\Element\Select',
						'attributes' => array(
								'style' => 'width:820px',
								'required' => true,
						),
						'options' => array(
								'label'   => 'Tipo de Competência',
								'options' => array(
										'' => 'Selecione a Competência',
										'1' => 'Competência Comportamental',
										'2' => 'Competência Gerencial',
										'3' => 'Competência Técnica'
								),
						),
				));
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

