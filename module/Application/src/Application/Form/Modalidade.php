<?php
namespace Application\Form;

use Zend\Form\Form;

class Modalidade extends Form{
	public function __construct()
	{
		parent::__construct('Modalidade');
		$this->setAttribute('method', 'post');
		$this->setAttribute('action', '/application/modalidade/save');

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
						'label' => 'Titulo da modalidade:'
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

