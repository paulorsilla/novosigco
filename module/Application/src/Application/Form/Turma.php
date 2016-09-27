<?php
namespace Application\Form;

use Zend\Form\Form;

class Turma extends Form{
	public function __construct($em)
	{
		parent::__construct('Turma');
		$this->setAttribute('method', 'post');
		$this->setAttribute('action', '/application/turma/save');

		$this->add(array(
				'name'=> 'id',
				'attributes' => array(
						'type' => 'hidden'
				),
		));

		$this->add ( array (
				'name' => 'instituicao',


				'type' => 'DoctrineModule\Form\Element\ObjectSelect',
				'attributes' => array (
						'style' => 'width:800px',
						'required' => true,
						'id' => 'instituicao'
				),
				'options' => array (
						'label' => 'Instituicao*',
						'empty_option' => '--- Escolha uma Instituicao ---',
						'object_manager' => $em,
						'target_class' => 'Application\Model\Instituicao',
						'property' => 'razao'
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