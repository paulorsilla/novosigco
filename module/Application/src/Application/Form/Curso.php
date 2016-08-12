<?php
namespace Application\Form;

use Zend\Form\Form;

class Curso extends Form{
	public function __construct()
	{
		parent::__construct('Curso');
		$this->setAttribute('method', 'post');
		$this->setAttribute('action', '/application/curso/save');
	
		$this->add(array(
				'name'=> 'id',
				'attributes' => array(
						'type' => 'hidden',
						'id' => 'id'
				),
		));
	
		$this->add(array(
				'name' => 'descricao',
				'attributes' => array(
						'style' => 'width:800px',
						'type'=> 'text',
				),
				'options' => array(
						'label' => 'Descricao:'
				)));

		$this->add(array(
				'name' => 'cargaHoraria',
				'attributes' => array(
						'type'=> 'text',
						'style' => 'width:800px',
				),
				'options' => array(
						'label' => 'Carga horaria:',
				)
		));
		$this->add(array(
				'name' => 'modalidadeCapacitacao',
				'attributes' => array(
						'style' => 'width:800px',
						'type'=> 'text',
				),
				'options' => array(
						'label' => 'Modalidade de capacitação:'
				)));
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
